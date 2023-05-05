<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqsModel extends Model
{
    protected $table = "faqs";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
