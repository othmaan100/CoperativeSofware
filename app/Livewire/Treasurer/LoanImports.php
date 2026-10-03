<?php

namespace App\Livewire\Treasurer;

use App\Models\LoanImportBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LoanImports extends Component
{
    use WithFileUploads, WithPagination;

    public $file;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('import_loans'), 403);
    }

    protected function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ];
    }

    public function processUpload(): void
    {
        $this->validate();

        $storedPath = $this->file->store('loan-imports', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = LoanImportBatch::parseAndValidate($fullPath);

        $batch = LoanImportBatch::create([
            'uploaded_by' => Auth::id(),
            'file_path' => $storedPath,
            'total_records' => count($rows),
            'status' => 'validated',
            'rows' => $rows,
        ]);

        $this->reset(['file']);
        $this->redirectRoute('treasurer.loan-imports.show', $batch, navigate: true);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $filename = 'loan-import-template.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['staff_id', 'loan_product', 'principal_amount', 'total_interest', 'tenure_months', 'disbursed_date', 'amount_repaid']);

            fputcsv($handle, ['FCET-1001', 'regular', '100000', '10000', '10', '2025-06-01', '33000']);

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.loan-imports', [
            'batches' => LoanImportBatch::query()->with('uploadedBy')->latest()->paginate(15),
        ]);
    }
}
