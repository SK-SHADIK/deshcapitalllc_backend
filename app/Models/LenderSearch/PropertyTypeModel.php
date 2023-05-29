<?php

namespace App\Models\LenderSearch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyTypeModel extends Model
{
    protected $table = "product_type";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';
}
