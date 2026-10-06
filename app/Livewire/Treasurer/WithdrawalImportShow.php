<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\WithdrawalImportBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use RuntimeException;

class WithdrawalImportShow extends Component
{
    use WithFileUploads;

    public WithdrawalImportBatch $batch;

    public $replacementFile;

    public function mount(WithdrawalImportBatch $batch): void
    {
        abort_unless(Auth::user()->can('post_contribution_batch'), 403);
        $this->batch = $batch;
    }

    public function reupload(): void
    {
        abort_if($this->batch->status === 'posted', 400, 'A posted import cannot be modified.');

        $this->validate(['replacementFile' => ['required', 'file', 'mimes:csv,txt', 'max:5120']]);

        $storedPath = $this->replacementFile->store('withdrawal-imports', 'local');

        try {
            $rows = WithdrawalImportBatch::checkAgainstLedger(
                WithdrawalImportBatch::parseFile(Storage::disk('local')->path($storedPath))
            );
        } catch (RuntimeException $e) {
            $this->addError('replacementFile', $e->getMessage());

            return;
        }

        $this->batch->update([
            'file_path' => $storedPath,
            'rows' => $rows,
            'total_records' => count($rows),
            'total_amount' => collect($rows)->where('matched', true)->sum('amount'),
        ]);

        $this->reset('replacementFile');
        session()->flash('status', 'File replaced and checked again.');
    }

    public function recheck(): void
    {
        abort_if($this->batch->status === 'posted', 400, 'A posted import cannot be modified.');

        $this->batch->recheck();
        session()->flash('status', 'Rows checked again against the current savings records.');
    }

    public function post(): void
    {
        abort_if($this->batch->status === 'posted', 400, 'This import has already been posted.');

        try {
            $count = $this->batch->post(Auth::id());
        } catch (RuntimeException $e) {
            session()->flash('error', $e->getMessage());

            return;
        }

        ActivityLog::record(
            action: 'savings.withdrawal_import_posted',
            description: "Posted withdrawal import #{$this->batch->id} ({$count} withdrawal(s), ₦".number_format((float) $this->batch->total_amount, 2).').',
            subject: $this->batch,
            properties: ['withdrawals' => $count, 'total_amount' => (float) $this->batch->total_amount],
        );

        session()->flash('status', "{$count} withdrawal(s) recorded against members' savings, each on its withdrawal date.");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.withdrawal-import-show');
    }
}
