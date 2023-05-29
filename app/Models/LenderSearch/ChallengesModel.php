<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengesModel extends Model
{
    protected $table = "challenges";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
