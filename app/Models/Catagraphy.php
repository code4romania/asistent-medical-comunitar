<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToBeneficiary;
use App\Contracts\HasVulnerabilityData;
use App\DataTransferObjects\VulnerabilityListItem;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Catagraphy extends Model
{
    use BelongsToBeneficiary;
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'evaluation_date',
        'notes',
        'nurse_id',

        'cat_age',
        'cat_as',
        'cat_cr',
        'has_disabilities',
        'cat_edu',
        'cat_fam',
        'cat_id',
        'cat_inc',
        'cat_liv',
        'cat_mf',
        'cat_ns',
        'cat_pov',
        'cat_preg',
        'cat_rep',
        'has_health_issues',
        'cat_ssa',
        'cat_vif',
        'is_social_case',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'cat_age' => 'string',
        'cat_as' => 'string',
        'cat_cr' => 'array',
        'cat_edu' => 'string',
        'cat_fam' => 'array',
        'cat_id' => 'string',
        'cat_inc' => 'string',
        'cat_liv' => 'array',
        'cat_mf' => 'string',
        'cat_ns' => 'array',
        'cat_pov' => 'string',
        'cat_preg' => 'array',
        'cat_rep' => 'string',
        'cat_ssa' => 'array',
        'cat_vif' => 'array',
        'has_disabilities' => 'boolean',
        'has_health_issues' => 'boolean',
        'is_social_case' => 'boolean',
    ];

    protected $with = [
        'disabilities',
        'diseases',
        'suspicions',
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
        $beneficiary = $activity->subject->beneficiary;

        $activity->properties = $activity->properties
            ->put('beneficiary_id', $beneficiary->id);

        once(
            fn () => activity('vulnerabilities')
                ->causedBy($activity->causer)
                ->performedOn($beneficiary)
                ->withProperties($this->all_valid_vulnerabilities->pluck('value'))
                ->event($eventName)
                ->log($eventName)
        );
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disabilities(): HasMany
    {
        return $this->hasMany(Disability::class);
    }

    public function diseases(): HasMany
    {
        return $this->hasMany(Disease::class);
    }

    public function suspicions(): HasMany
    {
        return $this->hasMany(Suspicion::class);
    }

    private function mapVulnerabilities(array $items): Collection
    {
        $vulnerabilities = Vulnerability::cachedList();

        return collect($items)
            ->flatten()
            ->map(fn ($item) => match (true) {
                $item instanceof HasVulnerabilityData => $item,
                default => $vulnerabilities->get($item),
            });
    }

    public function socioeconomicVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->mapVulnerabilities([
                $this->cat_soc,
                $this->cat_id,
                $this->cat_age,
                $this->cat_inc,
                $this->cat_pov,
                $this->cat_liv,
                $this->cat_fam,
                $this->cat_edu,
                $this->cat_vif,
            ])
        )->shouldCache();
    }

    public function healthVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->mapVulnerabilities([
                $this->cat_as,
                $this->cat_mf,
                $this->cat_diz,
                $this->cat_cr,
                $this->cat_ns,
                $this->cat_ssa,
                $this->cat_ss,
            ])
        )->shouldCache();
    }

    public function catDiz(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->has_disabilities) {
                true => $this->disabilities,
                false => 'VDH_99',
                default => null,
            }
        )->shouldCache();
    }

    public function catSoc(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->is_social_case) {
                true => 'VCS_01',
                false => 'VCS_99',
                default => null,
            },
        )->shouldCache();
    }

    public function catSs(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->has_health_issues) {
                true => $this->diseases,
                false => 'VSG_99',
                default => null,
            }
        )->shouldCache();
    }

    public function reproductiveHealth(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->mapVulnerabilities([
                $this->cat_rep,
                $this->cat_preg,
            ])
        )->shouldCache();
    }

    public function allVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->socioeconomic_vulnerabilities,
                $this->health_vulnerabilities,
                $this->reproductive_health,
                $this->suspicions,
            ])
                ->flatten()
                ->filter()
                ->values()
        )->shouldCache();
    }

    public function allVulnerabilitiesItems(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->all_vulnerabilities
                ->map(fn (HasVulnerabilityData $vulnerability) => $vulnerability->vulnerabilityListItem())
        )->shouldCache();
    }

    public function allValidVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->all_vulnerabilities_items
                ->filter(fn (VulnerabilityListItem $vulnerability) => $vulnerability->valid)
                ->values()
        )->shouldCache();
    }
}
