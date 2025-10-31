<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\RelationManagers;

use App\Filament\Resources\Profiles\Schemas\CourseForm;
use App\Filament\Resources\Profiles\Schemas\CourseInfolist;
use App\Filament\Resources\Profiles\Tables\CoursesTable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static function getModelLabel(): ?string
    {
        return __('course.label.singular');
    }

    protected static function getPluralModelLabel(): string
    {
        return __('course.label.plural');
    }

    public function form(Schema $schema): Schema
    {
        return CourseForm::configure($schema);
    }

    public function infolist(Schema $schema): Schema
    {
        return CourseInfolist::configure($schema);
    }

    public function table(Table $table): Table
    {
        return CoursesTable::configure($table);
    }
}
