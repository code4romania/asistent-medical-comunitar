<?php

declare(strict_types=1);

namespace App\Filament\Widgets\DashboardNotifications;

use App\Models\Activity;
use App\Models\User;
use Filament\Widgets\Widget;

class CoordDashboardActivityNotification extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-notification';

    protected int|string|array $columnSpan = 'full';


    private ?string $pluralNotificationText = ' utilizatori nu au introdus activitate pentru luna precedentă!';
    private ?string $singleNotificationText = '1 utilizator nu a introdus activitate pentru luna precedentă!';

    public static function canView(): bool
    {

        return auth()->user()->isCoordinator();
    }

    public function isCoordinator(): bool
    {
        return auth()->user()->isCoordinator();
    }

    public function getNotification(): string|null
    {

        $countOfUsersWithoutActivity = User::query()
            ->onlyNurses()
            ->activatesInCounty(auth()->user()->county_id)
            ->whereNotIn('id', function ($query) {
                $query->select('subject_id')
                    ->from('activity_log')
                    ->where('subject_type', 'intervention')
                    ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
                    ->whereNot('event', 'dismissed');
            })
            ->count();

        if ($countOfUsersWithoutActivity === 1) {
            return $this->singleNotificationText;
        }

        if ($countOfUsersWithoutActivity > 1) {
            return $countOfUsersWithoutActivity . $this->pluralNotificationText;
        }

        return null;

    }

    public function getNotificationIcon(): string
    {
        return 'resources/svg/danger.svg';

    }

    public function dismissNotification(): void
    {
        // NOT sure about this part
        Activity::create([
            'subject_id' => auth()->id(),
            'causer_id' => auth()->id(),
            'event' => 'dismissed',
            'log_name' => 'default',
            'subject_type' => 'intervention',
            'causer_type' => 'user',
            'description' => 'dismissed notification',
            'properties' => ['notification' => $this->notificationText]
        ]);

    }

}


