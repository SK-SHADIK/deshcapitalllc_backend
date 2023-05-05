<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = "admin";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
