<?php

namespace App\Livewire\Treasurer;

use App\Models\Loan;
use App\Models\LoanRepaymentBatch;
use App\Models\Member;
use App\Support\Csv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LoanRepaymentBatches extends Component
{
    use WithFileUploads, WithPagination;

    public string $period = '';

    public $file;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('post_loan_repayment_batch'), 403);
        $this->period = now()->format('Y-m');
    }

    protected function rules(): array
    {
        return [
            'period' => ['required', 'regex:/^\d{4}-\d{2}$/'],
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ];
    }

    public static function parseRows(string $fullPath): array
    {
        $rows = [];
        $handle = fopen($fullPath, 'r');
        $header = Csv::readHeader($handle);
        $columnIndex = array_flip($header);

        $get = fn (array $line, string $column) => isset($columnIndex[$column], $line[$columnIndex[$column]])
            ? trim((string) $line[$columnIndex[$column]])
            : '';

        while (($line = fgetcsv($handle)) !== false) {
            if (count(array_filter($line, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }

            $staffId = $get($line, 'staff_id');
            $loanNo = $get($line, 'loan_no');
            $amount = $get($line, 'amount');

            if ($staffId === '' && $loanNo === '') {
                continue;
            }

            $member = Member::query()->where('staff_id', $staffId)->where('status', 'active')->first();
            $loan = $loanNo !== '' ? Loan::query()->where('loan_no', $loanNo)->first() : null;

            $error = null;
            if (! $member) {
                $error = 'No active member found for this Staff ID.';
            } elseif (! $loan) {
                $error = 'No loan found for this Loan No.';
            } elseif ($loan->member_id !== $member->id) {
                $error = 'Loan No. does not belong to this Staff ID.';
            } elseif (! in_array($loan->status, ['active', 'overdue', 'defaulted'], true)) {
                $error = 'Loan is not currently active for repayment.';
            } elseif (! is_numeric($amount) || (float) $amount <= 0) {
                $error = 'Amount must be a positive number.';
            }

            $rows[] = [
                'staff_id' => $staffId,
                'loan_no' => $loanNo,
                'amount' => is_numeric($amount) ? (float) $amount : null,
                'member_id' => $member?->id,
                'member_name' => $member?->full_name,
                'loan_id' => $loan?->id,
                'matched' => $error === null,
                'error' => $error,
            ];
        }
        fclose($handle);

        return $rows;
    }

    public function processUpload(): void
    {
        $validated = $this->validate();

        $storedPath = $this->file->store('loan-repayment-batches', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = self::parseRows($fullPath);

        $batch = LoanRepaymentBatch::create([
            'period' => $validated['period'],
            'uploaded_by' => Auth::id(),
            'file_path' => $storedPath,
            'total_amount' => collect($rows)->where('matched', true)->sum('amount'),
            'total_records' => count($rows),
            'status' => 'validated',
            'rows' => $rows,
            'validation_errors' => ($flagged = collect($rows)->where('matched', false)->count()) > 0 ? ['flagged_count' => $flagged] : null,
        ]);

        $this->reset(['file']);
        $this->redirectRoute('treasurer.loan-repayment-batches.show', $batch, navigate: true);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $loans = Loan::query()
            ->whereIn('status', ['active', 'overdue', 'defaulted'])
            ->with('member')
            ->get(['id', 'member_id', 'loan_no', 'monthly_installment']);

        $filename = 'loan-repayment-template-'.now()->format('Y-m').'.csv';

        return response()->streamDownload(function () use ($loans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['staff_id', 'loan_no', 'amount', 'member_name']);

            foreach ($loans as $loan) {
                fputcsv($handle, [
                    $loan->member->staff_id,
                    $loan->loan_no,
                    number_format((float) $loan->monthly_installment, 2, '.', ''),
                    $loan->member->full_name,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.loan-repayment-batches', [
            'batches' => LoanRepaymentBatch::query()->with('uploadedBy')->latest()->paginate(15),
        ]);
    }
}
