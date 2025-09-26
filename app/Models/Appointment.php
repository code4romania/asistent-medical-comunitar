<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\TimeCast;
use App\Concerns\BelongsToBeneficiary;
use App\Concerns\BelongsToNurse;
use App\Filament\Resources\Appointments\AppointmentResource;
use App\Models\Intervention\InterventionableIndividualService;
use Carbon\Carbon;
use DateTime;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\CalendarEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Appointment extends Model implements Eventable
{
    use BelongsToBeneficiary;
    use BelongsToNurse;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'type',
        'location',
        'attendant',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => TimeCast::class,
        'end_time' => TimeCast::class,
    ];

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class)
            ->whereMorphedTo('interventionable', InterventionableIndividualService::class);
    }

    public function scopeBetweenDates(Builder $query, ?string $from = null, ?string $until = null): Builder
    {
        return $query
            ->when($from, function (Builder $query, string $date) {
                $query->whereDate('date', '>=', $date);
            })
            ->when($until, function (Builder $query, string $date) {
                $query->whereDate('date', '<=', $date);
            });
    }

    public function scopeLastMonth(Builder $query): Builder
    {
        return $query
            ->whereDate('date', '>=', today()->subMonth())
            ->whereDate('date', '<=', today());
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('date', '>=', today())
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc');
    }

    public function scopeCountUnique(Builder $query): Builder
    {
        return $query->select(DB::raw(<<<'SQL'
            COUNT(DISTINCT(appointments.id))
        SQL));
    }

    public function getLabelAttribute(): string
    {
        return \sprintf('#%d / %s', $this->id, $this->date->toFormattedDate());
    }

    public function getUrlAttribute(): string
    {
        return AppointmentResource::getUrl('view', [
            'record' => $this,
        ]);
    }

    public function getStartAttribute(): DateTime
    {
        return $this->date->copy()
            ->setTimeFrom($this->start_time);
    }

    public function getEndAttribute(): DateTime
    {
        return $this->date->copy()
            ->setTimeFrom($this->end_time);
    }

    public function updateDateTime(Carbon $start, Carbon $end): bool
    {
        if ($start->isAfter($end)) {
            return false;
        }

        $this->update([
            'date' => $start->format('Y-m-d'),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
        ]);

        return true;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function toCalendarEvent(): CalendarEvent
    {
        return CalendarEvent::make($this)
            ->resourceId('appointments')
            ->title($this->type)
            ->start($this->start)
            ->end($this->end)
            ->extendedProp('description', \sprintf('#%d - %s', $this->id, $this->beneficiary->full_name));
    }
}
