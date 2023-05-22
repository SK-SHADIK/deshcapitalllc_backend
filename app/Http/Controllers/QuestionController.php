<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\QuestionModel;
use App\Http\Middleware\APIAuth;
use DB;

class QuestionController extends Controller
{
   // ----- Show All Question Function -----
   public function showQuestions()
   {
       $query = "SELECT * FROM question;";
       $questions = DB::select($query);
       return response()->json($questions);
   }

   // ----- Create Question Function -----
   public function createQuestion(Request $request)
   {
       $validator = Validator::make($request->all(),
            [
               "name"=>"required|regex:/^[a-zA-Z.]+$/",
               "question"=>"required"
            ],
            [
               "name.required" => "Please provide your name!!!",
               "name.regex" => "Numbers and Symbols are not accepted!!!",
               "question.required" => "Please provide your question!!!"
            ]
       );
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
       }
   
       $name = $request['name'];
       $question = $request['question'];
       $active = $request['is_active'];
   
       $query = "INSERT INTO question (name, question, is_active) VALUES (?, ?, ?)";
       DB::insert($query, [$name, $question, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"]);
   }

   // ----- Show Single Question Function -----
   public function showSingleQuestion($id)
   {
       $query = "SELECT * FROM question WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Question Function -----
   public function updateQuestion(Request $request)
   {
       
       $validator = Validator::make($request->all(),
            [
               "name"=>"required|regex:/^[a-zA-Z.]+$/",
               "question"=>"required"
            ],
            [
               "name.required" => "Please provide your name!!!",
               "name.regex" => "Numbers and Symbols are not accepted!!!",
               "question.required" => "Please provide your question!!!"
            ]
       );
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
       }
       $query = "UPDATE question SET name = :name, question = :question, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'question' => $request->question,
           'is_active' => $request->is_active,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"]);
   }

   // ----- Deactivate Question Function -----
   public function deactivateQuestion(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE question SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"]);
   
   }

   // ----- Activate Question Function -----
   public function activateQuestion(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE question SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"]);
   
   }

   // ----- Delete Single Question Function -----
   public function removeSingleQuestion(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM question WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"]);

   }
   
   // ----- Delete All Question Function -----
   public function removeAllQuestion()
   {
       $query = "DELETE FROM question";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"]);

   }
}
