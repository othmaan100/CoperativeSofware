<?php

namespace App\Livewire\Commodities;

use App\Models\ActivityLog;
use App\Models\CommodityCycle;
use App\Models\CommodityItem;
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

                $this->cycle->prices()->create([
                    'commodity_item_id' => $row->commodity_item_id,
                    'custom_item_text' => $row->custom_item_text,
                    'unit_price' => $price,
                    'set_by' => $userId,
                    'set_at' => now(),
                ]);

                $lines = CommodityRequestLine::query()
                    ->whereHas('request', fn ($q) => $q->where('commodity_cycle_id', $this->cycle->id))
                    ->when($row->commodity_item_id, fn ($q) => $q->where('commodity_item_id', $row->commodity_item_id))
                    ->when(! $row->commodity_item_id, fn ($q) => $q->whereNull('commodity_item_id')->where('custom_item_text', $row->custom_item_text))
                    ->get();

                // A custom (not-in-catalogue) item gets promoted into the permanent
                // catalogue automatically, and every line referencing it is
                // re-pointed at the new catalogue entry.
                if (! $row->commodity_item_id) {
                    $catalogueItem = CommodityItem::create([
                        'description' => $row->custom_item_text,
                        'type_brand' => null,
                        'pack_unit' => $row->unit_basis,
                        'is_active' => true,
                        'created_from_request_line_id' => $lines->first()?->id,
                    ]);
                }

                foreach ($lines as $line) {
                    $line->update([
                        'commodity_item_id' => $row->commodity_item_id ?? $catalogueItem->id,
                        'fixed_unit_price' => $price,
                        'line_total' => round((float) $line->quantity * $price, 2),
                    ]);
                }
            }

            $this->cycle->update([
                'tenure_months' => $validated['tenure_months'],
                'moratorium_months' => $validated['moratorium_months'],
                'status' => CommodityCycle::STATUS_PRICED,
                'priced_by' => Auth::id(),
                'priced_at' => now(),
            ]);

            foreach ($this->cycle->requests()->with('lines')->get() as $request) {
                $subtotal = round((float) $request->lines->sum('line_total'), 2);
                $markup = round($subtotal * $this->cycle->markupPctTotal() / 100, 2);
                $total = round($subtotal + $markup, 2);
                $installment = round($total / max(1, $this->cycle->tenure_months), 2);

                $request->update([
                    'commodity_subtotal' => $subtotal,
                    'markup_amount' => $markup,
                    'total_repayable' => $total,
                    'monthly_installment' => $installment,
                    'status' => \App\Models\CommodityRequest::STATUS_PRICED,
                ]);
            }
        });

        ActivityLog::record('commodity.priced', "Finalized pricing for cycle \"{$this->cycle->name}\".", $this->cycle, ['tenure_months' => (int) $validated['tenure_months'], 'moratorium_months' => (int) $validated['moratorium_months']]);

        session()->flash('status', 'Prices finalized. This cycle now awaits Auditor verification.');
    }

    public function verify(): void
    {
        abort_unless(Auth::user()->can('verify_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_PRICED, 400);

        $this->cycle->update([
            'status' => CommodityCycle::STATUS_AUDITOR_VERIFIED,
            'auditor_verified_by' => Auth::id(),
            'auditor_verified_at' => now(),
        ]);

        ActivityLog::record('commodity.verified', "Verified cycle \"{$this->cycle->name}\".", $this->cycle);

        session()->flash('status', 'Cycle verified. Awaiting Store Officer approval.');
    }

    public function approve(): void
    {
        abort_unless(Auth::user()->can('approve_commodity_cycle'), 403);
        abort_unless($this->cycle->status === CommodityCycle::STATUS_AUDITOR_VERIFIED, 400);

        $this->cycle->update([
            'status' => CommodityCycle::STATUS_STORE_APPROVED,
            'store_approved_by' => Auth::id(),
            'store_approved_at' => now(),
        ]);

        ActivityLog::record('commodity.approved', "Approved cycle \"{$this->cycle->name}\".", $this->cycle);

        session()->flash('status', 'Cycle approved. Awaiting Chairman authorization.');
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

    public function releaseGoods(int $requestId): void
    {
        abort_unless(Auth::user()->can('release_commodity_goods'), 403);
        abort_unless(in_array($this->cycle->status, [CommodityCycle::STATUS_CHAIRMAN_AUTHORIZED, CommodityCycle::STATUS_ACTIVE], true), 400);

        $request = $this->cycle->requests()->with('member')->findOrFail($requestId);

        if ($request->status !== \App\Models\CommodityRequest::STATUS_PRICED) {
            return;
        }

        $loan = $request->releaseGoods(Auth::id());

        if ($this->cycle->status === CommodityCycle::STATUS_CHAIRMAN_AUTHORIZED) {
            $this->cycle->update(['status' => CommodityCycle::STATUS_ACTIVE]);
        }

        ActivityLog::record(
            action: 'commodity.goods_released',
            description: "Released goods worth ₦{$request->commodity_subtotal} to {$request->member->full_name} (cycle \"{$this->cycle->name}\").",
            subject: $loan,
            properties: ['commodity_request_id' => $request->id, 'subtotal' => (float) $request->commodity_subtotal, 'total_repayable' => (float) $request->total_repayable],
        );

        session()->flash('status', 'Goods released. The loan and repayment schedule are now live.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->cycle->refresh();

        return view('livewire.commodities.cycle-show', [
            'demand' => $this->cycle->demandSummary(),
            'requests' => $this->cycle->requests()->with(['member', 'loan'])->get(),
        ]);
    }
}
