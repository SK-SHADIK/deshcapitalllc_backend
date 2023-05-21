<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
        $active = $request['is_active'];
    
        $query = "INSERT INTO feedback (name, feedback, is_active) VALUES (?, ?, ?)";
        DB::insert($query, [$name, $feedback, $active]);
    
    
        return response()->json(["msg" => "Successfully Data Added"]);
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
            'is_active' => $request->is_active,
            'id' => $request->id
        ];
    
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Updated"]);
    }

    // ----- Deactivate Feedback Function -----
    public function deactivateFeedback(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE feedback SET is_active = 0 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deactivate"]);
    
    }

    // ----- Activate Feedback Function -----
    public function activateFeedback(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE feedback SET is_active = 1 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Activate"]);
    
    }

    // ----- Delete Single Feedback Function -----
    public function removeSingleFeedback(Request $request)
    {
        $id = $request->id;

        $query = "DELETE FROM feedback WHERE id = :id";
        $parameters = ['id' => $id];
    
        DB::delete($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deleted"]);

    }
    
    // ----- Delete All Feedback Function -----
    public function removeAllFeedback()
    {
        $query = "DELETE FROM feedback";
    
        DB::delete($query);

        return response()->json(["msg"=>"Successfully All Data Deleted"]);

    }

}
