<?php

namespace App\Livewire\Treasurer;

use App\Models\MemberImportBatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberImports extends Component
{
    use WithFileUploads, WithPagination;

    public $file;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('import_members'), 403);
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

        $storedPath = $this->file->store('member-imports', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = MemberImportBatch::parseAndValidate($fullPath);

        $batch = MemberImportBatch::create([
            'uploaded_by' => Auth::id(),
            'file_path' => $storedPath,
            'total_records' => count($rows),
            'status' => 'validated',
            'rows' => $rows,
        ]);

        $this->reset(['file']);
        $this->redirectRoute('treasurer.member-imports.show', $batch, navigate: true);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $filename = 'member-import-template.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            $headers = [
                'staff_id', 'full_name', 'gender', 'marital_status',
                'home_address', 'phone_1', 'phone_2', 'email', 'ippis_number',
                'department', 'date_of_first_appointment', 'employment_status', 'rank_grade',
                'preferred_monthly_contribution', 'approved_monthly_contribution', 'mode_of_deduction',
                'current_savings_balance', 'membership_no', 'membership_date',
                'nok_name', 'nok_relationship', 'nok_phone', 'nok_address',
            ];
            fputcsv($handle, $headers);

            // One example row showing the expected format.
            fputcsv($handle, [
                'FCET-1001', 'Jane Doe', 'female', 'married',
                '12 Coop Street, Potiskum', '08010000000', '', 'jane.doe@example.com', '',
                'Bursary', '2010-01-15', 'permanent', 'Level 8',
                '6000', '6000', 'salary_deduction',
                '45000', '', '2015-06-01',
                'John Doe', 'Spouse', '08020000000', '',
            ]);

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.member-imports', [
            'batches' => MemberImportBatch::query()->with('uploadedBy')->latest()->paginate(15),
        ]);
    }
}
