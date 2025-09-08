<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\BasePage;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
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

        $this->configureInfolistComponents();
        $this->configurePages();
        $this->configureTables();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function configureInfolistComponents(): void
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
        Table::configureUsing(function (Table $table) {
            // TODO: configure conditional empty state
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
    }
}
