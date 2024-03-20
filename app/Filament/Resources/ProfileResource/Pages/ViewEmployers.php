<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Repeater;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Models\Profile\Employer;
use Filament\Resources\Form;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ViewEmployers extends ViewRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(static::getSchema());
    }

    public static function getSchema(): array
    {
        return [
            Repeater::make('employers')
                ->relationship(callback: fn (Builder $query) => $query->withLocation())
                ->label(__('employer.label.plural'))
                ->schema([
                    Subsection::make()
                        ->icon('heroicon-o-office-building')
                        ->columns(2)
                        ->schema([
                            Value::make('name')
                                ->label(__('field.employer_name')),

                            Value::make('type')
                                ->label(__('field.employer_type')),

                            Value::make('funding')
                                ->label(__('field.funding')),

                            Value::make('project')
                                ->label(__('field.employer_project'))
                                ->hidden(fn (Employer $record) => empty($record->project))
                                ->columnSpanFull(),

                            Location::make(),

                            Value::make('email')
                                ->label(__('field.employer_email')),

                            Value::make('phone')
                                ->label(__('field.employer_phone')),

                            Value::make('start_date')
                                ->label(__('field.start_date')),

                            Value::make('end_date')
                                ->label(__('field.end_date'))
                                ->fallback(__('field.employer_ongoing')),

                            Value::make('has_gp_agreement')
                                ->label(__('field.has_gp_agreement'))
                                ->boolean(),

                            Value::make('gp_name')
                                ->label(__('field.gp_name'))
                                ->hidden(fn (Employer $record) => ! $record->has_gp_agreement),

                            Value::make('gp_email')
                                ->label(__('field.gp_email'))
                                ->hidden(fn (Employer $record) => ! $record->has_gp_agreement),

                            Value::make('gp_phone')
                                ->label(__('field.gp_phone'))
                                ->hidden(fn (Employer $record) => ! $record->has_gp_agreement),

                        ]),
                ]),
        ];
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
