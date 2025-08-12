<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Infolists;
use Filament\Pages\BasePage;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables;
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

        $this->configurePages();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function configurePages(): void
    {
        Page::alignFormActionsEnd();
        BasePage::stickyFormActions();

        CreateRecord::disableCreateAnother();
    }

    protected function setDateTimeDisplayFormats(): void
    {
        Tables\Table::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Tables\Table::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Tables\Table::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Infolists\Infolist::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Infolists\Infolist::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Infolists\Infolist::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Forms\Components\DateTimePicker::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Forms\Components\DateTimePicker::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Forms\Components\DateTimePicker::$defaultDateTimeWithSecondsDisplayFormat = static::$defaultDateTimeWithSecondsDisplayFormat;
        Forms\Components\DateTimePicker::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;
        Forms\Components\DateTimePicker::$defaultTimeWithSecondsDisplayFormat = static::$defaultTimeWithSecondsDisplayFormat;

        Carbon::macro('toFormattedDate', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateDisplayFormat));
        Carbon::macro('toFormattedDateTime', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateTimeDisplayFormat));
        Carbon::macro('toFormattedDateTimeWithSeconds', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateTimeWithSecondsDisplayFormat));
        Carbon::macro('toFormattedTime', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultTimeDisplayFormat));
    }
}
