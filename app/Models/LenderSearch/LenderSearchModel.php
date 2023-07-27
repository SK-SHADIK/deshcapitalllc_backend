<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LenderSearchModel extends Model
{
    protected $table = "lender_search";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
