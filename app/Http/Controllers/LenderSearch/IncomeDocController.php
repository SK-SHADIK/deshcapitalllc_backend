<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\IncomeDocModel;
use DB;

class IncomeDocController extends Controller
{
     // ----- Show All Income Doc Function -----
   public function showIncomeDocs()
   {
       $query = "SELECT * FROM income_doc;";
       $IncomeDoc = DB::select($query);
       return response()->json($IncomeDoc);
   }

   // ----- Create Income Doc Function -----
   public function createIncomeDoc(Request $request)
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

   
       $query = "INSERT INTO income_doc (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Income Doc Function -----
   public function showSingleIncomeDoc($id)
   {
       $query = "SELECT * FROM income_doc WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Income Doc Function -----
   public function updateIncomeDoc(Request $request)
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
       $query = "UPDATE income_doc SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Income Doc Function -----
   public function deactivateIncomeDoc(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE income_doc SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Income Doc Function -----
   public function activateIncomeDoc(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE income_doc SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Income Doc Function -----
   public function removeSingleIncomeDoc(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM income_doc WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Income Doc Function -----
   public function removeAllIncomeDoc()
   {
       $query = "DELETE FROM income_doc";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Income Doc by Name Function -----
   public function searchIncomeDocByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM income_doc WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $IncomeDoc = DB::select($query, $parameters);
   
       return response()->json($IncomeDoc);
   }
}
