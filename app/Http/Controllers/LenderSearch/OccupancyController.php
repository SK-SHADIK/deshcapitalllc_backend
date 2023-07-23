<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\OccupancyModel;
use DB;

class OccupancyController extends Controller
{
    // ----- Show All Occupancy Function -----
   public function showOccupancy()
   {
       $query = "SELECT * FROM occupancy;";
       $Occupancy = DB::select($query);
       return response()->json($Occupancy);
   }

   // ----- Create Occupancy Function -----
   public function createOccupancy(Request $request)
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

   
       $query = "INSERT INTO occupancy (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Occupancy Function -----
   public function showSingleOccupancy($id)
   {
       $query = "SELECT * FROM occupancy WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Occupancy Function -----
   public function updateOccupancy(Request $request)
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
       $query = "UPDATE occupancy SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Occupancy Function -----
   public function deactivateOccupancy(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE occupancy SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Occupancy Function -----
   public function activateOccupancy(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE occupancy SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Occupancy Function -----
   public function removeSingleOccupancy(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM occupancy WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Occupancy Function -----
   public function removeAllOccupancy()
   {
       $query = "DELETE FROM occupancy";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Occupancy by Name Function -----
   public function searchOccupancyByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM occupancy WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $Occupancy = DB::select($query, $parameters);
   
       return response()->json($Occupancy);
   }
}
