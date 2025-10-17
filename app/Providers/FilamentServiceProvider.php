<?php

declare(strict_types=1);

namespace App\Providers;

use Aedart\Antivirus\Validation\Rules\InfectionFreeFile;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\BasePage;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Icons\Heroicon;
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

        FilamentColor::register([
            'primary' => [
                50 => 'oklch(0.955 0.022 234.95)',
                100 => 'oklch(0.91 0.046 235.11)',
                200 => 'oklch(0.822 0.1 229.95)',
                300 => 'oklch(0.733 0.123 227.95)',
                400 => 'oklch(0.648 0.108 227.64)',
                500 => 'oklch(0.563 0.093 227.13)',
                600 => 'oklch(0.486 0.081 227.41)',
                700 => 'oklch(0.398 0.066 227.38)',
                800 => 'oklch(0.306 0.052 228.99)',
                900 => 'oklch(0.221 0.036 227.7)',
                950 => 'oklch(0.175 0.029 225.09)',
            ],
        ]);

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

        Textarea::configureUsing(function (Textarea $component) {
            $component->autosize();
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

        Table::configureUsing(function (Table $table) {
            $table
                ->emptyStateIcon(function (Table $table) {
                    if (! $table->hasAlteredQuery()) {
                        return Heroicon::OutlinedClipboardDocument;
                    }
                })
                ->emptyStateHeading(function (Table $table) {
                    if (! $table->hasAlteredQuery()) {
                        return __($table->getModelLabel() . '.empty.title');
                    }
                })
                ->emptyStateDescription(function (Table $table) {
                    if (! $table->hasAlteredQuery()) {
                        return __($table->getModelLabel() . '.empty.description');
                    }
                });
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
