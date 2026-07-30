<?php

declare(strict_types=1);

namespace App\Filament\Resources\Feedback\Schemas;

use App\Filament\Infolists\Components\Location;
use App\Models\Feedback;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FeedbackInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')
                    ->label(__('field.category'))
                    ->columnSpanFull(),

                TextEntry::make('subcategory.name')
                    ->label(__('field.subcategory'))
                    ->visible(fn (Feedback $record): bool => filled($record->subcategory_id))
                    ->columnSpanFull(),

                TextEntry::make('description')
                    ->label(__('field.notes'))
                    ->columnSpanFull(),

                Location::make()
                    ->contained(false),

                TextEntry::make('created_at')
                    ->label(__('field.date'))
                    ->date(),

                TextEntry::make('user.full_name')
                    ->label(__('field.user'))
                    ->helperText(fn (Feedback $record): string => $record->user->role->getLabel())
                    ->visible(fn (): bool => auth()->user()->isAdmin()),

                TextEntry::make('county.name')
                    ->label(__('field.county'))
                    ->visible(fn (): bool => auth()->user()->isAdmin()),

                TextEntry::make('city.name')
                    ->label(__('field.city'))
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
            ]);
    }
}
