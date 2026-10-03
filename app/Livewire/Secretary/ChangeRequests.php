<?php

namespace App\Livewire\Secretary;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\MemberChangeRequest;
use App\Models\NextOfKin;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ChangeRequests extends Component
{
    use WithPagination;

    public ?int $activeRequestId = null;

    public string $review_reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('review_change_requests'), 403);
    }

    public function openReject(int $requestId): void
    {
        $this->activeRequestId = $requestId;
        $this->review_reason = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeRequestId', 'review_reason']);
    }

    public function approve(int $requestId): void
    {
        $request = MemberChangeRequest::with('member.nextOfKin')->findOrFail($requestId);
        $this->authorize('reviewChangeRequests', $request->member);

        if ($request->status !== 'pending') {
            return;
        }

        $this->applyChange($request);

        $request->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        $request->member->logEvent('change_request_approved', [
            'field' => $request->field_name,
            'new_value' => $request->new_value,
        ], Auth::id());

        ActivityLog::record(
            action: 'member.change_request_approved',
            description: "Approved {$request->fieldLabel()} change for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['field' => $request->field_name, 'new_value' => $request->new_value],
        );

        session()->flash('status', "Change to {$request->fieldLabel()} approved for {$request->member->full_name}.");
    }

    public function reject(): void
    {
        $request = MemberChangeRequest::findOrFail($this->activeRequestId);
        $this->authorize('reviewChangeRequests', $request->member);

        $this->validate(['review_reason' => ['required', 'string']]);

        $request->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_reason' => $this->review_reason,
        ]);

        $request->member->logEvent('change_request_rejected', [
            'field' => $request->field_name,
            'reason' => $this->review_reason,
        ], Auth::id());

        ActivityLog::record(
            action: 'member.change_request_rejected',
            description: "Rejected {$request->fieldLabel()} change for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['field' => $request->field_name, 'reason' => $this->review_reason],
        );

        session()->flash('status', "Change request rejected.");
        $this->closeModal();
    }

    protected function applyChange(MemberChangeRequest $request): void
    {
        $member = $request->member;
        $field = $request->field_name;

        if (str_starts_with($field, 'nok_')) {
            $nok = $member->nextOfKin->first();

            if (! $nok) {
                $nok = NextOfKin::create(['member_id' => $member->id, 'name' => '', 'relationship' => '', 'phone' => '']);
            }

            $map = [
                'nok_name' => 'name',
                'nok_relationship' => 'relationship',
                'nok_phone' => 'phone',
                'nok_address' => 'address',
            ];

            $nok->update([$map[$field] => $request->new_value]);

            return;
        }

        if (Member::isFieldLocked($field)) {
            abort(403, 'This field is locked and cannot be updated via a change request.');
        }

        $member->update([$field => $request->new_value]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.secretary.change-requests', [
            'requests' => MemberChangeRequest::with('member')
                ->where('status', 'pending')
                ->latest('requested_at')
                ->paginate(15),
        ]);
    }
}
