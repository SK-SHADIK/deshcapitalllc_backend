<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ClientsModel;
use DB;

class Registration extends Controller
{
    //
    public function Registrations(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "first_name" => "required|regex:/^[a-zA-Z.]+$/",
                "last_name" => "required|regex:/^[a-zA-Z.]+$/",
                "email" => "required|unique:clients,email|unique:loan_officer,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                "contact_number" => "required",
                "address" => "required",
                "password" => "required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                "confirm_password" => "required|same:password",
                "nmls" => "sometimes|required",
            ],
            [
                "first_name.required" => "Please provide your first name!!!",
                "first_name.regex" => "Numbers and Symbols are not accepted!!!",
                "last_name.required" => "Please provide your last name!!!",
                "last_name.regex" => "Numbers and Symbols are not accepted!!!",
                "email.required" => "Please provide your email!!!",
                "email.regex" => "Please provide a valid mail!!!",
                "email.unique" => "The email already exists!!!",
                "contact_number.required" => "Please provide your contact Number!!!",
                "address.required" => "Please provide your address!!!",
                "password.required" => "Please provide your password!!!",
                'password.min' => "Password must contain minimum 8 character",
                'password.regex' => "Also password must contain upper case, lower case, number and special characters",
                "confirm_password.required" => "Please provide your confirm password!!!",
                "confirm_password.same" => "The confirm password must match the password!",
                "nmls.required" => "Please provide your nmls!!!",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create Customized Client ID
        $lastClientId = DB::table('clients')->orderBy('client_id', 'desc')->first();

        if ($lastClientId) {
            $lastIdClient = substr($lastClientId->client_id, 4);
            $newClientId = 'DCLC' . str_pad($lastIdClient + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newClientId = 'DCLC00000';
        }

        // Create Customized Loan Officer ID
        $lastLoanOfficerId = DB::table('loan_officer')->orderBy('loan_officer_id', 'desc')->first();

        if ($lastLoanOfficerId) {
            $lastIdLoanOfficer = substr($lastLoanOfficerId->loan_officer_id, 5);
            $newLoanOfficerId = 'DCLLO' . str_pad($lastIdLoanOfficer + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newLoanOfficerId = 'DCLLO00000';
        }

        $client_id = $newClientId;
        $loan_officer_id = $newLoanOfficerId;
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $email = $request['email'];
        $contact_number = $request['contact_number'];
        $address = $request['address'];
        $password = md5($request['password']);
        $confirm_password = $request['confirm_password'];
        $nmls = $request['nmls'];
        $user_type = $request['user_type'];
        $active = $request['is_active'];

        if ($user_type == 'Client') {
            $query = "INSERT INTO clients (client_id, first_name, last_name, email, contact_number, address, password, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($query, [$client_id, $first_name, $last_name, $email, $contact_number, $address, $password, $active]);

            return response()->json(["msg" => "Client Created Successfully"], 200);
        } elseif ($user_type == 'Loan_officer') {
            $query = "INSERT INTO loan_officer (loan_officer_id, first_name, last_name, email, contact_number, address, password, nmls, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($query, [$loan_officer_id, $first_name, $last_name, $email, $contact_number, $address, $password, $nmls, $active]);

            return response()->json(["msg" => "Loan Officer Created Successfully"], 200);
        } else {
            return response()->json(["msg" => "Something Went Wrong!!! Please Try Again."], 422);
        }
    }

}