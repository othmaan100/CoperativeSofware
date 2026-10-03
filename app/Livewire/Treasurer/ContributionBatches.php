<?php

namespace App\Livewire\Treasurer;

use App\Models\ContributionBatch;
use App\Models\Member;
use App\Support\Csv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContributionBatches extends Component
{
    use WithFileUploads, WithPagination;

    public string $period = '';

    public $file;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('post_contribution_batch'), 403);
        $this->period = now()->format('Y-m');
    }

    protected function rules(): array
    {
        return [
            'period' => ['required', 'regex:/^\d{4}-\d{2}$/'],
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ];
    }

    /**
     * Parses staff_id, amount (savings contribution) and an optional shares
     * column (whole number of shares to purchase this period) — shared by
     * both the initial upload and a corrected re-upload.
     */
    public static function parseRows(string $fullPath): array
    {
        $rows = [];
        $handle = fopen($fullPath, 'r');
        $header = Csv::readHeader($handle);
        $staffIdIdx = array_search('staff_id', $header, true);
        $amountIdx = array_search('amount', $header, true);
        $sharesIdx = array_search('shares', $header, true);

        while (($line = fgetcsv($handle)) !== false) {
            if ($staffIdIdx === false || $amountIdx === false || ! isset($line[$staffIdIdx])) {
                continue;
            }

            $staffId = trim($line[$staffIdIdx]);
            $amount = trim($line[$amountIdx] ?? '');
            $shares = $sharesIdx !== false ? trim($line[$sharesIdx] ?? '') : '';

            if ($staffId === '') {
                continue;
            }

            $member = Member::query()->where('staff_id', $staffId)->where('status', 'active')->first();

            $error = null;
            if (! $member) {
                $error = 'No active member found for this Staff ID.';
            } elseif (! is_numeric($amount) || (float) $amount <= 0) {
                $error = 'Amount must be a positive number.';
            } elseif ($shares !== '' && (! ctype_digit($shares) || (int) $shares < 0)) {
                $error = 'Shares must be zero or a positive whole number.';
            }

            $rows[] = [
                'staff_id' => $staffId,
                'amount' => is_numeric($amount) ? (float) $amount : null,
                'shares' => $shares !== '' && ctype_digit($shares) ? (int) $shares : 0,
                'member_id' => $member?->id,
                'member_name' => $member?->full_name,
                // Looked up from the matched member's own record, purely for
                // the Treasurer's reference — never read from the uploaded
                // file, so it can't be spoofed or drift from the CSV.
                'ippis_number' => $member?->ippis_number,
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

        $storedPath = $this->file->store('contribution-batches', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = self::parseRows($fullPath);

        $matchedAmount = collect($rows)->where('matched', true)->sum('amount');
        $flaggedCount = collect($rows)->where('matched', false)->count();

        $batch = ContributionBatch::create([
            'period' => $validated['period'],
            'uploaded_by' => Auth::id(),
            'file_path' => $storedPath,
            'total_amount' => $matchedAmount,
            'total_records' => count($rows),
            'status' => 'validated',
            'rows' => $rows,
            'validation_errors' => $flaggedCount > 0 ? ['flagged_count' => $flaggedCount] : null,
        ]);

        $this->reset(['file']);
        $this->redirectRoute('treasurer.contribution-batches.show', $batch, navigate: true);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $members = Member::query()
            ->where('status', 'active')
            ->orderBy('department')
            ->orderBy('full_name')
            ->get(['staff_id', 'approved_monthly_contribution', 'ippis_number']);

        $filename = 'contribution-template-'.now()->format('Y-m').'.csv';

        return response()->streamDownload(function () use ($members) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['staff_id', 'amount', 'shares', 'ippis_number']);

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->staff_id,
                    number_format((float) $member->approved_monthly_contribution, 2, '.', ''),
                    0,
                    $member->ippis_number,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.contribution-batches', [
            'batches' => ContributionBatch::query()->with('uploadedBy')->latest()->paginate(15),
        ]);
    }
}
