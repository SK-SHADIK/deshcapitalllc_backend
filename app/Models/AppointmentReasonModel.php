<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReasonModel extends Model
{
    protected $table = "appointment_reason";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
