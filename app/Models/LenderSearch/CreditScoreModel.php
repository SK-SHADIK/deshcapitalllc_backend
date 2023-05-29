<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditScoreModel extends Model
{
    protected $table = "credit_score";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
