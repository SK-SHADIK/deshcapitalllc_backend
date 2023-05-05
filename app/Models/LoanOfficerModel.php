<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanOfficerModel extends Model
{
    protected $table = "loan_officer";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
