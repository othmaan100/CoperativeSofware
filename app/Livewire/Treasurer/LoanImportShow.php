<?php

namespace App\Livewire\Treasurer;

use App\Models\LoanImportBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class LoanImportShow extends Component
{
    use WithFileUploads;

    public LoanImportBatch $batch;

    public $replacementFile;

    public function mount(LoanImportBatch $batch): void
    {
        abort_unless(Auth::user()->can('import_loans'), 403);
        $this->batch = $batch;
    }

    public function reupload(): void
    {
        abort_unless($this->batch->status !== 'imported', 400, 'An imported batch cannot be modified.');

        $this->validate(['replacementFile' => ['required', 'file', 'mimes:csv,txt', 'max:10240']]);

        $storedPath = $this->replacementFile->store('loan-imports', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = LoanImportBatch::parseAndValidate($fullPath);

        $this->batch->update([
            'file_path' => $storedPath,
            'rows' => $rows,
            'total_records' => count($rows),
            'status' => 'validated',
        ]);

        $this->reset(['replacementFile']);
        session()->flash('status', 'File replaced and re-validated.');
    }

    public function import(): void
    {
        abort_unless($this->batch->status === 'validated', 400, 'Only a validated batch can be imported.');

        if (empty($this->batch->matchedRows())) {
            session()->flash('error', 'No matched rows to import.');

            return;
        }

        $userId = Auth::id();
        $importedCount = 0;

        $updatedRows = collect($this->batch->rows)->map(function (array $row) use ($userId, &$importedCount) {
            if (! $row['matched']) {
                return $row;
            }

            try {
                $loan = DB::transaction(fn () => LoanImportBatch::importRow($row, $userId));
                $row['loan_id'] = $loan->id;
                $row['loan_no'] = $loan->loan_no;
                $importedCount++;
            } catch (\Throwable $e) {
                $row['matched'] = false;
                $row['error'] = 'Import failed: '.$e->getMessage();
            }

            return $row;
        })->all();

        $this->batch->update([
            'rows' => $updatedRows,
            'status' => 'imported',
            'imported_count' => $importedCount,
            'imported_at' => now(),
        ]);

        session()->flash('status', "{$importedCount} legacy loan(s) imported successfully.");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.loan-import-show');
    }
}
