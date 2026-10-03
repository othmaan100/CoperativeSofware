<?php

namespace App\Livewire\Treasurer;

use App\Models\Member;
use App\Models\Setting;
use App\Models\WelfareLevyBatch;
use App\Models\WelfareLevyPayment;
use App\Support\Csv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WelfareLevyBatches extends Component
{
    use WithFileUploads, WithPagination;

    public string $period = '';

    public $file;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('post_welfare_levy'), 403);
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
     * A member only needs to be listed by staff_id — the amount is always
     * the current welfare_levy_amount setting, not a per-row figure, since
     * this is a fixed standing levy rather than a variable contribution.
     */
    public static function parseRows(string $fullPath, string $period): array
    {
        $rows = [];
        $handle = fopen($fullPath, 'r');
        $header = Csv::readHeader($handle);
        $staffIdIdx = array_search('staff_id', $header, true);

        while (($line = fgetcsv($handle)) !== false) {
            if ($staffIdIdx === false || ! isset($line[$staffIdIdx])) {
                continue;
            }

            $staffId = trim($line[$staffIdIdx]);
            if ($staffId === '') {
                continue;
            }

            $member = Member::query()->where('staff_id', $staffId)->where('status', 'active')->first();

            $error = null;
            if (! $member) {
                $error = 'No active member found for this Staff ID.';
            } elseif (WelfareLevyPayment::query()->where('member_id', $member->id)->where('period', $period)->exists()) {
                $error = 'Already recorded as paid for this period.';
            }

            $rows[] = [
                'staff_id' => $staffId,
                'member_id' => $member?->id,
                'member_name' => $member?->full_name,
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

        $storedPath = $this->file->store('welfare-levy-batches', 'local');
        $fullPath = Storage::disk('local')->path($storedPath);

        $rows = self::parseRows($fullPath, $validated['period']);
        $levyAmount = (float) Setting::get('welfare_levy_amount', 0);

        $matchedCount = collect($rows)->where('matched', true)->count();
        $flaggedCount = collect($rows)->where('matched', false)->count();

        $batch = WelfareLevyBatch::create([
            'period' => $validated['period'],
            'uploaded_by' => Auth::id(),
            'file_path' => $storedPath,
            'total_amount' => round($matchedCount * $levyAmount, 2),
            'total_records' => count($rows),
            'status' => 'validated',
            'rows' => $rows,
            'validation_errors' => $flaggedCount > 0 ? ['flagged_count' => $flaggedCount] : null,
        ]);

        $this->reset(['file']);
        $this->redirectRoute('treasurer.welfare-levy-batches.show', $batch, navigate: true);
    }

    public function downloadTemplate(): StreamedResponse
    {
        $members = Member::query()
            ->where('status', 'active')
            ->orderBy('department')
            ->orderBy('full_name')
            ->get(['staff_id', 'full_name', 'department']);

        $filename = 'welfare-levy-template-'.now()->format('Y-m').'.csv';

        return response()->streamDownload(function () use ($members) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['staff_id', 'full_name', 'department']);

            foreach ($members as $member) {
                fputcsv($handle, [$member->staff_id, $member->full_name, $member->department]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.welfare-levy-batches', [
            'batches' => WelfareLevyBatch::query()->with('uploadedBy')->latest()->paginate(15),
            'levyAmount' => (float) Setting::get('welfare_levy_amount', 0),
        ]);
    }
}
