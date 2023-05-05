<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    protected $table = "question";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
