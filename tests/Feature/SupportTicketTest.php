<?php

namespace Tests\Feature;

use App\Livewire\Support\MyTickets;
use App\Livewire\Support\TicketQueue;
use App\Livewire\Support\TicketShow;
use App\Models\Member;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NewTicketNotification;
use App\Notifications\TicketReplyNotification;
use App\Notifications\TicketResolvedNotification;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class SupportTicketTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    protected function makeActiveMember(array $overrides = []): Member
    {
        $user = User::factory()->create();
        $user->assignRole('member');

        return Member::factory()->create(array_merge([
            'user_id' => $user->id,
            'status' => 'active',
        ], $overrides));
    }

    protected function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    public function test_member_can_raise_a_ticket_and_handlers_are_notified(): void
    {
        Notification::fake();
        $member = $this->makeActiveMember();
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($member->user)
            ->test(MyTickets::class)
            ->call('openCreate')
            ->set('category', 'loan')
            ->set('subject', 'My loan installment looks wrong')
            ->set('body', 'The deducted amount does not match my schedule.')
            ->call('save');

        $ticket = Ticket::firstOrFail();
        $this->assertStringStartsWith('TCK/', $ticket->ticket_no);
        $this->assertSame($member->id, $ticket->member_id);
        $this->assertSame($member->user->id, $ticket->raised_by);
        $this->assertSame('open', $ticket->status);
        $this->assertSame(1, $ticket->messages()->count());

        Notification::assertSentTo($treasurer, NewTicketNotification::class);
    }

    public function test_staff_can_raise_a_ticket_on_behalf_of_a_member(): void
    {
        $member = $this->makeActiveMember(['full_name' => 'Jane Doe', 'staff_id' => 'FCET-9911']);
        $secretary = $this->makeUserWithRole('secretary');

        Livewire::actingAs($secretary)
            ->test(TicketQueue::class)
            ->call('openCreate')
            ->set('memberSearch', 'Jane')
            ->set('selectedMemberId', (string) $member->id)
            ->set('category', 'general')
            ->set('subject', 'Phoned in a complaint')
            ->set('body', 'Member called about a change of address delay.')
            ->call('save');

        $ticket = Ticket::firstOrFail();
        $this->assertSame($member->id, $ticket->member_id);
        $this->assertSame($secretary->id, $ticket->raised_by);
    }

    public function test_a_confidential_ticket_is_hidden_from_ordinary_handlers_but_visible_to_the_chairman(): void
    {
        $member = $this->makeActiveMember();
        $treasurer = $this->makeUserWithRole('treasurer');
        $chairman = $this->makeUserWithRole('chairman');

        Livewire::actingAs($member->user)
            ->test(MyTickets::class)
            ->call('openCreate')
            ->set('category', 'staff_conduct')
            ->set('subject', 'Complaint about a staff member')
            ->set('body', 'Sensitive details here.')
            ->set('is_confidential', true)
            ->call('save');

        $ticket = Ticket::firstOrFail();
        $this->assertTrue($ticket->is_confidential);

        try {
            Livewire::actingAs($treasurer)->test(TicketShow::class, ['ticket' => $ticket]);
            $this->fail('Expected an ordinary handler to be blocked from a confidential ticket.');
        } catch (\Throwable $e) {
            // Expected.
        }

        Livewire::actingAs($chairman)->test(TicketShow::class, ['ticket' => $ticket])->assertOk();

        // The confidential queue tab must also be off-limits to non-Chairman staff.
        try {
            Livewire::actingAs($treasurer)->test(TicketQueue::class)->call('setTab', 'confidential');
            $this->fail('Expected the Treasurer to be blocked from the confidential tab.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_an_unrelated_member_cannot_view_someone_elses_ticket(): void
    {
        $owner = $this->makeActiveMember();
        $stranger = $this->makeActiveMember();

        Livewire::actingAs($owner->user)
            ->test(MyTickets::class)
            ->call('openCreate')
            ->set('subject', 'Test')
            ->set('body', 'Test body')
            ->call('save');

        $ticket = Ticket::firstOrFail();

        try {
            Livewire::actingAs($stranger->user)->test(TicketShow::class, ['ticket' => $ticket]);
            $this->fail('Expected an unrelated member to be blocked.');
        } catch (\Throwable $e) {
            // Expected.
        }
    }

    public function test_claim_and_reply_moves_status_to_in_progress_and_notifies_the_member(): void
    {
        Notification::fake();
        $member = $this->makeActiveMember();
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($member->user)
            ->test(MyTickets::class)
            ->call('openCreate')
            ->set('subject', 'Test')
            ->set('body', 'Test body')
            ->call('save');

        $ticket = Ticket::firstOrFail();

        Livewire::actingAs($treasurer)
            ->test(TicketShow::class, ['ticket' => $ticket])
            ->call('claim')
            ->set('replyBody', 'Looking into this now.')
            ->call('reply');

        $ticket->refresh();
        $this->assertSame('in_progress', $ticket->status);
        $this->assertSame($treasurer->id, $ticket->assigned_to);
        $this->assertSame(2, $ticket->messages()->count());

        Notification::assertSentTo($member->user, TicketReplyNotification::class);
    }

    public function test_resolving_a_ticket_notifies_the_member_and_a_member_reply_reopens_it(): void
    {
        Notification::fake();
        $member = $this->makeActiveMember();
        $treasurer = $this->makeUserWithRole('treasurer');

        Livewire::actingAs($member->user)
            ->test(MyTickets::class)
            ->call('openCreate')
            ->set('subject', 'Test')
            ->set('body', 'Test body')
            ->call('save');

        $ticket = Ticket::firstOrFail();

        Livewire::actingAs($treasurer)
            ->test(TicketShow::class, ['ticket' => $ticket])
            ->call('claim')
            ->call('resolve');

        $ticket->refresh();
        $this->assertSame('resolved', $ticket->status);
        $this->assertSame($treasurer->id, $ticket->resolved_by);
        Notification::assertSentTo($member->user, TicketResolvedNotification::class);

        Livewire::actingAs($member->user)
            ->test(TicketShow::class, ['ticket' => $ticket])
            ->set('replyBody', 'Actually I still need help.')
            ->call('reply');

        $this->assertSame('in_progress', $ticket->fresh()->status, 'A member reply on a resolved ticket should reopen it.');
    }

    public function test_a_user_with_permission_but_no_member_record_gets_a_clean_404_not_a_server_error(): void
    {
        // e.g. a super_admin account, which is granted every permission
        // (including raise_complaint) but has no Member profile — matches
        // how MyShares/MySavings already behave for this same edge case.
        $superAdmin = $this->makeUserWithRole('super_admin');

        try {
            Livewire::actingAs($superAdmin)->test(MyTickets::class);
            $this->fail('Expected a 404 for a user with no member record.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Expected — this is what Laravel turns into a clean 404, not
            // the "Collection::links does not exist" 500 this used to throw.
            $this->assertTrue(true);
        }
    }

    public function test_ticket_numbers_increment_sequentially(): void
    {
        $this->assertSame('TCK/00001', Ticket::generateTicketNo());

        $member = $this->makeActiveMember();
        Ticket::create([
            'ticket_no' => 'TCK/00001',
            'member_id' => $member->id,
            'raised_by' => $member->user_id,
            'category' => 'general',
            'subject' => 'x',
            'status' => 'open',
        ]);

        $this->assertSame('TCK/00002', Ticket::generateTicketNo());
    }
}
