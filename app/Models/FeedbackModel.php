<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackModel extends Model
{
    protected $table = "feedback";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
