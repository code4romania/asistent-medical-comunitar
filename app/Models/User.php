<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasLocation;
use App\Enums\Gender;
use App\Models\Profile\Area;
use App\Models\Profile\Course;
use App\Models\Profile\Employer;
use App\Models\Profile\Study;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements FilamentUser, HasName
{
    use CausesActivity;
    use HasApiTokens;
    use HasFactory;
    use HasLocation;
    use LogsActivity;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        'gender' => Gender::class,
        'date_of_birth' => 'date',
    ];

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

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['email'])
            ->logOnlyDirty();
    }
}
