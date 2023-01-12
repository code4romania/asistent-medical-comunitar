<?php

namespace App\Models;

use App\Concerns\ProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileCourse extends Model
{
    use HasFactory, ProfileModel;



}
