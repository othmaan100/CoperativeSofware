<?php

namespace App\Livewire\Members;

use App\Models\DividendAllocation;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MyDividends extends Component
{
    public Member $member;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_own_dividends'), 403);
        $this->member = Auth::user()->member()->firstOrFail();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.members.my-dividends', [
            'allocations' => DividendAllocation::query()
                ->where('member_id', $this->member->id)
                ->where('status', 'posted')
                ->with('period')
                ->latest('created_at')
                ->get(),
        ]);
    }
}
