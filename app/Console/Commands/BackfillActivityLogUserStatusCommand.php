<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\User\Status;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Symfony\Component\Console\Helper\ProgressBar;

class BackfillActivityLogUserStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activity:user-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill status on user activity_log entries based on deactivated_at and password_set_at.';

    protected ProgressBar $progressBar;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $users = User::query();

        $this->progressBar = $this->output->createProgressBar($users->count());
        $this->progressBar->start();

        $users
            ->with([
                'activities' => fn (MorphMany $query): MorphMany => $query
                    ->where('log_name', 'default')
                    ->whereJsonDoesntContainKey('properties->attributes->status')
                    ->withoutGlobalScope('latest'),
            ])
            ->each(function (User $user): void {
                logger()->info("=========================== User: {$user->id} ===========================");
                if ($user->deactivated_at) {
                    logger()->info("=========================== Deactivated_at: {$user->deactivated_at} ===========================");
                }
                $this->backfillForUser($user);
                $this->progressBar->advance();
            }, 100);

        return self::SUCCESS;
    }

    protected function backfillForUser(User $user): void
    {
        $currentDeactivatedAt = null;

        foreach ($user->activities as $activity) {
            $properties = $activity->properties->toArray();

            $oldDeactivatedAt = data_get($properties, 'old.deactivated_at', $currentDeactivatedAt);
            $newDeactivatedAt = data_get($properties, 'attributes.deactivated_at', $currentDeactivatedAt);

            $oldPasswordSet = filled($user->password_set_at) && $activity->created_at->greaterThan($user->password_set_at);
            $newPasswordSet = filled($user->password_set_at) && $activity->created_at->greaterThanOrEqualTo($user->password_set_at);

            $oldStatus = $this->resolveStatus($oldDeactivatedAt, $oldPasswordSet);
            $newStatus = $this->resolveStatus($newDeactivatedAt, $newPasswordSet);

            if (
                filled($user->deactivated_at) &&
                $activity->created_at->diffInSeconds($user->deactivated_at) <= 1
            ) {
                $newStatus = Status::INACTIVE;
            }

            if (
                $oldStatus !== $newStatus ||
                ($oldStatus->is(Status::INVITED) && $activity->event === 'created')
            ) {
                if (\array_key_exists('old', $properties) || $activity->event !== 'created') {
                    data_set($properties, 'old.status', $oldStatus->value);
                }

                data_set($properties, 'attributes.status', $newStatus->value);

                // logger()->info('Backfilling activity log entry', [
                //     'activity_id' => $activity->id,
                //     'user_id' => $user->id,
                //     'old_status' => $oldStatus->value,
                //     'new_status' => $newStatus->value,
                // ]);

                $activity->properties = $properties;
                $activity->saveQuietly();
            } else {
                // logger()->info('No status change', [
                //     'activity_id' => $activity->id,
                //     'status' => $oldStatus->value,
                // ]);
            }

            $currentDeactivatedAt = $newDeactivatedAt;
        }
    }

    protected function resolveStatus(mixed $deactivatedAt, bool $passwordSet): Status
    {
        if ($deactivatedAt !== null) {
            return Status::INACTIVE;
        }

        if (! $passwordSet) {
            return Status::INVITED;
        }

        return Status::ACTIVE;
    }
}
