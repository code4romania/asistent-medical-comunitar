<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Vulnerability\AgeCategory;
use App\Enums\Vulnerability\ChildrenHealthRisk;
use App\Enums\Vulnerability\Disability;
use App\Enums\Vulnerability\DomesticViolence;
use App\Enums\Vulnerability\Education;
use App\Enums\Vulnerability\Family;
use App\Enums\Vulnerability\FamilyDoctor;
use App\Enums\Vulnerability\Habitation;
use App\Enums\Vulnerability\HealthNeed;
use App\Enums\Vulnerability\IDType;
use App\Enums\Vulnerability\Income;
use App\Enums\Vulnerability\Poverty;
use App\Enums\Vulnerability\RiskBehavior;
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
        'evaluation_date',
        'family_doctor',
        'family',
        'habitation',
        'health_need',
        'id_type',
        'income',
        'notes',
        'nurse_id',
        'poverty',
        'risk_behavior',
        'social_health_insurance',
        'children_health_risk',
    ];

    protected $casts = [
        'age_category' => AgeCategory::class,
        'disability' => Disability::class,
        'domestic_violence' => AsEnumCollection::class . ':' . DomesticViolence::class,
        'education' => Education::class,
        'evaluation_date' => 'date',
        'family_doctor' => FamilyDoctor::class,
        'family' => AsEnumCollection::class . ':' . Family::class,
        'habitation' => AsEnumCollection::class . ':' . Habitation::class,
        'health_need' => AsEnumCollection::class . ':' . HealthNeed::class,
        'children_health_risk' => AsEnumCollection::class . ':' . ChildrenHealthRisk::class,
        'id_type' => IDType::class,
        'income' => Income::class,
        'poverty' => Poverty::class,
        'risk_behavior' => AsEnumCollection::class . ':' . RiskBehavior::class,
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
            $this->social_health_insurance,
            $this->family_doctor,
            $this->disability,
            $this->risk_behavior,
            $this->health_need,
            $this->children_health_risk,
        ])->flatten();
    }

    public function getReproductiveHealthAttribute(): Collection
    {
        return collect([
            // TODO
        ])->flatten();
    }
}
