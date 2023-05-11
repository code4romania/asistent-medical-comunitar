<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToBeneficiary;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'cat_diz',
        'cat_diz_tip',
        'cat_diz_gr',
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
        'cat_ss',
        'cat_ssa',
        'cat_vif',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'cat_age' => 'string',
        'cat_as' => 'string',
        'cat_cr' => 'array',
        'cat_diz' => 'string',
        'cat_diz_tip' => 'string',
        'cat_diz_gr' => 'string',
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
        'cat_ss' => 'array',
        'cat_ssa' => 'array',
        'cat_vif' => 'array',
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

    public function socioeconomicVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->cat_age,
                $this->cat_inc,
                $this->cat_id,
                $this->cat_pov,
                $this->cat_liv,
                $this->cat_fam,
                $this->cat_edu,
                $this->cat_vif,
            ])->flatten()
        )->shouldCache();
    }

    public function healthVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->cat_as,
                $this->cat_mf,
                $this->cat_diz_all,
                $this->cat_cr,
                $this->cat_ns,
                $this->cat_ssa,
            ])->flatten()
        )->shouldCache();
    }

    public function catDizAll(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->cat_diz,
                $this->cat_diz_tip,
                $this->cat_diz_gr,
            ])->flatten()
        )->shouldCache();
    }

    public function reproductiveHealth(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->cat_rep,
                $this->cat_preg,
            ])->flatten()
        )->shouldCache();
    }

    public function allVulnerabilities(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([
                $this->socioeconomic_vulnerabilities,
                $this->health_vulnerabilities,
                $this->reproductive_health,
            ])
                ->flatten()
                ->filter()
                ->values()
        )->shouldCache();
    }
}
