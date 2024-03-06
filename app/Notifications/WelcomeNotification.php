<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('welcome.email.subject'))
            ->greeting(__('welcome.email.greeting', [
                'name' => $notifiable->first_name,
            ]))
            ->line(__('welcome.email.intro'))
            ->line(__('welcome.email.steps.intro'))
            ->line(__('welcome.email.steps.set_password'))
            ->action(__('welcome.email.submit'), URL::signedRoute(
                'filament.auth.welcome',
                ['user' => $notifiable->id]
            ))
            ->line(__('welcome.email.steps.login'))
            ->when($notifiable->isNurse(), function (MailMessage $message) {
                $message->line(__('welcome.email.help.nurse'));
            });
    }
}
