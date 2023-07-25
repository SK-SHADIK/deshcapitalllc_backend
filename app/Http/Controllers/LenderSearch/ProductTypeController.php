<?php

namespace App\Http\Controllers\LenderSearch;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LenderSearch\ProductTypeModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class ProductTypeController extends Controller
{
    // ----- Show All Product Type Function -----
    public function showProductType()
    {
        try {
            $query = "SELECT * FROM product_type WHERE is_active = 1;";
            $productType = DB::select($query);

            if (empty($productType)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($productType);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Product Type Function -----
    public function createProductType(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/"
                ],
                [
                    "name.required" => "Please provide your name!!!",
                    "name.regex" => "Numbers and Symbols are not accepted!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $name = $request['name'];
            $active = $request->has('is_active') ? $request['is_active'] : true;


            $query = "INSERT INTO product_type (name, is_active) VALUES (?, ?)";
            DB::insert($query, [$name, $active]);

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

    // ----- Show Single Product Type Function -----
    public function showSingleProductType($id)
    {
        try {
            $query = "SELECT * FROM product_type WHERE id = :id";
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

    // ----- After Edit Store Product Type Function -----
    public function updateProductType(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/"
                ],
                [
                    "name.required" => "Please provide your name!!!",
                    "name.regex" => "Numbers and Symbols are not accepted!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $productType = DB::table('product_type')->where('id', $id)->first();

            if (!$productType) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE product_type SET name = :name, is_active = :is_active WHERE id = :id";
            $parameters = [
                'name' => $request->name,
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

    // ----- Deactivate Product Type Function -----
    public function deactivateProductType(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE product_type SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Product Type Function -----
    public function activateProductType(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE product_type SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Product Type Function -----
    public function removeSingleProductType(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM product_type WHERE id = :id";
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

    // ----- Delete All Product Type Function -----
    public function removeAllProductType()
    {
        try {
            $query = "DELETE FROM product_type";

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

    // ----- Search Product Type by Name Function -----
    public function searchProductTypeByName(Request $request)
    {
        try {
            $name = $request->input('name');

            $query = "SELECT * FROM product_type WHERE name LIKE :name";
            $parameters = ['name' => '%' . $name . '%'];

            $productType = DB::select($query, $parameters);

            if (empty($productType)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($productType);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}