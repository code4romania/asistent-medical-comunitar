<?php

namespace App\Models;

use App\Concerns\ProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory, ProfileModel;
    //TODO move this in trait
    protected $with=['city','county'];
}
