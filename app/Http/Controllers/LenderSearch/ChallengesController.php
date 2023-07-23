<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\ChallengesModel;
use DB;


class ChallengesController extends Controller
{
     // ----- Show All Challenges Function -----
   public function showChallenges()
   {
       $query = "SELECT * FROM challenges;";
       $challenges = DB::select($query);
       return response()->json($challenges);
   }

   // ----- Create Challenges Function -----
   public function createChallenges(Request $request)
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

   
       $query = "INSERT INTO challenges (name, is_active) VALUES (?, ?)";
       DB::insert($query, [$name, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Challenges Function -----
   public function showSingleChallenges($id)
   {
       $query = "SELECT * FROM challenges WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Challenges Function -----
   public function updateChallenges(Request $request)
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
       $query = "UPDATE challenges SET name = :name, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Challenges Function -----
   public function deactivateChallenges(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE challenges SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Challenges Function -----
   public function activateChallenges(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE challenges SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Challenges Function -----
   public function removeSingleChallenges(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM challenges WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Challenges Function -----
   public function removeAllChallenges()
   {
       $query = "DELETE FROM challenges";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Challenges by Name Function -----
   public function searchChallengesByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM challenges WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $challenges = DB::select($query, $parameters);
   
       return response()->json($challenges);
   }
}
