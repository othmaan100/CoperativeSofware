<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\WelfareFund;
use App\Models\WelfareLevyBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class WelfareLevyBatchShow extends Component
{
    public WelfareLevyBatch $batch;

    public function mount(WelfareLevyBatch $batch): void
    {
        abort_unless(Auth::user()->can('post_welfare_levy'), 403);
        $this->batch = $batch;
    }

    public function post(): void
    {
        abort_unless($this->batch->status === 'validated', 400, 'Only a validated batch can be posted.');

        $matchedRows = $this->batch->matchedRows();

        if (empty($matchedRows)) {
            session()->flash('error', 'No matched rows to post.');

            return;
        }

        $levyAmount = (float) Setting::get('welfare_levy_amount', 0);
        $userId = Auth::id();
        $batch = $this->batch;

        DB::transaction(function () use ($matchedRows, $levyAmount, $userId, $batch) {
            foreach ($matchedRows as $row) {
                $batch->payments()->create([
                    'member_id' => $row['member_id'],
                    'period' => $batch->period,
                    'amount' => $levyAmount,
                    'posted_at' => now(),
                ]);
            }

            $total = round(count($matchedRows) * $levyAmount, 2);

            WelfareFund::singleton()->recordTransaction(
                type: WelfareFund::TYPE_LEVY,
                amount: $total,
                description: "Welfare levy collected for {$batch->period} (".count($matchedRows).' member(s)).',
                postedBy: $userId,
                sourceBatchId: $batch->id,
            );

            $batch->update(['status' => 'posted', 'posted_at' => now(), 'total_amount' => $total]);
        });

        ActivityLog::record(
            action: 'welfare.levy_batch_posted',
            description: "Posted welfare levy batch for {$batch->period} (".count($matchedRows).' member(s)).',
            subject: $batch,
            properties: ['period' => $batch->period, 'payments' => count($matchedRows), 'total_amount' => (float) $batch->total_amount],
        );

        session()->flash('status', 'Batch posted successfully. '.count($matchedRows).' levy payment(s) recorded.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.welfare-levy-batch-show');
    }
}
