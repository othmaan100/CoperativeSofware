<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\ContributionBatch;
use App\Models\Member;
use App\Models\SavingsProduct;
use App\Models\ShareAccount;
use App\Models\SharePriceHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContributionBatchShow extends Component
{
    use WithFileUploads;

    public ContributionBatch $batch;

    public $replacementFile;

    public function mount(ContributionBatch $batch): void
    {
        abort_unless(Auth::user()->can('post_contribution_batch'), 403);
        $this->batch = $batch;
    }

    public function reupload(): void
    {
        abort_unless($this->batch->status !== 'posted', 400, 'A posted batch cannot be modified.');

        $this->validate(['replacementFile' => ['required', 'file', 'mimes:csv,txt', 'max:5120']]);

        $storedPath = $this->replacementFile->store('contribution-batches', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = ContributionBatches::parseRows($fullPath);

        $this->batch->update([
            'file_path' => $storedPath,
            'rows' => $rows,
            'total_records' => count($rows),
            'total_amount' => collect($rows)->where('matched', true)->sum('amount'),
            'status' => 'validated',
        ]);

        $this->reset(['replacementFile']);
        session()->flash('status', 'File replaced and re-validated.');
    }

    public function post(): void
    {
        abort_unless($this->batch->status === 'validated', 400, 'Only a validated batch can be posted.');

        $matchedRows = $this->batch->matchedRows();

        if (empty($matchedRows)) {
            session()->flash('error', 'No matched rows to post.');

            return;
        }

        $regularProduct = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();

        if (! $regularProduct) {
            session()->flash('error', 'The Regular Savings product is not set up, so contributions cannot be posted. Ask the administrator to run the savings seeder (php artisan db:seed --class=SavingsSeeder).');

            return;
        }
        $userId = Auth::id();
        $batch = $this->batch;
        $sharePurchases = 0;

        DB::transaction(function () use ($matchedRows, $regularProduct, $userId, $batch, &$sharePurchases) {
            $unitPrice = SharePriceHistory::currentPrice();

            foreach ($matchedRows as $row) {
                $member = Member::find($row['member_id']);
                if (! $member) {
                    continue;
                }

                $account = \App\Models\SavingsAccount::openFor($member, $regularProduct);

                $account->recordTransaction(
                    type: 'contribution_deduction',
                    amount: (float) $row['amount'],
                    description: "Monthly contribution for {$batch->period}",
                    postedBy: $userId,
                    reference: "BATCH-{$batch->id}",
                    sourceBatchId: $batch->id,
                );

                $shares = (int) ($row['shares'] ?? 0);
                if ($shares > 0) {
                    $shareAccount = ShareAccount::openFor($member);
                    $shareAccount->recordTransaction(
                        type: ShareAccount::TYPE_PURCHASE,
                        shares: $shares,
                        unitPrice: $unitPrice,
                        description: "Monthly share purchase for {$batch->period}",
                        postedBy: $userId,
                        reference: "BATCH-{$batch->id}",
                        sourceBatchId: $batch->id,
                    );
                    $sharePurchases++;
                }
            }

            $batch->update(['status' => 'posted', 'posted_at' => now()]);
        });

        ActivityLog::record(
            action: 'savings.contribution_batch_posted',
            description: "Posted contribution batch for {$batch->period} (".count($matchedRows).' contribution(s), '."{$sharePurchases} share purchase(s)).",
            subject: $batch,
            properties: ['period' => $batch->period, 'contributions' => count($matchedRows), 'share_purchases' => $sharePurchases, 'total_amount' => (float) $batch->total_amount],
        );

        $message = 'Batch posted successfully. '.count($matchedRows).' contribution(s) recorded.';
        if ($sharePurchases > 0) {
            $message .= " {$sharePurchases} share purchase(s) also recorded.";
        }
        session()->flash('status', $message);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.contribution-batch-show');
    }
}
