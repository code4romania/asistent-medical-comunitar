<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Actions\ActivateUserAction;
use App\Filament\Resources\UserResource\Actions\DeactivateUserAction;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            ActivateUserAction::make()
                ->record($this->getRecord()),

            DeactivateUserAction::make()
                ->record($this->getRecord()),
        ];
    }

    public function mount($record): void
    {
        static::authorizeResourceAccess();

        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canView($this->getRecord()), 403);

        if ($this->record->isNurse()) {
            redirect()->to(static::getResource()::getUrl('general.view', $this->record));
        }
    }

    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Card::make()
                    ->schema([
                        Subsection::make()
                            ->icon('heroicon-o-user')
                            ->columns(2)
                            ->schema([

                                Value::make('first_name')
                                    ->label(__('field.first_name')),

                                Value::make('last_name')
                                    ->label(__('field.last_name')),

                                Value::make('email')
                                    ->label(__('field.email')),

                                Value::make('phone')
                                    ->label(__('field.phone')),

                                Value::make('role')
                                    ->label(__('field.role')),

                                Location::make()
                                    ->label(__('field.county'))
                                    ->withoutCity()
                                    ->visible(fn (User $record) => $record->isCoordinator())
                                    ->columnSpan(1),

                            ]),
                    ]),

            ]);
    }
}
