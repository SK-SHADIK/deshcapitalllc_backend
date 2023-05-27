<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FeedbackModel;
use DB;

class FeedbackController extends Controller
{
    // ----- Show All Feedback Function -----
    public function showFeedbacks()
    {
        $query = "SELECT * FROM feedback;";
        $feedbacks = DB::select($query);
        return response()->json($feedbacks);
    }

    // ----- Create Feedback Function -----
    public function createFeedback(Request $request)
    {
        $validator = Validator::make($request->all(),
             [
                "name"=>"required|regex:/^[a-zA-Z.]+$/",
                "feedback"=>"required"
             ],
             [
                "name.required" => "Please provide your name!!!",
                "name.regex" => "Numbers and Symbols are not accepted!!!",
                "feedback.required" => "Please provide your feedback!!!"
             ]
        );
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
    
        $name = $request['name'];
        $feedback = $request['feedback'];
        $active = $request->has('is_active') ? $request['is_active'] : true;

    
        $query = "INSERT INTO feedback (name, feedback, is_active) VALUES (?, ?, ?)";
        DB::insert($query, [$name, $feedback, $active]);
    
    
        return response()->json(["msg" => "Successfully Data Added"], 200);
    }

    // ----- Show Single Feedback Function -----
    public function showSingleFeedback($id)
    {
        $query = "SELECT * FROM feedback WHERE id = :id";
        $data = DB::select($query, ['id' => $id]);
        return response()->json($data);
    }

    // ----- After Edit Store Feedback Function -----
    public function updateFeedback(Request $request)
    {
        
        $validator = Validator::make($request->all(),
             [
                "name"=>"required|regex:/^[a-zA-Z.]+$/",
                "feedback"=>"required"
             ],
             [
                "name.required" => "Please provide your name!!!",
                "name.regex" => "Numbers and Symbols are not accepted!!!",
                "feedback.required" => "Please provide your feedback!!!"
             ]
        );
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $query = "UPDATE feedback SET name = :name, feedback = :feedback, is_active = :is_active WHERE id = :id";
        $parameters = [
            'name' => $request->name,
            'feedback' => $request->feedback,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
            'id' => $request->id
        ];
    
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Updated"], 200);
    }

    // ----- Deactivate Feedback Function -----
    public function deactivateFeedback(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE feedback SET is_active = 0 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
    
    }

    // ----- Activate Feedback Function -----
    public function activateFeedback(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE feedback SET is_active = 1 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Activate"], 200);
    
    }

    // ----- Delete Single Feedback Function -----
    public function removeSingleFeedback(Request $request)
    {
        $id = $request->id;

        $query = "DELETE FROM feedback WHERE id = :id";
        $parameters = ['id' => $id];
    
        DB::delete($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deleted"], 200);

    }
    
    // ----- Delete All Feedback Function -----
    public function removeAllFeedback()
    {
        $query = "DELETE FROM feedback";
    
        DB::delete($query);

        return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

    }

    // ----- Search Feedback by Name Function -----
    public function searchFeedbackByName(Request $request)
    {
        $name = $request->input('name');
    
        $query = "SELECT * FROM feedback WHERE name LIKE :name";
        $parameters = ['name' => '%' . $name . '%'];
    
        $feedbacks = DB::select($query, $parameters);
    
        return response()->json($feedbacks);
    }
}
