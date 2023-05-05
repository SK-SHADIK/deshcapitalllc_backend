<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactusModel extends Model
{
    protected $table = "contactus";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
