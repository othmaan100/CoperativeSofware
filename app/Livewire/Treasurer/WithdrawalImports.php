<?php

namespace App\Livewire\Treasurer;

use App\Models\WithdrawalImportBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WithdrawalImports extends Component
{
    use WithFileUploads, WithPagination;

    public $file;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('post_contribution_batch'), 403);
    }

    public function processUpload(): void
    {
        $this->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:5120']]);

        $storedPath = $this->file->store('withdrawal-imports', 'local');

        try {
            $rows = WithdrawalImportBatch::checkAgainstLedger(
                WithdrawalImportBatch::parseFile(Storage::disk('local')->path($storedPath))
            );
        } catch (RuntimeException $e) {
            $this->addError('file', $e->getMessage());

            return;
        }

        if (! $rows) {
            $this->addError('file', 'The file has no withdrawal rows.');

            return;
        }

        $batch = WithdrawalImportBatch::create([
            'uploaded_by' => Auth::id(),
            'file_path' => $storedPath,
            'total_amount' => collect($rows)->where('matched', true)->sum('amount'),
            'total_records' => count($rows),
            'status' => 'validated',
            'rows' => $rows,
        ]);

        $this->reset('file');
        $this->redirectRoute('treasurer.withdrawal-imports.show', $batch, navigate: true);
    }

    public function downloadTemplate(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, WithdrawalImportBatch::TEMPLATE_COLUMNS);
            fclose($handle);
        }, 'withdrawal-import-template.csv', ['Content-Type' => 'text/csv']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.withdrawal-imports', [
            'batches' => WithdrawalImportBatch::query()->with('uploadedBy')->latest()->paginate(15),
        ]);
    }
}
