<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeDoc extends Model
{
    protected $table = "income_doc";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
