<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLogViewer extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $module = '';

    #[Url(history: true)]
    public string $causer_id = '';

    #[Url(history: true)]
    public string $date_from = '';

    #[Url(history: true)]
    public string $date_to = '';

    #[Url(history: true)]
    public string $search = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_activity_log'), 403);
    }

    public function updatedModule(): void
    {
        $this->resetPage();
    }

    public function updatedCauserId(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['module', 'causer_id', 'date_from', 'date_to', 'search']);
        $this->resetPage();
    }

    /**
     * The set of distinct "modules" (the dot-prefix of every action, e.g.
     * "loan" from "loan.disbursed") seen in the log so far, for the filter
     * dropdown — built from real data rather than a hardcoded list, so it
     * never drifts out of sync with what's actually being recorded.
     */
    protected function modules(): array
    {
        return ActivityLog::query()
            ->select('action')
            ->distinct()
            ->pluck('action')
            ->map(fn ($action) => explode('.', $action)[0])
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    protected function causersWithActivity()
    {
        return User::query()
            ->whereIn('id', ActivityLog::query()->whereNotNull('causer_id')->distinct()->pluck('causer_id'))
            ->orderBy('name')
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = ActivityLog::query()->with('causer');

        if ($this->module !== '') {
            $query->where('action', 'like', $this->module.'.%');
        }

        if ($this->causer_id !== '') {
            $query->where('causer_id', $this->causer_id);
        }

        if ($this->date_from !== '') {
            $query->whereDate('created_at', '>=', $this->date_from);
        }

        if ($this->date_to !== '') {
            $query->whereDate('created_at', '<=', $this->date_to);
        }

        if ($this->search !== '') {
            $query->where('description', 'like', '%'.$this->search.'%');
        }

        return view('livewire.admin.activity-log-viewer', [
            'logs' => $query->latest('created_at')->paginate(30),
            'modules' => $this->modules(),
            'causers' => $this->causersWithActivity(),
        ]);
    }
}
