<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Actions;

use App\Filament\Resources\ReportResource;
use App\Models\Report;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;

class SaveReportAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'save_report';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('report.action.save'));

        $this->icon('heroicon-o-bookmark-alt');

        $this->successNotificationTitle(__('filament-support::actions/create.single.messages.created'));

        $this->successRedirectUrl(function (Report $record) {
            return ReportResource::getUrl('view', $record);
        });

        $this->action(function (Page $livewire) {
            $data = $livewire->form->getState();
            $data['user_id'] = auth()->id();

            $record = Report::create($data);

            $this->record($record);

            $this->success();
        });
    }
}
