<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Vulnerability;
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
        'evaluation_date',
        'notes',
        'nurse_id',

        'cat_age',
        'cat_as',
        'cat_cr',
        'cat_diz',
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
        'cat_age' => Vulnerability\CatAge::class,
        'cat_as' => Vulnerability\CatAs::class,
        'cat_cr' => AsEnumCollection::class . ':' . Vulnerability\CatCr::class,
        'cat_diz' => Vulnerability\CatDiz::class,
        'cat_edu' => Vulnerability\CatEdu::class,
        'cat_fam' => AsEnumCollection::class . ':' . Vulnerability\CatFam::class,
        'cat_id' => Vulnerability\CatId::class,
        'cat_inc' => Vulnerability\CatInc::class,
        'cat_liv' => AsEnumCollection::class . ':' . Vulnerability\CatLiv::class,
        'cat_mf' => Vulnerability\CatMf::class,
        'cat_ns' => AsEnumCollection::class . ':' . Vulnerability\CatNs::class,
        'cat_pov' => Vulnerability\CatPov::class,
        'cat_preg' => Vulnerability\CatPreg::class,
        'cat_rep' => Vulnerability\CatRep::class,
        'cat_ss' => AsEnumCollection::class . ':' . Vulnerability\CatSs::class,
        'cat_ssa' => AsEnumCollection::class . ':' . Vulnerability\CatSsa::class,
        'cat_vif' => AsEnumCollection::class . ':' . Vulnerability\CatVif::class,
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
            $this->cat_age,
            $this->cat_inc,
            $this->cat_id,
            $this->cat_pov,
            $this->cat_liv,
            $this->cat_fam,
            $this->cat_edu,
            $this->cat_vif,
        ])->flatten();
    }

    public function getHealthVulnerabilitiesAttribute(): Collection
    {
        return collect([
            $this->cat_as,
            $this->cat_mf,
            $this->cat_diz,
            $this->cat_cr,
            $this->cat_ns,
            $this->cat_ssa,
        ])->flatten();
    }

    public function getReproductiveHealthAttribute(): Collection
    {
        return collect([
            $this->cat_rep,
            $this->cat_preg,
        ])->flatten();
    }
}
