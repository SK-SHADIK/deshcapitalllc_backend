<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsModel extends Model
{
    protected $table = "clients";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
