<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "state";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
