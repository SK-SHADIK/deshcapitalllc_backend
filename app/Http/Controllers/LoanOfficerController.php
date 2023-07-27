<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LoanOfficerModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class LoanOfficerController extends Controller
{
     // ----- Show All Loan Officer Function -----
     public function showLoanOfficer()
     {
         try {
             $query = "SELECT * FROM loan_officer WHERE is_active = 1;";
             $loanOfficer = DB::select($query);
 
             if (empty($loanOfficer)) {
                 return response()->json(['error' => 'No Data Found!!!'], 404);
             }
 
             Log::info('Successfully Data Retrieved.');
             return response()->json($loanOfficer);
 
         } catch (QueryException $e) {
             Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
             return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
         } catch (Exception $ex) {
             Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
             return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
         }
     }
 
     // ----- Create Loan Officer Function -----
     public function createLoanOfficer(Request $request)
     {
         try {
             $validator = Validator::make(
                 $request->all(),
                 [
                     "first_name" => "required|regex:/^[a-zA-Z.]+$/",
                     "last_name" => "required|regex:/^[a-zA-Z.]+$/",
                     "email" => "required|unique:loan_officer,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                     "contact_number" => "required",
                     "address" => "required",
                     "password" => "required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/",
                     "nmls" => "required",
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
                     'nmls.required' => 'Please provide your nmls!!!',
                 ]
             );
             if ($validator->fails()) {
                 return response()->json($validator->errors(), 422);
             }
 
             // Create Customized Loan Officer ID
             $lastLoanOfficerId = DB::table('loan_officer')->orderBy('loan_officer_id', 'desc')->first();
 
             if ($lastLoanOfficerId) {
                 $lastIdLoanOfficer = substr($lastLoanOfficerId->loan_officer_id, 4);
                 $newLoanOfficerId = 'DCLO' . str_pad($lastIdLoanOfficer + 1, 5, '0', STR_PAD_LEFT);
             } else {
                 $newLoanOfficerId = 'DCLO00000';
             }
 
 
             $loan_officer_id = $newLoanOfficerId;
             $first_name = $request['first_name'];
             $last_name = $request['last_name'];
             $email = $request['email'];
             $contact_number = $request['contact_number'];
             $address = $request['address'];
             $nmls = $request['nmls'];
             $password = md5($request['password']);
             $active = $request->has('is_active') ? $request['is_active'] : true;
 
             $query = "INSERT INTO loan_officer (loan_officer_id, first_name, last_name, email, contact_number, address, nmls, password, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
             DB::insert($query, [$loan_officer_id, $first_name, $last_name, $email, $contact_number, $address, $nmls, $password, $active]);
 
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
 
     // ----- Show Single Loan Officer Function -----
     public function showSingleLoanOfficer($id)
     {
         try {
             $query = "SELECT * FROM loan_officer WHERE id = :id";
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
 
     // ----- After Edit Store Loan Officer Function -----
     public function updateLoanOfficer(Request $request)
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
                     "nmls" => "required",
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
                     'nmls.required' => 'Please provide your nmls!!!',
                 ]
             );
             if ($validator->fails()) {
                 return response()->json($validator->errors(), 422);
             }
 
             $id = $request->id;
             $loanOfficer = DB::table('loan_officer')->where('id', $id)->first();
 
             if (!$loanOfficer) {
                 return response()->json(["error" => "Data Not Found!!!"], 404);
             }
 
             $query = "UPDATE loan_officer SET loan_officer_id = :loan_officer_id, first_name = :first_name, last_name = :last_name, email = :email, contact_number = :contact_number, address = :address, nmls = :nmls, password = :password, is_active = :is_active WHERE id = :id";
             $parameters = [
                 'loan_officer_id' => $request->loan_officer_id,
                 'first_name' => $request->first_name,
                 'last_name' => $request->last_name,
                 'email' => $request->email,
                 'contact_number' => $request->contact_number,
                 'address' => $request->address,
                 'nmls' => $request->nmls,
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
 
     // ----- Deactivate Loan Officer Function -----
     public function deactivateLoanOfficer(Request $request)
     {
         try {
             $id = $request->id;
             $query = "UPDATE loan_officer SET is_active = 0 WHERE id = :id";
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
 
 
     // ----- Activate Loan Officer Function -----
     public function activateLoanOfficer(Request $request)
     {
         try {
             $id = $request->id;
             $query = "UPDATE loan_officer SET is_active = 1 WHERE id = :id";
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
 
     // ----- Delete Single Loan Officer Function -----
     public function removeSingleLoanOfficer(Request $request)
     {
         try {
             $id = $request->id;
 
             $query = "DELETE FROM loan_officer WHERE id = :id";
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
 
     // ----- Delete All Loan Officer Function -----
     public function removeAllLoanOfficer()
     {
         try {
             $query = "DELETE FROM loan_officer";
 
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
 
     // ----- Search Loan Officer by Name Function -----
     public function searchLoanOfficerByName(Request $request)
     {
         try {
             $searchTerm = $request->input('search');
 
             $query = "SELECT * FROM loan_officer WHERE first_name LIKE :first_name OR last_name LIKE :last_name OR email LIKE :email OR contact_number LIKE :contact_number OR loan_officer_id LIKE :loan_officer_id OR nmls LIKE nmls";
             $parameters = [
                 'first_name' => '%' . $searchTerm . '%',
                 'last_name' => '%' . $searchTerm . '%',
                 'email' => '%' . $searchTerm . '%',
                 'contact_number' => '%' . $searchTerm . '%',
                 'loan_officer_id' => '%' . $searchTerm . '%',
                 'nmls' => '%' . $searchTerm . '%',
             ];
 
             $loanOfficer = DB::select($query, $parameters);
 
             if (empty($loanOfficer)) {
                 return response()->json(["error" => "No Data Found!!!"], 404);
             }
 
             Log::info('Successfully Data Retrieved.');
 
             return response()->json($loanOfficer);
 
         } catch (QueryException $ex) {
             Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
             return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
         } catch (Exception $ex) {
             Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
             return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
         }
     }
 
 }