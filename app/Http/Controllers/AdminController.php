<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    // ----- Show All Admin Function -----
    public function showAdmins()
    {
        try {
            $query = "SELECT * FROM admin WHERE is_active = 1;";
            $admin = DB::select($query);

            if (empty($admin)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($admin);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Admin Function -----
    public function createAdmin(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "first_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "last_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "email" => "required|unique:admin,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                    "contact_number" => "required",
                    "address" => "required",
                    "password" => "required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/",
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
                    'password.regex' => "Also password must contain upper case, lower case, number and special characters"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create Customized Admin ID
            $lastadminId = DB::table('admin')->orderBy('admin_id', 'desc')->first();

            if ($lastadminId) {
                $lastIdadmin = substr($lastadminId->admin_id, 4);
                $newadminId = 'DCLA' . str_pad($lastIdadmin + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newadminId = 'DCLA00000';
            }


            $admin_id = $newadminId;
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $email = $request['email'];
            $contact_number = $request['contact_number'];
            $address = $request['address'];
            $password = md5($request['password']);
            $active = $request->has('is_active') ? $request['is_active'] : true;

            $query = "INSERT INTO admin (admin_id, first_name, last_name, email, contact_number, address, password, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($query, [$admin_id, $first_name, $last_name, $email, $contact_number, $address, $password, $active]);

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

    // ----- Show Single Admin Function -----
    public function showSingleAdmin($id)
    {
        try {
            $query = "SELECT * FROM admin WHERE id = :id";
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

    // ----- After Edit Store Admin Function -----
    public function updateAdmin(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "first_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "last_name" => "required|regex:/^[a-zA-Z.]+$/",
                    "email" => "required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
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
            $admin = DB::table('admin')->where('id', $id)->first();

            if (!$admin) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE admin SET admin_id = :admin_id, first_name = :first_name, last_name = :last_name, email = :email, contact_number = :contact_number, address = :address, password = :password, is_active = :is_active WHERE id = :id";
            $parameters = [
                'admin_id' => $request->admin_id,
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

    // ----- Deactivate Admin Function -----
    public function deactivateAdmin(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE admin SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Admin Function -----
    public function activateAdmin(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE admin SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Admin Function -----
    public function removeSingleAdmin(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM admin WHERE id = :id";
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

    // ----- Delete All Admin Function -----
    public function removeAllAdmin()
    {
        try {
            $query = "DELETE FROM admin";

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

    // ----- Search Admin by Name Function -----
    public function searchAdminByName(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            $query = "SELECT * FROM admin WHERE first_name LIKE :first_name OR last_name LIKE :last_name OR email LIKE :email OR contact_number LIKE :contact_number OR admin_id LIKE :admin_id";
            $parameters = [
                'first_name' => '%' . $searchTerm . '%',
                'last_name' => '%' . $searchTerm . '%',
                'email' => '%' . $searchTerm . '%',
                'contact_number' => '%' . $searchTerm . '%',
                'admin_id' => '%' . $searchTerm . '%',
            ];

            $admin = DB::select($query, $parameters);

            if (empty($admin)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($admin);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}