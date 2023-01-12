<?php

namespace App\Models;

use App\Concerns\ProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileStudy extends Model
{
    use HasFactory, ProfileModel;

    protected $fillable =
        [
            'name',
            'type',
            'emitted_institution',
            'duration',
            'county_id',
            'city_id',
            'start_year',
            'end_year'
        ];
    //TODO move this in trait
    protected $with = ['city', 'county'];
}
