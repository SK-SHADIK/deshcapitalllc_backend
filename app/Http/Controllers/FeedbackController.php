<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FeedbackModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class FeedbackController extends Controller
{
    // ----- Show All Feedback Function -----
    public function showFeedbacks()
    {
        try {
            $query = "SELECT * FROM feedback WHERE is_active = 1;";
            $feedback = DB::select($query);

            if (empty($feedback)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($feedback);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Feedback Function -----
    public function createFeedback(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/",
                    "feedback" => "required"
                ],
                [
                    "name.required" => "Please provide your name!!!",
                    "name.regex" => "Numbers and Symbols are not accepted!!!",
                    "feedback.required" => "Please provide your feedback!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $name = $request['name'];
            $feedback = $request['feedback'];
            $active = $request->has('is_active') ? $request['is_active'] : true;


            $query = "INSERT INTO feedback (name, feedback, is_active) VALUES (?, ?, ?)";
            DB::insert($query, [$name, $feedback, $active]);

            Log::info('Successfully Data Added.');
            return response()->json(["msg" => "Successfully Data Added"], 200);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Show Single Feedback Function -----
    public function showSingleFeedback($id)
    {
        try {
            $query = "SELECT * FROM feedback WHERE id = :id";
            $data = DB::select($query, ['id' => $id]);

            if (empty($data)) {
                return response()->json(['error' => 'ID Not Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($data);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- After Edit Store Feedback Function -----
    public function updateFeedback(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/",
                    "feedback" => "required"
                ],
                [
                    "name.required" => "Please provide your name!!!",
                    "name.regex" => "Numbers and Symbols are not accepted!!!",
                    "feedback.required" => "Please provide your feedback!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $feedback = DB::table('feedback')->where('id', $id)->first();

            if (!$feedback) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE feedback SET name = :name, feedback = :feedback, is_active = :is_active WHERE id = :id";
            $parameters = [
                'name' => $request->name,
                'feedback' => $request->feedback,
                'is_active' => $request->has('is_active') ? $request->is_active : true,
                'id' => $request->id
            ];

            DB::update($query, $parameters);

            Log::info('Successfully Data Updated.');
            return response()->json(["msg" => "Successfully Data Updated"], 200);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Deactivate Feedback Function -----
    public function deactivateFeedback(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE feedback SET is_active = 0 WHERE id = :id";
            $parameters = ['id' => $id];
            $deactivateData = DB::update($query, $parameters);

            if ($deactivateData === 0) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            Log::info('Successfully Data Deactivated.');
            return response()->json(["msg" => "Successfully Data Deactivated"], 200);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }


    // ----- Activate Feedback Function -----
    public function activateFeedback(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE feedback SET is_active = 1 WHERE id = :id";
            $parameters = ['id' => $id];
            $activateData = DB::update($query, $parameters);

            if ($activateData === 0) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            Log::info('Successfully Data Activate.');
            return response()->json(["msg" => "Successfully Data Activate"], 200);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }

    }

    // ----- Delete Single Feedback Function -----
    public function removeSingleFeedback(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM feedback WHERE id = :id";
            $parameters = ['id' => $id];

            $deleteData = DB::delete($query, $parameters);

            if ($deleteData === 0) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            Log::info('Successfully Data Deleted.');
            return response()->json(["msg" => "Successfully Data Deleted"], 200);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }

    }

    // ----- Delete All Feedback Function -----
    public function removeAllFeedback()
    {
        try {
            $query = "DELETE FROM feedback";

            $deleteData = DB::delete($query);

            if ($deleteData === 0) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            Log::info('Successfully All Data Deleted.');
            return response()->json(["msg" => "Successfully All Data Deleted"], 200);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }

    }

    // ----- Search Feedback by Name Function -----
    public function searchFeedbackByName(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            $query = "SELECT * FROM feedback WHERE name LIKE :name OR feedback LIKE :feedback";
            $parameters = [
                'name' => '%' . $searchTerm . '%',
                'feedback' => '%' . $searchTerm . '%',
            ];

            $feedback = DB::select($query, $parameters);

            if (empty($feedback)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($feedback);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}
