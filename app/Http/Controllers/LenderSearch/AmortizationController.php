<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\AmortizationModel;
use DB;

class AmortizationController extends Controller
{
    // ----- Show All Amortization Function -----
   public function showAmortizations()
   {
       $query = "SELECT * FROM amortization;";
       $amortizations = DB::select($query);
       return response()->json($amortizations);
   }

   // ----- Create Amortization Function -----
   public function createAmortization(Request $request)
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

   
       $query = "INSERT INTO amortization (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Amortization Function -----
   public function showSingleAmortization($id)
   {
       $query = "SELECT * FROM amortization WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Amortization Function -----
   public function updateAmortization(Request $request)
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
       $query = "UPDATE amortization SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Amortization Function -----
   public function deactivateAmortization(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE amortization SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Amortization Function -----
   public function activateAmortization(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE amortization SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Amortization Function -----
   public function removeSingleAmortization(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM amortization WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Amortization Function -----
   public function removeAllAmortization()
   {
       $query = "DELETE FROM amortization";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Amortization by Name Function -----
   public function searchAmortizationByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM amortization WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $amortizations = DB::select($query, $parameters);
   
       return response()->json($amortizations);
   }
}
