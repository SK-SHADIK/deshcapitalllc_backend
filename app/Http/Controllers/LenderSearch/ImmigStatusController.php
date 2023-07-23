<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\ImmigStatusModel;
use DB;

class ImmigStatusController extends Controller
{
    // ----- Show All Immig Status Function -----
   public function showImmigStatus()
   {
       $query = "SELECT * FROM immig_status;";
       $immigStatus = DB::select($query);
       return response()->json($immigStatus);
   }

   // ----- Create Immig Status Function -----
   public function createImmigStatus(Request $request)
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

   
       $query = "INSERT INTO immig_status (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Immig Status Function -----
   public function showSingleImmigStatus($id)
   {
       $query = "SELECT * FROM immig_status WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Immig Status Function -----
   public function updateImmigStatus(Request $request)
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
       $query = "UPDATE immig_status SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Immig Status Function -----
   public function deactivateImmigStatus(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE immig_status SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Immig Status Function -----
   public function activateImmigStatus(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE immig_status SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Immig Status Function -----
   public function removeSingleImmigStatus(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM immig_status WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Immig Status Function -----
   public function removeAllImmigStatus()
   {
       $query = "DELETE FROM immig_status";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Immig Status by Name Function -----
   public function searchImmigStatusByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM immig_status WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $immigStatus = DB::select($query, $parameters);
   
       return response()->json($immigStatus);
   }
}
