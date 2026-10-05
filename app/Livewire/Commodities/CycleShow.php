<?php

namespace App\Livewire\Commodities;

use App\Models\ActivityLog;
use App\Models\CommodityCycle;
use App\Models\CommodityItem;
use App\Models\CommodityRequest;
use App\Models\CommodityRequestLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CycleShow extends Component
{
    public CommodityCycle $cycle;

    public array $prices = [];

    public string $tenure_months = '';

    public string $moratorium_months = '';

    public string $markup_admin_pct = '';

    public string $markup_profit_pct = '';

    public ?int $releaseRequestId = null;

    public array $releaseQuantities = [];

    public array $releaseReasons = [];

    public array $auditPrices = [];

    public array $stockGood = [];

    public array $stockDamaged = [];

    public function mount(CommodityCycle $cycle): void
    {
        abort_unless(
            Auth::user()->canAny(['manage_commodity_cycles', 'price_commodity_cycle', 'verify_commodity_cycle', 'approve_commodity_cycle', 'authorize_commodity_cycle', 'release_commodity_goods', 'set_loan_interest_rates']),
            403
        );

        $this->cycle = $cycle;
        $this->tenure_months = (string) ($cycle->tenure_months ?? 3);
        $this->moratorium_months = (string) ($cycle->moratorium_months ?? 1);
        $this->markup_admin_pct = (string) $cycle->markup_admin_pct;
        $this->markup_profit_pct = (string) $cycle->markup_profit_pct;

        foreach ($this->cycle->demandSummary() as $row) {
            $key = $row->commodity_item_id ? "item-{$row->commodity_item_id}" : 'custom-'.strtolower($row->custom_item_text);
            $this->prices[$key] = '';
        }

        $this->fillVerificationInputs();
    }

    public function closeRequestsNow(): void
    {
        abort_unless(Auth::user()->can('manage_commodity_cycles'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_OPEN, 400);

        $this->cycle->update(['status' => CommodityCycle::STATUS_REQUESTS_CLOSED]);
        ActivityLog::record('commodity.requests_closed', "Closed the request window for cycle \"{$this->cycle->name}\".", $this->cycle);
        session()->flash('status', 'Request window closed. You can now price this cycle.');
    }

    public function saveMarkup(): void
    {
        abort_unless(Auth::user()->can('set_loan_interest_rates'), 403);
        abort_unless(in_array($this->cycle->status, [CommodityCycle::STATUS_OPEN, CommodityCycle::STATUS_REQUESTS_CLOSED], true), 400);

        $validated = $this->validate([
            'markup_admin_pct' => ['required', 'numeric', 'min:0', 'max:100'],
            'markup_profit_pct' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $this->cycle->update($validated);
        ActivityLog::record('commodity.markup_changed', "Updated markup for cycle \"{$this->cycle->name}\" to {$validated['markup_admin_pct']}% admin / {$validated['markup_profit_pct']}% profit.", $this->cycle, $validated);
        session()->flash('status', 'Markup rate updated for this cycle.');
    }

    /**
     * Drop a demanded item entirely from this cycle — every member's line
     * for it is removed — used when the committee simply couldn't source
     * it in the market.
     */
    public function removeDemandItem(?int $itemId, ?string $customText): void
    {
        abort_unless(Auth::user()->can('price_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_REQUESTS_CLOSED, 400);

        CommodityRequestLine::query()
            ->whereHas('request', fn ($q) => $q->where('commodity_cycle_id', $this->cycle->id))
            ->when($itemId, fn ($q) => $q->where('commodity_item_id', $itemId))
            ->when(! $itemId, fn ($q) => $q->whereNull('commodity_item_id')->where('custom_item_text', $customText))
            ->delete();

        $key = $itemId ? "item-{$itemId}" : 'custom-'.strtolower($customText);
        unset($this->prices[$key]);

        $itemLabel = $itemId ? (CommodityItem::find($itemId)?->label() ?? "item #{$itemId}") : $customText;
        ActivityLog::record('commodity.demand_item_removed', "Removed item \"{$itemLabel}\" from cycle \"{$this->cycle->name}\" demand.", $this->cycle, ['commodity_item_id' => $itemId, 'custom_text' => $customText]);

        session()->flash('status', 'Item removed from this cycle for every member who requested it.');
    }

    public function finalizePricing(): void
    {
        abort_unless(Auth::user()->can('price_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_REQUESTS_CLOSED, 400);

        $validated = $this->validate([
            'tenure_months' => ['required', 'integer', 'min:1'],
            'moratorium_months' => ['required', 'integer', 'min:0'],
        ]);

        $demand = $this->cycle->demandSummary();

        if ($demand->isEmpty()) {
            session()->flash('error', 'There are no requested items left to price.');

            return;
        }

        foreach ($demand as $row) {
            $key = $row->commodity_item_id ? "item-{$row->commodity_item_id}" : 'custom-'.strtolower($row->custom_item_text);
            $price = $this->prices[$key] ?? '';

            if (! is_numeric($price) || (float) $price <= 0) {
                $this->addError("prices.{$key}", 'Enter a unit price for every item before finalizing.');

                return;
            }
        }

        DB::transaction(function () use ($validated, $demand) {
            $userId = Auth::id();

            foreach ($demand as $row) {
                $key = $row->commodity_item_id ? "item-{$row->commodity_item_id}" : 'custom-'.strtolower($row->custom_item_text);
                $price = (float) $this->prices[$key];
                $itemId = $row->commodity_item_id;

                // A custom (not-in-catalogue) item gets promoted into the permanent
                // catalogue automatically, and every line referencing it is
                // re-pointed at the new catalogue entry.
                if (! $itemId) {
                    $lines = CommodityRequestLine::query()
                        ->whereHas('request', fn ($q) => $q->where('commodity_cycle_id', $this->cycle->id))
                        ->whereNull('commodity_item_id')
                        ->where('custom_item_text', $row->custom_item_text)
                        ->get();

                    $itemId = CommodityItem::create([
                        'description' => $row->custom_item_text,
                        'type_brand' => null,
                        'pack_unit' => $row->unit_basis,
                        'is_active' => true,
                        'created_from_request_line_id' => $lines->first()?->id,
                    ])->id;

                    $lines->each(fn ($line) => $line->update(['commodity_item_id' => $itemId]));
                }

                $this->cycle->prices()->create([
                    'commodity_item_id' => $itemId,
                    'custom_item_text' => $row->custom_item_text,
                    'unit_price' => $price,
                    'set_by' => $userId,
                    'set_at' => now(),
                ]);

                $this->cycle->applyItemPrice($itemId, $price);
            }

            $this->cycle->update([
                'tenure_months' => $validated['tenure_months'],
                'moratorium_months' => $validated['moratorium_months'],
                'status' => CommodityCycle::STATUS_PRICED,
                'priced_by' => Auth::id(),
                'priced_at' => now(),
            ]);

            $this->cycle->recalculateRequestTotals();
            $this->cycle->requests()->where('status', CommodityRequest::STATUS_SUBMITTED)->update(['status' => CommodityRequest::STATUS_PRICED]);
        });

        ActivityLog::record('commodity.priced', "Finalized pricing for cycle \"{$this->cycle->name}\".", $this->cycle, ['tenure_months' => (int) $validated['tenure_months'], 'moratorium_months' => (int) $validated['moratorium_months']]);

        $this->cycle->refresh();
        $this->fillVerificationInputs();

        session()->flash('status', 'Prices finalized. This cycle now awaits Auditor verification.');
    }

    protected function fillVerificationInputs(): void
    {
        $this->auditPrices = [];
        $this->stockGood = [];
        $this->stockDamaged = [];

        foreach ($this->cycle->prices as $price) {
            if ($this->cycle->status === CommodityCycle::STATUS_PRICED) {
                $this->auditPrices[$price->id] = $this->plainNumber((float) $price->unit_price);
            }
            if ($this->cycle->status === CommodityCycle::STATUS_AUDITOR_VERIFIED) {
                $this->stockGood[$price->id] = $this->plainNumber($price->quantityRequested());
                $this->stockDamaged[$price->id] = '0';
            }
        }
    }

    protected function plainNumber(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }

    /**
     * Auditor checks every unit price the Secretary set. Any price they
     * change is corrected (original kept for the record) and every affected
     * member's totals are recalculated before the cycle is marked verified.
     */
    public function verify(): void
    {
        abort_unless(Auth::user()->can('verify_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_PRICED, 400);

        $prices = $this->cycle->prices()->with('commodityItem')->get();

        $rules = [];
        foreach ($prices as $price) {
            $rules["auditPrices.{$price->id}"] = ['required', 'numeric', 'gt:0'];
        }
        $this->validate($rules, ['auditPrices.*.required' => 'Enter a price.', 'auditPrices.*.gt' => 'Price must be more than zero.']);

        $changes = [];

        DB::transaction(function () use ($prices, &$changes) {
            foreach ($prices as $price) {
                $new = round((float) $this->auditPrices[$price->id], 2);
                $old = (float) $price->unit_price;

                if (abs($new - $old) < 0.001) {
                    continue;
                }

                $price->update([
                    'original_unit_price' => $price->original_unit_price ?? $old,
                    'unit_price' => $new,
                    'revised_by' => Auth::id(),
                    'revised_at' => now(),
                ]);
                $this->cycle->applyItemPrice($price->commodity_item_id, $new);

                $changes[] = ['item' => $price->label(), 'from' => $old, 'to' => $new];
            }

            if ($changes) {
                $this->cycle->recalculateRequestTotals();
            }

            $this->cycle->update([
                'status' => CommodityCycle::STATUS_AUDITOR_VERIFIED,
                'auditor_verified_by' => Auth::id(),
                'auditor_verified_at' => now(),
            ]);
        });

        $summary = collect($changes)->map(fn ($c) => "{$c['item']} ₦".number_format($c['from'], 2).' → ₦'.number_format($c['to'], 2))->implode('; ');

        ActivityLog::record(
            'commodity.verified',
            "Verified prices for cycle \"{$this->cycle->name}\"".($changes ? " with corrections: {$summary}." : ' with no changes.'),
            $this->cycle,
            ['price_corrections' => $changes],
        );

        $this->cycle->refresh();
        $this->fillVerificationInputs();

        session()->flash('status', ($changes
            ? count($changes).' price(s) corrected and members\' totals recalculated. '
            : 'All prices confirmed. ').'Cycle verified — awaiting Store Officer stock verification.');
    }

    /**
     * Store Officer counts what is actually in the store. Only the
     * good-condition quantity can be released to members; damaged items are
     * recorded but never released.
     */
    public function approve(): void
    {
        abort_unless(Auth::user()->can('approve_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_AUDITOR_VERIFIED, 400);

        $prices = $this->cycle->prices()->with('commodityItem')->get();

        $rules = [];
        foreach ($prices as $price) {
            $rules["stockGood.{$price->id}"] = ['required', 'numeric', 'min:0'];
            $rules["stockDamaged.{$price->id}"] = ['nullable', 'numeric', 'min:0'];
        }
        $this->validate($rules, ['stockGood.*.required' => 'Enter the good-condition quantity (0 if none).']);

        $short = [];

        DB::transaction(function () use ($prices, &$short) {
            foreach ($prices as $price) {
                $good = round((float) $this->stockGood[$price->id], 2);
                $damaged = round((float) ($this->stockDamaged[$price->id] ?: 0), 2);
                $requested = $price->quantityRequested();

                $price->update(['quantity_in_store' => $good, 'quantity_damaged' => $damaged]);

                if ($good < $requested) {
                    $short[] = ['item' => $price->label(), 'requested' => $requested, 'in_store' => $good, 'damaged' => $damaged];
                }
            }

            $this->cycle->update([
                'status' => CommodityCycle::STATUS_STORE_APPROVED,
                'store_approved_by' => Auth::id(),
                'store_approved_at' => now(),
            ]);
        });

        $summary = collect($short)->map(fn ($s) => "{$s['item']}: ".(float) $s['in_store'].' good of '.(float) $s['requested'].' requested')->implode('; ');

        ActivityLog::record(
            'commodity.approved',
            "Verified store stock for cycle \"{$this->cycle->name}\"".($short ? " — short: {$summary}." : ' — all requested quantities in store.'),
            $this->cycle,
            ['stock' => $prices->map(fn ($p) => ['item' => $p->label(), 'good' => (float) $p->fresh()->quantity_in_store, 'damaged' => (float) $p->fresh()->quantity_damaged])->all(), 'short' => $short],
        );

        $this->cycle->refresh();
        $this->fillVerificationInputs();

        session()->flash('status', 'Store stock verified. '.($short
            ? count($short).' item(s) are short — members will be released in turn until the good stock runs out. '
            : '').'Awaiting Chairman authorization.');
    }

    public function authorize_(): void
    {
        abort_unless(Auth::user()->can('authorize_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_STORE_APPROVED, 400);

        $this->cycle->update([
            'status' => CommodityCycle::STATUS_CHAIRMAN_AUTHORIZED,
            'chairman_authorized_by' => Auth::id(),
            'chairman_authorized_at' => now(),
        ]);

        ActivityLog::record('commodity.authorized', "Authorized cycle \"{$this->cycle->name}\" for release.", $this->cycle);

        session()->flash('status', 'Cycle authorized. Goods can now be released to members.');
    }

    protected function releasableRequest(int $requestId): ?CommodityRequest
    {
        abort_unless(Auth::user()->can('release_commodity_goods'), 403);
        abort_unless(in_array($this->cycle->status, [CommodityCycle::STATUS_CHAIRMAN_AUTHORIZED, CommodityCycle::STATUS_ACTIVE], true), 400);

        $request = $this->cycle->requests()->with(['member', 'lines.commodityItem'])->findOrFail($requestId);

        return $request->status === CommodityRequest::STATUS_PRICED ? $request : null;
    }

    /**
     * Good-condition stock left per line's item (line id => quantity), or
     * null for an item the Store Officer never counted (no cap).
     */
    protected function availableStock(CommodityRequest $request): array
    {
        $stock = $this->cycle->prices()->get()->keyBy('commodity_item_id');

        return $request->lines
            ->mapWithKeys(fn ($line) => [$line->id => $stock->get($line->commodity_item_id)?->quantityAvailable($line->id)])
            ->all();
    }

    public function openRelease(int $requestId): void
    {
        $request = $this->releasableRequest($requestId);
        if (! $request) {
            return;
        }

        $available = $this->availableStock($request);

        $this->releaseRequestId = $request->id;
        $this->releaseQuantities = [];
        $this->releaseReasons = [];

        foreach ($request->lines as $line) {
            $quantity = $available[$line->id] === null ? (float) $line->quantity : min((float) $line->quantity, $available[$line->id]);
            $this->releaseQuantities[$line->id] = $this->plainNumber($quantity);
            $this->releaseReasons[$line->id] = $quantity < (float) $line->quantity ? CommodityRequestLine::SHORTFALL_NOT_IN_STOCK : '';
        }

        $this->resetErrorBag();
    }

    public function closeRelease(): void
    {
        $this->releaseRequestId = null;
        $this->releaseQuantities = [];
        $this->releaseReasons = [];
    }

    public function markNotInStock(int $lineId): void
    {
        $this->releaseQuantities[$lineId] = '0';
        $this->releaseReasons[$lineId] = CommodityRequestLine::SHORTFALL_NOT_IN_STOCK;
    }

    public function markDamaged(int $lineId): void
    {
        $this->releaseQuantities[$lineId] = '0';
        $this->releaseReasons[$lineId] = CommodityRequestLine::SHORTFALL_DAMAGED;
    }

    public function confirmRelease(): void
    {
        $request = $this->releasableRequest((int) $this->releaseRequestId);
        if (! $request) {
            $this->closeRelease();

            return;
        }

        $available = $this->availableStock($request);
        $rules = [];
        $messages = [
            'releaseQuantities.*.required' => 'Enter the quantity released (0 if none).',
            'releaseReasons.*.required' => 'Say why less than requested is being released.',
        ];

        foreach ($request->lines as $line) {
            $max = $available[$line->id] === null ? (float) $line->quantity : min((float) $line->quantity, $available[$line->id]);
            $rules["releaseQuantities.{$line->id}"] = ['required', 'numeric', 'min:0', 'max:'.$max];
            $messages["releaseQuantities.{$line->id}.max"] = $max < (float) $line->quantity
                ? 'Only '.$this->plainNumber($max).' left in good condition.'
                : 'Cannot release more than was requested ('.$this->plainNumber($max).').';

            if (is_numeric($this->releaseQuantities[$line->id] ?? null) && (float) $this->releaseQuantities[$line->id] < (float) $line->quantity) {
                $rules["releaseReasons.{$line->id}"] = ['required', 'in:'.implode(',', array_keys(CommodityRequestLine::SHORTFALL_REASONS))];
            }
        }
        $this->validate($rules, $messages);

        $quantities = collect($this->releaseQuantities)->map(fn ($q) => (float) $q)->all();
        $loan = $request->releaseGoods(Auth::id(), $quantities, $this->releaseReasons);
        $request->refresh();

        if ($this->cycle->status === CommodityCycle::STATUS_CHAIRMAN_AUTHORIZED) {
            $this->cycle->update(['status' => CommodityCycle::STATUS_ACTIVE]);
        }

        $notReleased = $request->lines->filter(fn ($line) => $line->wasShortSupplied())
            ->map(fn ($line) => $line->label().' ('.(float) $line->quantity_released.' of '.(float) $line->quantity.' — '.$line->shortfallLabel().')')
            ->values()
            ->all();

        ActivityLog::record(
            action: $loan ? 'commodity.goods_released' : 'commodity.not_supplied',
            description: $loan
                ? "Released goods worth ₦{$request->commodity_subtotal} (of ₦{$request->requestedSubtotal()} requested) to {$request->member->full_name} (cycle \"{$this->cycle->name}\")."
                : "Nothing released to {$request->member->full_name} (cycle \"{$this->cycle->name}\") — request closed without a loan.",
            subject: $loan ?? $request,
            properties: [
                'commodity_request_id' => $request->id,
                'requested_subtotal' => $request->requestedSubtotal(),
                'released_subtotal' => (float) $request->commodity_subtotal,
                'total_repayable' => (float) $request->total_repayable,
                'short_supplied' => $notReleased,
            ],
        );

        $this->closeRelease();

        session()->flash('status', $loan
            ? 'Goods released. Loan '.$loan->loan_no.' of ₦'.number_format((float) $loan->total_repayable, 2).' is now live'.($notReleased ? ' — items not released were not charged.' : '.')
            : 'Nothing was released to this member, so no loan was created.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->cycle->refresh();

        $releaseRequest = $this->releaseRequestId
            ? $this->cycle->requests()->with(['member', 'lines.commodityItem'])->find($this->releaseRequestId)
            : null;

        $releasePreview = null;
        if ($releaseRequest) {
            $subtotal = round($releaseRequest->lines->sum(
                fn ($line) => (is_numeric($this->releaseQuantities[$line->id] ?? null) ? (float) $this->releaseQuantities[$line->id] : 0) * (float) $line->fixed_unit_price
            ), 2);
            $markup = round($subtotal * $this->cycle->markupPctTotal() / 100, 2);
            $releasePreview = (object) [
                'requested' => $releaseRequest->requestedSubtotal(),
                'subtotal' => $subtotal,
                'markup' => $markup,
                'total' => round($subtotal + $markup, 2),
                'installment' => round(($subtotal + $markup) / max(1, (int) $this->cycle->tenure_months), 2),
            ];
        }

        return view('livewire.commodities.cycle-show', [
            'demand' => $this->cycle->demandSummary(),
            'requests' => $this->cycle->requests()->with(['member', 'loan', 'lines'])->get(),
            'cycleItems' => $this->cycle->prices()->with(['commodityItem', 'revisedBy'])->get(),
            'releaseRequest' => $releaseRequest,
            'releasePreview' => $releasePreview,
            'releaseAvailable' => $releaseRequest ? $this->availableStock($releaseRequest) : [],
        ]);
    }
}
