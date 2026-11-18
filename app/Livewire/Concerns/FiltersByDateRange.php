<?php

namespace App\Livewire\Concerns;

/**
 * A From / To date filter for paginated Livewire record lists. The using
 * component applies validDate($this->dateFrom) / validDate($this->dateTo) to
 * whichever date column suits its records; an empty or invalid date simply
 * means "no limit on that side".
 */
trait FiltersByDateRange
{
    /** Y-m-d, or '' for no lower limit. */
    public string $dateFrom = '';

    /** Y-m-d, or '' for no upper limit. */
    public string $dateTo = '';

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function clearDates(): void
    {
        $this->reset(['dateFrom', 'dateTo']);
        $this->resetPage();
    }

    /** Returns the date as Y-m-d if it is a real calendar date, otherwise null (filter ignored). */
    protected function validDate(string $value): ?string
    {
        $date = \DateTime::createFromFormat('!Y-m-d', $value);

        return $date && $date->format('Y-m-d') === $value ? $value : null;
    }
}
