<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ClientsModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class ClientsController extends Controller
{
    // ----- Show All Client Function -----
    public function showClients()
    {
        try {
            $query = "SELECT * FROM clients WHERE is_active = 1;";
            $clients = DB::select($query);

            if (empty($clients)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($clients);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Client Function -----
    public function createClient(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "first_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "last_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "email" => "required|unique:clients,email|unique:loan_officer,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                    "contact_number" => "required",
                    "address" => "required",
                    "password" => "required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                ],
                [
                    "first_name.required" => "Please provide your first name!!!",
                    "first_name.regex" => "Numbers and Symbols are not accepted!!!",
                    "last_name.required" => "Please provide your last name!!!",
                    "last_name.regex" => "Numbers and Symbols are not accepted!!!",
                    "email.required" => "Please provide your email!!!",
                    "email.regex" => "Please provide a valid mail!!!",
                    "email.unique" => "The email already exists!!!",
                    "contact_number.required" => "Please provide your contact Number!!!",
                    "address.required" => "Please provide your address!!!",
                    "password.required" => "Please provide your password!!!",
                    'password.min' => "Password must contain minimum 8 character",
                    'password.regex' => "Also password must contain upper case, lower case, number and special characters (Not use the #)",
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create Customized Client ID
            $lastClientId = DB::table('clients')->orderBy('client_id', 'desc')->first();

            if ($lastClientId) {
                $lastIdClient = substr($lastClientId->client_id, 4);
                $newClientId = 'DLCC' . str_pad($lastIdClient + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newClientId = 'DLCC00000';
            }


            $client_id = $newClientId;
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $email = $request['email'];
            $contact_number = $request['contact_number'];
            $address = $request['address'];
            $password = md5($request['password']);
            $active = $request['is_active'];

            $query = "INSERT INTO clients (client_id, first_name, last_name, email, contact_number, address, password, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($query, [$client_id, $first_name, $last_name, $email, $contact_number, $address, $password, $active]);

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

    // ----- Show Single Client Function -----
    public function showSingleClient($id)
    {
        try {
            $query = "SELECT * FROM clients WHERE id = :id";
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

    // ----- After Edit Store Client Function -----
    public function updateClient(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "first_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "last_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "email" => "required|unique:clients,email|unique:loan_officer,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                    "contact_number" => "required",
                    "address" => "required",
                    "password" => "required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
                ],
                [
                    "first_name.required" => "Please provide your first name!!!",
                    "first_name.regex" => "Numbers and Symbols are not accepted!!!",
                    "last_name.required" => "Please provide your last name!!!",
                    "last_name.regex" => "Numbers and Symbols are not accepted!!!",
                    "email.required" => "Please provide your email!!!",
                    "email.regex" => "Please provide a valid mail!!!",
                    "email.unique" => "The email already exists!!!",
                    "contact_number.required" => "Please provide your contact Number!!!",
                    "address.required" => "Please provide your address!!!",
                    "password.required" => "Please provide your password!!!",
                    'password.min' => "Password must contain minimum 8 character",
                    'password.regex' => "Also password must contain upper case, lower case, number and special characters",
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $clients = DB::table('clients')->where('id', $id)->first();

            if (!$clients) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE clients SET client_id = :client_id, first_name = :first_name, last_name = :last_name, email = :email, contact_number = :contact_number, address = :address, password = :password, is_active = :is_active WHERE id = :id";
            $parameters = [
                'client_id' => $request->client_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'password' => $request->password,
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

    // ----- Deactivate Client Function -----
    public function deactivateClient(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE clients SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Client Function -----
    public function activateClient(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE clients SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Client Function -----
    public function removeSingleClient(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM clients WHERE id = :id";
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

    // ----- Delete All Client Function -----
    public function removeAllClient()
    {
        try {
            $query = "DELETE FROM clients";

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

    // ----- Search Client by Name Function -----
    public function searchClientByName(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            $query = "SELECT * FROM clients WHERE email LIKE :email OR contact_number LIKE :contact_number OR client_id LIKE :client_id";
            $parameters = [
                'email' => '%' . $searchTerm . '%',
                'contact_number' => '%' . $searchTerm . '%',
                'client_id' => '%' . $searchTerm . '%',
            ];

            $clients = DB::select($query, $parameters);

            if (empty($clients)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($clients);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}