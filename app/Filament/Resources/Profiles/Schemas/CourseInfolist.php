<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('field.course_name')),

                TextEntry::make('theme')
                    ->label(__('field.course_theme')),

                TextEntry::make('type')
                    ->label(__('field.course_type')),

                TextEntry::make('credits')
                    ->label(__('field.course_credits')),

                TextEntry::make('provider')
                    ->label(__('field.course_provider'))
                    ->columnSpanFull(),

                TextEntry::make('start_date')
                    ->label(__('field.start_date'))
                    ->date(),

                TextEntry::make('end_date')
                    ->label(__('field.end_date'))
                    ->date(),
            ]);
    }
}
