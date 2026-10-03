<?php

namespace App\Livewire\Commodities;

use App\Models\ActivityLog;
use App\Models\CommodityCycle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CyclesIndex extends Component
{
    public bool $showForm = false;

    public string $name = '';

    public string $request_deadline = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->canAny(['manage_commodity_cycles', 'price_commodity_cycle', 'verify_commodity_cycle', 'approve_commodity_cycle', 'authorize_commodity_cycle', 'release_commodity_goods']), 403);
    }

    public function openCreate(): void
    {
        $this->reset(['name', 'request_deadline']);
        $this->request_deadline = now()->addWeeks(2)->toDateString();
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
    }

    public function create(): void
    {
        abort_unless(Auth::user()->can('manage_commodity_cycles'), 403);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'request_deadline' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $cycle = CommodityCycle::create([
            'name' => $validated['name'],
            'request_deadline' => $validated['request_deadline'],
            'status' => CommodityCycle::STATUS_OPEN,
            'opened_by' => Auth::id(),
        ]);

        ActivityLog::record('commodity.cycle_opened', "Opened commodity cycle \"{$cycle->name}\" (deadline {$cycle->request_deadline->format('d M Y')}).", $cycle);

        $this->closeForm();
        $this->redirectRoute('commodities.cycles.show', $cycle, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.commodities.cycles-index', [
            'cycles' => CommodityCycle::query()->withCount('requests')->latest()->paginate(15),
        ]);
    }
}
