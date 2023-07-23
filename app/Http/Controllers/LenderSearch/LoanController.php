<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\LoanModel;
use DB;

class LoanController extends Controller
{
     // ----- Show All Loan Function -----
   public function showLoans()
   {
       $query = "SELECT * FROM loan;";
       $Loan = DB::select($query);
       return response()->json($Loan);
   }

   // ----- Create Loan Function -----
   public function createLoan(Request $request)
   {
       $validator = Validator::make($request->all(),
            [
               "name"=>"required|regex:/^[a-zA-Z.]+$/"
            ],
            [
               "name.required" => "Please provide your name!!!",
               "name.regex" => "Numbers and Symbols are not accepted!!!"
            ]
       );
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
       }
   
       $name = $request['name'];
       $active = $request->has('is_active') ? $request['is_active'] : true;

   
       $query = "INSERT INTO loan (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Loan Function -----
   public function showSingleLoan($id)
   {
       $query = "SELECT * FROM loan WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Loan Function -----
   public function updateLoan(Request $request)
   {
       
       $validator = Validator::make($request->all(),
            [
               "name"=>"required|regex:/^[a-zA-Z.]+$/"
            ],
            [
               "name.required" => "Please provide your name!!!",
               "name.regex" => "Numbers and Symbols are not accepted!!!"
            ]
       );
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
       }
       $query = "UPDATE loan SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Loan Function -----
   public function deactivateLoan(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE loan SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Loan Function -----
   public function activateLoan(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE loan SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Loan Function -----
   public function removeSingleLoan(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM loan WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Loan Function -----
   public function removeAllLoan()
   {
       $query = "DELETE FROM loan";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Loan by Name Function -----
   public function searchLoanByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM loan WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $Loan = DB::select($query, $parameters);
   
       return response()->json($Loan);
   }
}
