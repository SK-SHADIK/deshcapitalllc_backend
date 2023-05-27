<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amortization extends Model
{
    protected $table = "amortization";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
