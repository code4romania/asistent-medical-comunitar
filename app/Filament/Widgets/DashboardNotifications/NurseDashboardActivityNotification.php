<?php

declare(strict_types=1);

namespace App\Filament\Widgets\DashboardNotifications;

use App\Models\Activity;
use Filament\Widgets\Widget;

class NurseDashboardActivityNotification extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-notification';

    protected int|string|array $columnSpan = 'full';

    private ?string $notificationText = 'Nu ați introdus activitate în platformă de mai mult de o săptămână!';

    public static function canView(): bool
    {

        return auth()->user()->isNurse();
    }

    public function getNotification(): string|null
    {

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

            return $this->notificationText;
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
            'properties' => ['notification' => $this->notificationText]
        ]);

    }

}


