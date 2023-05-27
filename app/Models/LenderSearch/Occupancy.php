<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupancy extends Model
{
    protected $table = "occupancy";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
