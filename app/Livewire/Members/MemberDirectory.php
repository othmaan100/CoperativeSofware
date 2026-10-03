<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberDirectory extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = 'all';

    #[Url]
    public string $department = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_all_members'), 403);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    protected function filteredQuery()
    {
        $query = Member::query();

        match ($this->status) {
            'active' => $query->active(),
            'pending' => $query->pendingQueue(),
            'rejected' => $query->rejected(),
            'suspended' => $query->suspended(),
            'dormant' => $query->dormant(),
            'exited' => $query->exited(),
            'deceased' => $query->deceased(),
            default => null,
        };

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('full_name', 'like', "%{$this->search}%")
                    ->orWhere('staff_id', 'like', "%{$this->search}%")
                    ->orWhere('membership_no', 'like', "%{$this->search}%")
                    ->orWhere('application_no', 'like', "%{$this->search}%");
            });
        }

        if ($this->department !== '') {
            $query->where('department', $this->department);
        }

        return $query->latest('created_at');
    }

    public function exportCsv(): StreamedResponse
    {
        $this->authorize('export', Member::class);

        $members = $this->filteredQuery()->get();

        $filename = 'members-'.now()->format('Y-m-d_His').'.csv';

        return response()->streamDownload(function () use ($members) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Application No', 'Membership No', 'Full Name', 'Department', 'Staff ID', 'Status', 'Approved Contribution', 'Applied At']);

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->application_no,
                    $member->membership_no,
                    $member->full_name,
                    $member->department,
                    $member->staff_id,
                    $member->rejected_at ? 'rejected' : $member->status,
                    $member->approved_monthly_contribution,
                    $member->applied_at?->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        }, $filename);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.members.member-directory', [
            'members' => $this->filteredQuery()->paginate(15),
            'departments' => Member::query()->whereNotNull('department')->distinct()->orderBy('department')->pluck('department'),
        ]);
    }
}
