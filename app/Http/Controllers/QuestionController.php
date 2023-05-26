<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\APIAuth;
use App\Models\QuestionModel;
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
       $active = $request->has('is_active') ? $request['is_active'] : true;

   
       $query = "INSERT INTO question (name, question, is_active) VALUES (?, ?, ?)";
       DB::insert($query, [$name, $question, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
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
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Question Function -----
   public function deactivateQuestion(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE question SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Question Function -----
   public function activateQuestion(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE question SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Question Function -----
   public function removeSingleQuestion(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM question WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Question Function -----
   public function removeAllQuestion()
   {
       $query = "DELETE FROM question";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Question by Name Function -----
   public function searchQuestionByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM question WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $questions = DB::select($query, $parameters);
   
       return response()->json($questions);
   }
}
