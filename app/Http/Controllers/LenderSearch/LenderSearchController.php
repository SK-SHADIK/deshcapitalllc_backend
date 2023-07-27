<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\LenderSearchModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class LenderSearchController extends Controller
{
    // ----- Show All Lender Search Function -----
    public function showLenderSearch()
    {
        try {
            $query = "SELECT * FROM lender_search WHERE is_active = 1;";
            $lenderSearch = DB::select($query);

            if (empty($lenderSearch)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($lenderSearch);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Lender Search Function -----
    public function createLenderSearch(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required"
                ],
                [
                    "name.required" => "Please provide your name!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $name = $request['name'];
            $amortization = $request['amortization_id'];
            $challenges = $request['challenges_id'];
            $creditScore = $request['credit_score_id'];
            $immigStatus = $request['immig_status_id'];
            $incomeDoc = $request['income_doc_id'];
            $loan = $request['loan_id'];
            $occupancy = $request['occupancy_id'];
            $productType = $request['product_type_id'];
            $propertyType = $request['property_type_id'];
            $state = $request['state_id'];
            $ourClient = $request['our_client'];
            $active = $request->has('is_active') ? $request['is_active'] : true;


            $query = "INSERT INTO lender_search (name, amortization_id, challenges_id, credit_score_id, immig_status_id, income_doc_id, loan_id, occupancy_id, product_type_id, property_type_id, state_id, our_client, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($query, [$name, $amortization, $challenges, $creditScore, $immigStatus, $incomeDoc, $loan, $occupancy, $productType, $propertyType, $state, $ourClient, $active]);

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

    // ----- Show Single Lender Search Function -----
    public function showSingleLenderSearch($id)
    {
        try {
            $query = "SELECT * FROM lender_search WHERE id = :id";
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

    // ----- After Edit Store Lender Search Function -----
    public function updateLenderSearch(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required"
                ],
                [
                    "name.required" => "Please provide your name!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $lenderSearch = DB::table('lender_search')->where('id', $id)->first();

            if (!$lenderSearch) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE lender_search SET name = :name, amortization_id = :amortization_id, challenges_id = :challenges_id, credit_score_id = :credit_score_id, immig_status_id = :immig_status_id, income_doc_id = :income_doc_id, loan_id = :loan_id, occupancy_id = :occupancy_id, product_type_id = :product_type_id, property_type_id = :property_type_id, state_id = :state_id, our_client = :our_client, is_active = :is_active WHERE id = :id";
            $parameters = [
                'name' => $request->name,
                'amortization_id' => $request->amortization_id,
                'challenges_id' => $request->challenges_id,
                'credit_score_id' => $request->credit_score_id,
                'immig_status_id' => $request->immig_status_id,
                'income_doc_id' => $request->income_doc_id,
                'loan_id' => $request->loan_id,
                'occupancy_id' => $request->occupancy_id,
                'product_type_id' => $request->product_type_id,
                'property_type_id' => $request->property_type_id,
                'state_id' => $request->state_id,
                'our_client' => $request->our_client,
                'is_active' => $request->has('is_active') ? $request->is_active : true,
                'id' => $id
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

    // ----- Deactivate Lender Search Function -----
    public function deactivateLenderSearch(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE lender_search SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Lender Search Function -----
    public function activateLenderSearch(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE lender_search SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Lender Search Function -----
    public function removeSingleLenderSearch(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM lender_search WHERE id = :id";
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

    // ----- Delete All Lender Search Function -----
    public function removeAllLenderSearch()
    {
        try {
            $query = "DELETE FROM lender_search";

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

    // ----- Search Lender Search by Name Function -----
    public function searchLenderSearchByName(Request $request)
    {
        try {
            $name = $request->input('name');

            $query = "SELECT * FROM lender_search WHERE name LIKE :name";
            $parameters = ['name' => '%' . $name . '%'];

            $lenderSearch = DB::select($query, $parameters);

            if (empty($lenderSearch)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($lenderSearch);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    public function searchLender(Request $request)
    {
        try {
            $amortization_id = $request->input('amortization_id');
            $challenges_id = $request->input('challenges_id');
            $credit_score_id = $request->input('credit_score_id');
            $immig_status_id = $request->input('immig_status_id');
            $income_doc_id = $request->input('income_doc_id');
            $loan_id = $request->input('loan_id');
            $occupancy_id = $request->input('occupancy_id');
            $product_type_id = $request->input('product_type_id');
            $property_type_id = $request->input('property_type_id');
            $state_id = $request->input('state_id');

            $query = "SELECT * FROM lender_search WHERE 1=0";

            $parameters = [];

            if ($amortization_id) {
                $query .= " OR amortization_id = :amortization_id";
                $parameters['amortization_id'] = $amortization_id;
            }
            if ($challenges_id) {
                $query .= " OR challenges_id = :challenges_id";
                $parameters['challenges_id'] = $challenges_id;
            }
            if ($credit_score_id) {
                $query .= " OR credit_score_id = :credit_score_id";
                $parameters['credit_score_id'] = $credit_score_id;
            }
            if ($immig_status_id) {
                $query .= " OR immig_status_id = :immig_status_id";
                $parameters['immig_status_id'] = $immig_status_id;
            }
            if ($income_doc_id) {
                $query .= " OR income_doc_id = :income_doc_id";
                $parameters['income_doc_id'] = $amortization_id;
            }
            if ($loan_id) {
                $query .= " OR loan_id = :loan_id";
                $parameters['loan_id'] = $loan_id;
            }
            if ($occupancy_id) {
                $query .= " OR occupancy_id = :occupancy_id";
                $parameters['occupancy_id'] = $occupancy_id;
            }
            if ($product_type_id) {
                $query .= " OR product_type_id = :product_type_id";
                $parameters['product_type_id'] = $product_type_id;
            }
            if ($property_type_id) {
                $query .= " OR property_type_id = :property_type_id";
                $parameters['property_type_id'] = $property_type_id;
            }
            if ($state_id) {
                $query .= " OR state_id = :state_id";
                $parameters['state_id'] = $state_id;
            }

            $query .= " ORDER BY (our_client = 1) DESC;";

            $lenderSearch = DB::select($query, $parameters);

            if (empty($lenderSearch)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($lenderSearch);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }


}