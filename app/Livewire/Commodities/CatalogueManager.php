<?php

namespace App\Livewire\Commodities;

use App\Models\ActivityLog;
use App\Models\CommodityItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogueManager extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $editingId = null;

    public string $description = '';

    public string $type_brand = '';

    public string $pack_unit = '';

    public string $unit_options = '';

    public bool $is_active = true;

    public bool $showForm = false;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_commodity_catalogue'), 403);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'description', 'type_brand', 'pack_unit', 'unit_options']);
        $this->is_active = true;
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $item = CommodityItem::findOrFail($id);
        $this->editingId = $item->id;
        $this->description = $item->description;
        $this->type_brand = (string) $item->type_brand;
        $this->pack_unit = $item->pack_unit;
        $this->unit_options = $item->unitOptionsAsString();
        $this->is_active = $item->is_active;
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
    }

    protected function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255'],
            'type_brand' => ['nullable', 'string', 'max:255'],
            'pack_unit' => ['required', 'string', 'max:255'],
            'unit_options' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $validated['type_brand'] = $validated['type_brand'] ?: null;
        $validated['unit_options'] = CommodityItem::parseUnitOptions($validated['unit_options'] ?? '');

        if ($this->editingId) {
            $item = CommodityItem::findOrFail($this->editingId);
            $item->update($validated);
            ActivityLog::record('commodity.catalogue_item_updated', "Updated catalogue item: {$item->description}.", $item, $validated);
            session()->flash('status', 'Catalogue item updated.');
        } else {
            $item = CommodityItem::create($validated);
            ActivityLog::record('commodity.catalogue_item_created', "Added catalogue item: {$item->description}.", $item, $validated);
            session()->flash('status', 'Catalogue item added.');
        }

        $this->closeForm();
    }

    public function toggleActive(int $id): void
    {
        $item = CommodityItem::findOrFail($id);
        $newState = ! $item->is_active;
        $item->update(['is_active' => $newState]);
        ActivityLog::record('commodity.catalogue_item_toggled', ($newState ? 'Enabled' : 'Disabled')." catalogue item: {$item->description}.", $item);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $items = CommodityItem::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', "%{$this->search}%")
                        ->orWhere('type_brand', 'like', "%{$this->search}%")
                        ->orWhere('pack_unit', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('description')
            ->orderBy('type_brand')
            ->paginate(20);

        return view('livewire.commodities.catalogue-manager', [
            'items' => $items,
        ]);
    }
}
