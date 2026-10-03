<?php

namespace App\Livewire\Members;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyApplication extends Component
{
    public function render()
    {
        $member = Auth::user()->member()->with(['nextOfKin', 'statusHistory.changedBy'])->first();

        return view('livewire.members.my-application', [
            'member' => $member,
        ])->layout('layouts.app');
    }
}
