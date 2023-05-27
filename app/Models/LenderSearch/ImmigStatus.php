<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImmigStatus extends Model
{
    protected $table = "immig_status";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
