<?php

namespace App\Livewire\Welfare;

use App\Models\WelfareClaim;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimsIndex extends Component
{
    use WithPagination;

    public function mount(): void
    {
        $user = Auth::user();
        abort_unless(
            $user->can('initiate_welfare_claim')
                || $user->can('authorize_welfare_claim')
                || $user->can('disburse_welfare_claim')
                || $user->can('view_welfare_reports'),
            403
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.welfare.claims-index', [
            'claims' => WelfareClaim::query()->with('member')->latest()->paginate(15),
        ]);
    }
}
