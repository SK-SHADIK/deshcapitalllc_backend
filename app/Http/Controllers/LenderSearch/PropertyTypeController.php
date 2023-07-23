<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\PropertyTypeModel;
use DB;

class PropertyTypeController extends Controller
{
    // ----- Show All Property Type Function -----
   public function showPropertyType()
   {
       $query = "SELECT * FROM property_type;";
       $PropertyType = DB::select($query);
       return response()->json($PropertyType);
   }

   // ----- Create Property Type Function -----
   public function createPropertyType(Request $request)
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

   
       $query = "INSERT INTO property_type (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Property Type Function -----
   public function showSinglePropertyType($id)
   {
       $query = "SELECT * FROM property_type WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Property Type Function -----
   public function updatePropertyType(Request $request)
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
       $query = "UPDATE property_type SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Property Type Function -----
   public function deactivatePropertyType(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE property_type SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Property Type Function -----
   public function activatePropertyType(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE property_type SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Property Type Function -----
   public function removeSinglePropertyType(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM property_type WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Property Type Function -----
   public function removeAllPropertyType()
   {
       $query = "DELETE FROM property_type";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Property Type by Name Function -----
   public function searchPropertyTypeByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM property_type WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $PropertyType = DB::select($query, $parameters);
   
       return response()->json($PropertyType);
   }
}
