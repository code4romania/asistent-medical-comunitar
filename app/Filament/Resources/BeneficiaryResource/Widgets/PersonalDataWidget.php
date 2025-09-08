<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Widgets;

use App\Concerns\Forms\HasComponentActions;
use App\Enums\Beneficiary\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Infolists\Components\BooleanEntry;
use App\Models\Beneficiary;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Widgets\Widget;

class PersonalDataWidget extends Widget implements HasForms, HasInfolists
{
    use EvaluatesClosures;
    use InteractsWithForms;
    use InteractsWithInfolists;
    use HasComponentActions;

    protected static string $view = 'filament.resources.beneficiary-resource.widgets.personal-data';

    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        '2xl' => 1,
    ];

    public function __construct($id = null)
    {
        $this->headerActions(fn () => [
            Action::make('view')
                ->label(__('beneficiary.action.view_details'))
                ->url(BeneficiaryResource::getUrl('personal_data', ['record' => $this->record]))
                ->color('gray'),
        ]);
    }

    protected function getHeading(): string
    {
        return __('beneficiary.section.personal_data');
    }

    protected function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->columns()
            ->schema([
                TextEntry::make('status')
                    ->hiddenLabel()
                    ->badge()
                    ->columnSpanFull(),

                TextEntry::make('reason_removed')
                    ->label(__('field.reason_removed'))
                    ->visible(fn (Beneficiary $record) => $record->status->is(Status::REMOVED))
                    ->columnSpanFull(),

                TextEntry::make('id')
                    ->label(__('field.beneficiary_id')),

                BooleanEntry::make('integrated')
                    ->label(__('field.integrated')),

                TextEntry::make('household.name')
                    ->label(__('field.household')),

                TextEntry::make('family.name')
                    ->label(__('field.family')),

                TextEntry::make('age')
                    ->label(__('field.age')),

                TextEntry::make('gender')
                    ->label(__('field.gender')),

                TextEntry::make('full_address')
                    ->label(__('field.address'))
                    ->columnSpanFull(),

                TextEntry::make('phone')
                    ->label(__('field.phone'))
                    ->columnSpanFull(),
            ]);
    }
}
