<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BanglaFaqsModel;
use DB;

class BanglaFaqsController extends Controller
{
    // ----- Show All Bangla FAQs Function -----
   public function showBanglaFAQs()
   {
       $query = "SELECT * FROM bangla_faqs;";
       $questions = DB::select($query);
       return response()->json($questions);
   }

   // ----- Create Bangla FAQs Function -----
   public function createBanglaFAQs(Request $request)
   {
       $validator = Validator::make($request->all(),
            [
               "name"=>"required|regex:/^[a-zA-Z.]+$/",
               "question"=>"required",
               "answer"=>"required"
            ],
            [
               "name.required" => "Please provide your name!!!",
               "name.regex" => "Numbers and Symbols are not accepted!!!",
               "question.required" => "Please provide your question!!!",
               "answer.required" => "Please provide your answer!!!"
            ]
       );
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
       }
   
       $name = $request['name'];
       $question = $request['question'];
       $answer = $request['answer'];
       $active = $request->has('is_active') ? $request['is_active'] : true;

   
       $query = "INSERT INTO bangla_faqs (name, question, answer, is_active) VALUES (?, ?, ?, ?)";
       DB::insert($query, [$name, $question, $answer, $active]);
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Bangla FAQs Function -----
   public function showSingleBanglaFAQs($id)
   {
       $query = "SELECT * FROM bangla_faqs WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Bangla FAQs Function -----
   public function updateBanglaFAQs(Request $request)
   {
       
       $validator = Validator::make($request->all(),
            [
               "name"=>"required|regex:/^[a-zA-Z.]+$/",
               "question"=>"required",
               "answer"=>"required"
            ],
            [
               "name.required" => "Please provide your name!!!",
               "name.regex" => "Numbers and Symbols are not accepted!!!",
               "question.required" => "Please provide your question!!!",
               "answer.required" => "Please provide your question!!!"
            ]
       );
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
       }
       $query = "UPDATE bangla_faqs SET name = :name, question = :question, answer = :answer, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'question' => $request->question,
           'answer' => $request->answer,
           'is_active' => $request->has('is_active') ? $request->is_active : true,
           'id' => $request->id
       ];
   
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Bangla FAQs Function -----
   public function deactivateBanglaFAQs(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE bangla_faqs SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Bangla FAQs Function -----
   public function activateBanglaFAQs(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE bangla_faqs SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Bangla FAQs Function -----
   public function removeSingleBanglaFAQs(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM bangla_faqs WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Bangla FAQs Function -----
   public function removeAllBanglaFAQs()
   {
       $query = "DELETE FROM bangla_faqs";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Bangla FAQs by Name Function -----
   public function searchBanglaFAQsByName(Request $request)
   {
       $name = $request->input('name');
   
       $query = "SELECT * FROM bangla_faqs WHERE name LIKE :name";
       $parameters = ['name' => '%' . $name . '%'];
   
       $FAQs = DB::select($query, $parameters);
   
       return response()->json($FAQs);
   }
}
