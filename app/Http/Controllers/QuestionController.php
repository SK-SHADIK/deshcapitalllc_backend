<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\QuestionModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class QuestionController extends Controller
{
    // ----- Show All Question Function -----
    public function showQuestions()
    {
        try {
            $query = "SELECT * FROM question WHERE is_active = 1;";
            $question = DB::select($query);

            if (empty($question)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($question);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Question Function -----
    public function createQuestion(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/",
                    "question" => "required"
                ],
                [
                    "name.required" => "Please provide your name!!!",
                    "name.regex" => "Numbers and Symbols are not accepted!!!",
                    "question.required" => "Please provide your question!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $name = $request['name'];
            $question = $request['question'];
            $active = $request->has('is_active') ? $request['is_active'] : true;


            $query = "INSERT INTO question (name, question, is_active) VALUES (?, ?, ?)";
            DB::insert($query, [$name, $question, $active]);

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

    // ----- Show Single Question Function -----
    public function showSingleQuestion($id)
    {
        try {
            $query = "SELECT * FROM question WHERE id = :id";
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

    // ----- After Edit Store Question Function -----
    public function updateQuestion(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/",
                    "question" => "required"
                ],
                [
                    "name.required" => "Please provide your name!!!",
                    "name.regex" => "Numbers and Symbols are not accepted!!!",
                    "question.required" => "Please provide your question!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $question = DB::table('question')->where('id', $id)->first();

            if (!$question) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE question SET name = :name, question = :question, is_active = :is_active WHERE id = :id";
            $parameters = [
                'name' => $request->name,
                'question' => $request->question,
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

    // ----- Deactivate Question Function -----
    public function deactivateQuestion(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE question SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Question Function -----
    public function activateQuestion(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE question SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Question Function -----
    public function removeSingleQuestion(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM question WHERE id = :id";
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

    // ----- Delete All Question Function -----
    public function removeAllQuestion()
    {
        try {
            $query = "DELETE FROM question";

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

    // ----- Search Question by Name Function -----
    public function searchQuestionByName(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            $query = "SELECT * FROM question WHERE name LIKE :name OR question LIKE :question";
            $parameters = [
                'name' => '%' . $searchTerm . '%',
                'question' => '%' . $searchTerm . '%',
            ];

            $question = DB::select($query, $parameters);

            if (empty($question)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($question);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}