<?php

namespace App\Livewire\Commodities;

use App\Models\CommodityCycle;
use App\Models\CommodityItem;
use App\Models\CommodityRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RequestCommodity extends Component
{
    public Member $member;

    public array $lines = [];

    public bool $salary_deduction_authorized = false;

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        abort_unless($this->member->status === 'active', 403, 'Only active members can request a commodity loan.');
        abort_unless(Auth::user()->can('request_commodity_loan'), 403);

        $editable = $this->editableRequest();

        if ($editable) {
            $this->lines = $editable->lines->map(fn ($line) => [
                // A stable identifier (not the array position) for wire:key,
                // so removing a line never causes Livewire/Alpine to confuse
                // a shifted-up line's DOM/local state with a different line.
                'key' => (string) $line->id,
                'commodity_item_id' => $line->commodity_item_id ? (string) $line->commodity_item_id : '',
                'custom_item_text' => $line->custom_item_text ?? '',
                'quantity' => (string) $line->quantity,
                'unit_basis' => $line->unit_basis,
            ])->all();
            $this->salary_deduction_authorized = (bool) $editable->salary_deduction_authorized;
        }

        if (empty($this->lines)) {
            $this->addLine();
        }
    }

    /**
     * A cycle currently accepting brand-new requests — used only to decide
     * whether the "apply" form should be offered, never to look up a
     * request the member already has once its cycle has moved on.
     */
    #[Computed]
    public function openCycle(): ?CommodityCycle
    {
        return CommodityCycle::query()
            ->where('status', CommodityCycle::STATUS_OPEN)
            ->where('request_deadline', '>=', now()->toDateString())
            ->latest('request_deadline')
            ->first();
    }

    #[Computed]
    public function catalogue()
    {
        return CommodityItem::query()->where('is_active', true)->orderBy('description')->orderBy('type_brand')->get();
    }

    /**
     * The request the member can still edit right now — only ever the one
     * tied to the currently open cycle, and only before the Secretary has
     * priced it.
     */
    public function editableRequest(): ?CommodityRequest
    {
        $cycle = $this->openCycle;

        if (! $cycle) {
            return null;
        }

        return CommodityRequest::with('lines')
            ->where('commodity_cycle_id', $cycle->id)
            ->where('member_id', $this->member->id)
            ->where('status', CommodityRequest::STATUS_SUBMITTED)
            ->first();
    }

    /**
     * The member's most recent commodity request of any kind, regardless of
     * what has happened to its cycle since — this is what keeps their
     * priced totals, item list, and (once released) loan link visible after
     * the request window closes and pricing is finalized.
     */
    public function latestRequest(): ?CommodityRequest
    {
        return CommodityRequest::with(['lines.commodityItem', 'cycle', 'loan'])
            ->where('member_id', $this->member->id)
            ->latest('id')
            ->first();
    }

    public function addLine(): void
    {
        $this->lines[] = ['key' => (string) Str::uuid(), 'commodity_item_id' => '', 'custom_item_text' => '', 'quantity' => '', 'unit_basis' => ''];
    }

    public function removeLine(int $index): void
    {
        unset($this->lines[$index]);
        $this->lines = array_values($this->lines);

        if (empty($this->lines)) {
            $this->addLine();
        }
    }

    protected function rules(): array
    {
        $rules = [
            'salary_deduction_authorized' => ['accepted'],
        ];

        foreach ($this->lines as $i => $line) {
            $rules["lines.{$i}.quantity"] = ['required', 'numeric', 'min:0.01'];

            $unitBasisRules = ['required', 'string', 'max:100'];

            $item = $line['commodity_item_id'] !== ''
                ? $this->catalogue->firstWhere('id', (int) $line['commodity_item_id'])
                : null;

            if ($item?->hasUnitOptions()) {
                $unitBasisRules[] = Rule::in($item->unit_options);
            }

            $rules["lines.{$i}.unit_basis"] = $unitBasisRules;
        }

        return $rules;
    }

    public function submit(): void
    {
        $cycle = $this->openCycle;
        abort_unless($cycle, 400, 'There is no open commodity cycle to request against right now.');
        abort_if($this->member->hasActiveCommodityLoan(), 400, 'You must fully repay your existing commodity loan before requesting again.');

        $cleanLines = collect($this->lines)->filter(fn ($l) => trim((string) ($l['commodity_item_id'] ?? '')) !== '' || trim((string) ($l['custom_item_text'] ?? '')) !== '')->values()->all();

        if (empty($cleanLines)) {
            $this->addError('lines', 'Add at least one item to your request.');

            return;
        }

        $this->lines = $cleanLines;
        $validated = $this->validate();

        $editable = $this->editableRequest();

        DB::transaction(function () use ($cycle, $validated, $editable) {
            $request = $editable ?: CommodityRequest::create([
                'commodity_cycle_id' => $cycle->id,
                'member_id' => $this->member->id,
                'status' => CommodityRequest::STATUS_SUBMITTED,
            ]);

            $request->update(['salary_deduction_authorized' => $validated['salary_deduction_authorized']]);
            $request->lines()->delete();

            foreach ($this->lines as $line) {
                $request->lines()->create([
                    'commodity_item_id' => $line['commodity_item_id'] !== '' ? $line['commodity_item_id'] : null,
                    'custom_item_text' => $line['commodity_item_id'] === '' ? ($line['custom_item_text'] ?: null) : null,
                    'quantity' => $line['quantity'],
                    'unit_basis' => $line['unit_basis'],
                ]);
            }
        });

        session()->flash('status', 'Your commodity request has been submitted.');
        $this->redirectRoute('commodities.request', navigate: true);
    }

    public function cancel(): void
    {
        $editable = $this->editableRequest();

        if ($editable) {
            $editable->lines()->delete();
            $editable->delete();
        }

        $this->reset(['lines', 'salary_deduction_authorized']);
        $this->addLine();
        session()->flash('status', 'Your commodity request has been withdrawn.');
        $this->redirectRoute('commodities.request', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $editable = $this->editableRequest();
        $latest = $this->latestRequest();

        // Offer a fresh apply form only when there's nothing to edit and the
        // member's latest request (if any) doesn't already belong to the
        // currently open cycle — otherwise fall through to showing it.
        $offerFreshApply = ! $editable
            && $this->openCycle
            && ! $this->member->hasActiveCommodityLoan()
            && (! $latest || $latest->commodity_cycle_id !== $this->openCycle->id);

        return view('livewire.commodities.request-commodity', [
            'editable' => $editable,
            'latest' => $latest,
            'offerFreshApply' => $offerFreshApply,
        ]);
    }
}
