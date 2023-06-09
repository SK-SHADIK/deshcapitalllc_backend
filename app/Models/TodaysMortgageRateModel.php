<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodaysMortgageRateModel extends Model
{
    protected $table = "todays_mortgage_rate";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
