<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Concerns\HasLocation;
use App\Enums\EmployerType;
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
        'project',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'type' => EmployerType::class,
        'start_date' => 'date',
        'end_date' => 'date',
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
