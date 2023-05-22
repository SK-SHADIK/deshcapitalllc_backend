<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LoanOfficerModel;
use App\Models\ClientsModel;

class Token extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $with = ['loan_officer','clients'];

    function loan_officer(){
        return $this->belongsTo(LoanOfficerModel::class, 'email', 'email');
    }
    function clients(){
        return $this->belongsTo(ClientsModel::class, 'email', 'email');
    }
    // function employee(){
    //     return $this->belongsTo(employeeUser::class, 'user_email', 'e_mail');
    // }
    // function admin(){
    //     return $this->belongsTo(adminUser::class, 'user_email', 'a_mail');
    // }
}
