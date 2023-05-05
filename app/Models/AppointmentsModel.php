<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentsModel extends Model
{
    protected $table = "appointments";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
