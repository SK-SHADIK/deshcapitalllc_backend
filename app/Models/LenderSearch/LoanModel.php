<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanModel extends Model
{
    protected $table = "loan";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
