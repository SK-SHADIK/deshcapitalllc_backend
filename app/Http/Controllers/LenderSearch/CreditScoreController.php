<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\CreditScoreModel;
use DB;

class CreditScoreController extends Controller
{
    // ----- Show All Credit Score Function -----
   public function showCreditScore()
   {
       $query = "SELECT * FROM credit_score;";
       $creditScore = DB::select($query);
       return response()->json($creditScore);
   }

   // ----- Create Credit Score Function -----
   public function createCreditScore(Request $request)
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

   
       $query = "INSERT INTO credit_score (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Credit Score Function -----
   public function showSingleCreditScore($id)
   {
       $query = "SELECT * FROM credit_score WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Credit Score Function -----
   public function updateCreditScore(Request $request)
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
       $query = "UPDATE credit_score SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Credit Score Function -----
   public function deactivateCreditScore(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE credit_score SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Credit Score Function -----
   public function activateCreditScore(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE credit_score SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Credit Score Function -----
   public function removeSingleCreditScore(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM credit_score WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Credit Score Function -----
   public function removeAllCreditScore()
   {
       $query = "DELETE FROM credit_score";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Credit Score by Name Function -----
   public function searchCreditScoreByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM credit_score WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $creditScore = DB::select($query, $parameters);
   
       return response()->json($creditScore);
   }
}
