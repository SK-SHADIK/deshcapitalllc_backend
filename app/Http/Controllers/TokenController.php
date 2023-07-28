<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Token;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class TokenController extends Controller
{
   // ----- Show All Token Function -----
   public function showToken()
   {
       try {
           $query = "SELECT * FROM tokens;";
           $tokens = DB::select($query);

           if (empty($tokens)) {
               return response()->json(['error' => 'No Data Found!!!'], 404);
           }

           Log::info('Successfully Data Retrieved.');
           return response()->json($tokens);

       } catch (QueryException $e) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
       } catch (Exception $ex) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
       }
   }

   // ----- Show Single Token Function -----
   public function showSingleToken($id)
   {
       try {
           $query = "SELECT * FROM tokens WHERE id = :id";
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

   // ----- Delete Single Token Function -----
   public function removeSingleToken(Request $request)
   {
       try {
           $id = $request->id;

           $query = "DELETE FROM tokens WHERE id = :id";
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

   // ----- Delete All Token Function -----
   public function removeAllToken()
   {
       try {
           $query = "DELETE FROM tokens";

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

   // ----- Search Token by Name Function -----
   public function searchTokenByName(Request $request)
   {
       try {
           $searchTerm = $request->input('search');

           $query = "SELECT * FROM tokens WHERE token_key LIKE :token_key OR email LIKE :email";
           $parameters = [
               'token_key' => '%' . $searchTerm . '%',
               'email' => '%' . $searchTerm . '%',
           ];

           $tokens = DB::select($query, $parameters);

           if (empty($tokens)) {
               return response()->json(["error" => "No Data Found!!!"], 404);
           }

           Log::info('Successfully Data Retrieved.');

           return response()->json($tokens);

       } catch (QueryException $ex) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
       } catch (Exception $ex) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
       }
   }

}