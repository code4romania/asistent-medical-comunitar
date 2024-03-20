<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Concerns\HasLocation;
use App\Enums\Employer\Funding;
use App\Enums\Employer\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    use HasLocation;

    protected $table = 'profile_employers';

    protected $fillable = [
        'name',
        'type',
        'funding',
        'project',
        'start_date',
        'end_date',
        'email',
        'phone',
        'has_gp_agreement',
        'gp_name',
        'gp_email',
        'gp_phone',
    ];

    protected $casts = [
        'type' => Type::class,
        'funding' => Funding::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'has_gp_agreement' => 'boolean',
    ];

    protected function getIsProjectBasedAttribute(): bool
    {
        return ! empty($this->project);
    }

    protected function getIsOngoingAttribute(): bool
    {
        return ! empty($this->end_date);
    }
}
