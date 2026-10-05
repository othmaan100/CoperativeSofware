<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\Loan;
use App\Models\LoanRepaymentBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class LoanRepaymentBatchShow extends Component
{
    use WithFileUploads;

    public LoanRepaymentBatch $batch;

    public $replacementFile;

    public function mount(LoanRepaymentBatch $batch): void
    {
        abort_unless(Auth::user()->can('post_loan_repayment_batch'), 403);
        $this->batch = $batch;
    }

    public function reupload(): void
    {
        abort_unless($this->batch->status !== 'posted', 400, 'A posted batch cannot be modified.');

        $this->validate(['replacementFile' => ['required', 'file', 'mimes:csv,txt', 'max:5120']]);

        $storedPath = $this->replacementFile->store('loan-repayment-batches', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = LoanRepaymentBatches::parseRows($fullPath);

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

        $userId = Auth::id();
        $batch = $this->batch;

        DB::transaction(function () use ($matchedRows, $userId, $batch) {
            foreach ($matchedRows as $row) {
                $loan = Loan::find($row['loan_id']);
                if (! $loan || ! in_array($loan->status, LoanRepaymentBatches::POSTABLE_LOAN_STATUSES, true)) {
                    continue;
                }

                $loan->recordRepayment(
                    type: 'salary_deduction',
                    amount: (float) $row['amount'],
                    postedBy: $userId,
                    reference: "LOANBATCH-{$batch->id}",
                    sourceBatchId: $batch->id,
                    description: "Salary deduction repayment for {$batch->period}",
                );
            }

            $batch->update(['status' => 'posted', 'posted_at' => now()]);
        });

        ActivityLog::record(
            action: 'loan.repayment_batch_posted',
            description: "Posted loan repayment batch for {$batch->period} (".count($matchedRows).' repayment(s)).',
            subject: $batch,
            properties: ['period' => $batch->period, 'repayments' => count($matchedRows), 'total_amount' => (float) $batch->total_amount],
        );

        session()->flash('status', 'Batch posted successfully. '.count($matchedRows).' repayment(s) recorded.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.loan-repayment-batch-show');
    }
}
