<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\ProductTypeModel;
use DB;

class ProductTypeController extends Controller
{
    // ----- Show All Product Type Function -----
   public function showProductType()
   {
       $query = "SELECT * FROM product_type;";
       $ProductType = DB::select($query);
       return response()->json($ProductType);
   }

   // ----- Create Product Type Function -----
   public function createProductType(Request $request)
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

   
       $query = "INSERT INTO product_type (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Product Type Function -----
   public function showSingleProductType($id)
   {
       $query = "SELECT * FROM product_type WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Product Type Function -----
   public function updateProductType(Request $request)
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
       $query = "UPDATE product_type SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Product Type Function -----
   public function deactivateProductType(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE product_type SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Product Type Function -----
   public function activateProductType(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE product_type SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Product Type Function -----
   public function removeSingleProductType(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM product_type WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Product Type Function -----
   public function removeAllProductType()
   {
       $query = "DELETE FROM product_type";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Product Type by Name Function -----
   public function searchProductTypeByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM product_type WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $ProductType = DB::select($query, $parameters);
   
       return response()->json($ProductType);
   }
}
