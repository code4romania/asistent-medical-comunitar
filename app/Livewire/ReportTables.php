<?php

declare(strict_types=1);

namespace App\Livewire;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class ReportTables extends Component
{
    use InteractsWithRecord;
    use WithPagination;

    public int $perPage = 5;

    protected string $pageName = 'tablesPage';

    /**
     * @return LengthAwarePaginator<int, array<string, mixed>>
     */
    public function getTablesProperty(): LengthAwarePaginator
    {
        $tables = $this->getRecord()->data;

        $page = $this->getPage($this->pageName);

        return new Paginator(
            $tables->forPage($page, $this->perPage)->values(),
            $tables->count(),
            $this->perPage,
            $page,
            [
                'pageName' => $this->pageName,
                'path' => Paginator::resolveCurrentPath(),
            ],
        );
    }

    public function render(): View
    {
        return view('livewire.report-tables');
    }
}
