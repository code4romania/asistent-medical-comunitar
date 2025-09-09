<?php

declare(strict_types=1);

namespace App\Providers;

use Aedart\Antivirus\Validation\Rules\InfectionFreeFile;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\BasePage;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public static string $defaultDateDisplayFormat = 'd.m.Y';

    public static string $defaultDateTimeDisplayFormat = 'd.m.Y H:i';

    public static string $defaultDateTimeWithSecondsDisplayFormat = 'd.m.Y H:i:s';

    public static string $defaultTimeDisplayFormat = 'H:i';

    public static string $defaultTimeWithSecondsDisplayFormat = 'H:i:s';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->setDateTimeDisplayFormats();

        $this->configureActions();
        $this->configureForms();
        $this->configureInfolists();
        $this->configurePages();
        $this->configureTables();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::registerRenderHook('head.end', fn () => view('components.favicons'));
    }

    protected function configureActions(): void
    {
        Action::configureUsing(function (Action $action) {
            if (! $action->isConfirmationRequired()) {
                return $action->modalFooterActionsAlignment(Alignment::End);
            }

            return $action;
        }, isImportant: true);
    }

    protected function configureForms(): void
    {
        SpatieMediaLibraryFileUpload::configureUsing(function (SpatieMediaLibraryFileUpload $component) {
            $component->rule(new InfectionFreeFile);
        });
    }

    protected function configureInfolists(): void
    {
        TextEntry::configureUsing(function (TextEntry $entry) {
            // return $entry->default('—');
        });
    }

    protected function configurePages(): void
    {
        Page::alignFormActionsEnd();
        BasePage::stickyFormActions();

        CreateRecord::disableCreateAnother();
    }

    protected function configureTables(): void
    {
        Table::macro('hasAlteredQuery', function (): bool {
            return $this->hasSearch() || $this->isFiltered();
        });
    }

    protected function setDateTimeDisplayFormats(): void
    {
        Table::configureUsing(fn (Table $table) => $table->defaultDateDisplayFormat(static::$defaultDateDisplayFormat));
        Table::configureUsing(fn (Table $table) => $table->defaultDateTimeDisplayFormat(static::$defaultDateTimeDisplayFormat));
        Table::configureUsing(fn (Table $table) => $table->defaultTimeDisplayFormat(static::$defaultTimeDisplayFormat));

        Schema::configureUsing(fn (Schema $schema) => $schema->defaultDateDisplayFormat(static::$defaultDateDisplayFormat));
        Schema::configureUsing(fn (Schema $schema) => $schema->defaultDateTimeDisplayFormat(static::$defaultDateTimeDisplayFormat));
        Schema::configureUsing(fn (Schema $schema) => $schema->defaultTimeDisplayFormat(static::$defaultTimeDisplayFormat));

        DateTimePicker::configureUsing(fn (DateTimePicker $dateTimePicker) => $dateTimePicker->defaultDateDisplayFormat(static::$defaultDateDisplayFormat));
        DateTimePicker::configureUsing(fn (DateTimePicker $dateTimePicker) => $dateTimePicker->defaultDateTimeDisplayFormat(static::$defaultDateTimeDisplayFormat));
        DateTimePicker::configureUsing(fn (DateTimePicker $dateTimePicker) => $dateTimePicker->defaultDateTimeWithSecondsDisplayFormat(static::$defaultDateTimeWithSecondsDisplayFormat));
        DateTimePicker::configureUsing(fn (DateTimePicker $dateTimePicker) => $dateTimePicker->defaultTimeDisplayFormat(static::$defaultTimeDisplayFormat));
        DateTimePicker::configureUsing(fn (DateTimePicker $dateTimePicker) => $dateTimePicker->defaultTimeWithSecondsDisplayFormat(static::$defaultTimeWithSecondsDisplayFormat));

        Carbon::macro('toFormattedDate', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateDisplayFormat));
        Carbon::macro('toFormattedDateTime', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateTimeDisplayFormat));
        Carbon::macro('toFormattedDateTimeWithSeconds', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateTimeWithSecondsDisplayFormat));
        Carbon::macro('toFormattedTime', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultTimeDisplayFormat));
        Carbon::macro('toFormattedTimeWithSeconds', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultTimeWithSecondsDisplayFormat));
    }
}
