<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Vulnerability\AgeCategory;
use App\Enums\Vulnerability\Disability;
use App\Enums\Vulnerability\DomesticViolence;
use App\Enums\Vulnerability\Education;
use App\Enums\Vulnerability\Family;
use App\Enums\Vulnerability\FamilyDoctor;
use App\Enums\Vulnerability\Habitation;
use App\Enums\Vulnerability\IDType;
use App\Enums\Vulnerability\Income;
use App\Enums\Vulnerability\Poverty;
use App\Enums\Vulnerability\SocialHealthInsurance;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Catagraphy extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'age_category',
        'disability',
        'domestic_violence',
        'education',
        'family_doctor',
        'family',
        'habitation',
        'id_type',
        'income',
        'poverty',
        'social_health_insurance',
        'evaluation_date',
        'nurse_id',
        'notes',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'age_category' => AgeCategory::class,
        'disability' => Disability::class,
        'domestic_violence' => AsEnumCollection::class . ':' . DomesticViolence::class,
        'education' => Education::class,
        'family_doctor' => FamilyDoctor::class,
        'family' => AsEnumCollection::class . ':' . Family::class,
        'habitation' => AsEnumCollection::class . ':' . Habitation::class,
        'id_type' => IDType::class,
        'income' => Income::class,
        'poverty' => Poverty::class,
        'social_health_insurance' => SocialHealthInsurance::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('catagraphy')
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject()->associate($activity->subject->beneficiary);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSocioeconomicVulnerabilitiesAttribute(): Collection
    {
        return collect([
            $this->id_type,
            $this->age_category,
            $this->income,
            $this->poverty,
            $this->habitation,
            $this->family,
            $this->education,
            $this->domestic_violence,
        ])->flatten();
    }

    public function getHealthVulnerabilitiesAttribute(): Collection
    {
        return collect([
            // TODO
        ])->flatten();
    }

    public function getReproductiveHealthAttribute(): Collection
    {
        return collect([
            // TODO
        ])->flatten();
    }
}
