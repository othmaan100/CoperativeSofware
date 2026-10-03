<?php

namespace App\Livewire\Chairman;

use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class WelfareSettings extends Component
{
    public string $welfare_levy_amount = '';

    public string $death_benefit_amount = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_welfare_settings'), 403);
        $this->welfare_levy_amount = (string) Setting::get('welfare_levy_amount', 0);
        $this->death_benefit_amount = (string) Setting::get('death_benefit_amount', 0);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'welfare_levy_amount' => ['required', 'numeric', 'min:0'],
            'death_benefit_amount' => ['required', 'numeric', 'min:0'],
        ]);

        Setting::set('welfare_levy_amount', (float) $validated['welfare_levy_amount']);
        Setting::set('death_benefit_amount', (float) $validated['death_benefit_amount']);

        ActivityLog::record('welfare.settings_changed', "Set welfare levy to ₦{$validated['welfare_levy_amount']} and death benefit to ₦{$validated['death_benefit_amount']}.", null, $validated);

        session()->flash('status', 'Welfare fund settings updated. New claims and levy batches will use the new amounts; existing records keep the amount that applied when they were created.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.chairman.welfare-settings');
    }
}
