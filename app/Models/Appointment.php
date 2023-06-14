<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\TimeCast;
use App\Concerns\BelongsToBeneficiary;
use App\Concerns\BelongsToNurse;
use App\Filament\Resources\AppointmentResource;
use App\Models\Intervention\InterventionableIndividualService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    use BelongsToBeneficiary;
    use BelongsToNurse;
    use HasFactory;

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
        return sprintf('#%d / %s', $this->id, $this->date->toFormattedDate());
    }

    public function getUrlAttribute(): string
    {
        return AppointmentResource::getUrl('view', $this);
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

    public function updateDateTime(string $start, string $end)
    {
        $start = Carbon::createFromTimeString($start);
        $end = Carbon::createFromTimeString($end);

        $this->update([
            'date' => $start->format('Y-m-d'),
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
        ]);
    }
}
