<?php

declare(strict_types=1);

namespace App\Filament\Widgets\DashboardNotifications;

use App\Models\Activity;
use Filament\Widgets\Widget;

class NurseDashboardActivityNotification extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-notification';

    protected int|string|array $columnSpan = 'full';
    private ?string $oneWeekNotification = 'Nu ați introdus activitate în platformă de mai mult de o săptămână!';
    private ?string $oneMonthNotification = 'Mai aveți 5 zile pentru a introduce activitatea pentru luna precedentă! Dacă nu introduceți la timp activitatea, nu veți mai avea posibilitatea să o introduceți și veți suferi consecințe!';
    public bool $hideDismissButton = false;

    public static function canView(): bool
    {

        return auth()->user()->isNurse();
    }


    public function getNotification(): string|null
    {

        $lastMonthActivityCount = Activity::query()
            ->where('subject_id', auth()->id())
            ->where('subject_type', 'intervention')
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->whereNot('event', 'dismissed')
            ->count();

        /**
         * Checks if the user has no activity in the last month, and it's within the first 5 days of the current month.
         * If true, hides the dismiss button and returns the one-month notification.
         */
        if ($lastMonthActivityCount < 1 && now()->day <= 5) {
            $this->hideDismissButton = true;
            return $this->oneMonthNotification;
        }


        $latestActivity = Activity::latest()
            ->where('subject_id', auth()->id())
            ->where('subject_type', 'intervention')
            ->whereNot('event', 'dismissed')
            ->first();

        $notificationDismissed = Activity::latest()
            ->where('subject_id', auth()->id())
            ->where('subject_type', 'intervention')
            ->where('event', 'dismissed')
            ->first();


        // Notification was already dismissed
        if ($notificationDismissed && $notificationDismissed->created_at->gt($latestActivity->created_at)) {
            return null;
        }

        // No activity in the last 7 days
        if ($latestActivity && $latestActivity->created_at->lt(now()->subDays(7))) {
            return $this->oneWeekNotification;
        }

        return null;
    }

    public function getNotificationIcon(): string
    {
        return 'resources/svg/warning.svg';

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
            'properties' => ['notification' => $this->oneWeekNotification]
        ]);

    }

}


