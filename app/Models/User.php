<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasLocation;
use App\Concerns\MustSetInitialPassword;
use App\Concerns\Users\HasRole;
use App\Concerns\Users\HasStatus;
use App\Enums\Gender;
use App\Models\Profile\Area;
use App\Models\Profile\Course;
use App\Models\Profile\Employer;
use App\Models\Profile\Study;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements FilamentUser, HasName, HasMedia
{
    use CausesActivity;
    use HasApiTokens;
    use HasFactory;
    use HasLocation;
    use HasRole;
    use HasStatus;
    use InteractsWithMedia;
    use LogsActivity;
    use MustSetInitialPassword;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'cnp',
        'phone',
        'accreditation_number',
        'accreditation_date',
        'notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'gender' => Gender::class,
        'date_of_birth' => 'date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('accreditation_document')
            ->singleFile();
    }

    public function canAccessFilament(): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->full_name;
    }

    public function studies(): HasMany
    {
        return $this->hasMany(Study::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function employers(): HasMany
    {
        return $this->hasMany(Employer::class);
    }

    public function latestEmployer(): HasOne
    {
        return $this->hasOne(Employer::class)->latestOfMany();
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }

    public function activityCounties(): HasManyThrough
    {
        return $this->hasManyThrough(County::class, Area::class, 'user_id', 'id', 'id', 'county_id');
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class, 'nurse_id');
    }

    public function interventions(): HasManyThrough
    {
        return $this->hasManyThrough(Intervention::class, Beneficiary::class, 'nurse_id', 'beneficiary_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['email'])
            ->logOnlyDirty();
    }

    public function scopeActivatesInCounty(Builder $query, int $county_id): Builder
    {
        return $query->whereRelation('activityCounties', 'counties.id', $county_id);
    }
}
