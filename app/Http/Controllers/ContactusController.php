<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactusModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class ContactusController extends Controller
{
    // ----- Show All Contactus Function -----
   public function showContactuss()
   {
       try {
           $query = "SELECT * FROM contactus WHERE is_active = 1;";
           $contactus = DB::select($query);

           if (empty($contactus)) {
               return response()->json(['error' => 'No Data Found!!!'], 404);
           }

           Log::info('Successfully Data Retrieved.');
           return response()->json($contactus);

       } catch (QueryException $e) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
       } catch (Exception $ex) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
       }
   }

   // ----- Create Contactus Function -----
   public function createContactus(Request $request)
   {
       try {
           $validator = Validator::make(
               $request->all(),
               [
                "name"=>"required|regex:/^[a-zA-Z.]+$/",
                "email"=>"required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                "phone"=>"required",
                "subject"=>"required",
                "message"=>"required"
             ],
             [
                "name.required" => "Please provide your name!!!",
                "name.regex" => "Numbers and Symbols are not accepted!!!",
                "email.required" => "Please provide your email!!!",
                "email.regex" => "Please provide a valid mail!!!",
                "phone.required" => "Please provide your phone!!!",
                "subject.required" => "Please provide your subject!!!",
                "message.required" => "Please provide your message!!!"
             ]
           );
           if ($validator->fails()) {
               return response()->json($validator->errors(), 422);
           }

           $name = $request['name'];
       $email = $request['email'];
       $phone = $request['phone'];
       $subject = $request['subject'];
       $message = $request['message'];
       $active = $request->has('is_active') ? $request['is_active'] : true;
   
       $query = "INSERT INTO contactus (name, email, phone, subject, message, is_active) VALUES (?, ?, ?, ?, ?, ?)";
       DB::insert($query, [$name, $email, $phone, $subject, $message, $active]);

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

   // ----- Show Single Contactus Function -----
   public function showSingleContactus($id)
   {
       try {
           $query = "SELECT * FROM contactus WHERE id = :id";
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

   // ----- After Edit Store Contactus Function -----
   public function updateContactus(Request $request)
   {
       try {
           $validator = Validator::make(
               $request->all(),
               [
                "name"=>"required|regex:/^[a-zA-Z.]+$/",
                "email"=>"required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                "phone"=>"required",
                "subject"=>"required",
                "message"=>"required"
            ],
            [
                "name.required" => "Please provide your name!!!",
                "name.regex" => "Numbers and Symbols are not accepted!!!",
                "email.required" => "Please provide your email!!!",
                "email.regex" => "Please provide a valid mail!!!",
                "phone.required" => "Please provide your phone!!!",
                "subject.required" => "Please provide your subject!!!",
                "message.required" => "Please provide your message!!!"
            ]
           );
           if ($validator->fails()) {
               return response()->json($validator->errors(), 422);
           }

           $id = $request->id;
           $contactus = DB::table('contactus')->where('id', $id)->first();

           if (!$contactus) {
               return response()->json(["error" => "Data Not Found!!!"], 404);
           }

           $query = "UPDATE contactus SET name = :name, email = :email, phone = :phone, subject = :subject, message = :message, is_active = :is_active WHERE id = :id";
       $parameters = [
           'name' => $request->name,
           'email' => $request->email,
           'phone' => $request->phone,
           'subject' => $request->subject,
           'message' => $request->message,
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

   // ----- Deactivate Contactus Function -----
   public function deactivateContactus(Request $request)
   {
       try {
           $id = $request->id;
           $query = "UPDATE contactus SET is_active = 0 WHERE id = :id";
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


   // ----- Activate Contactus Function -----
   public function activateContactus(Request $request)
   {
       try {
           $id = $request->id;
           $query = "UPDATE contactus SET is_active = 1 WHERE id = :id";
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

   // ----- Delete Single Contactus Function -----
   public function removeSingleContactus(Request $request)
   {
       try {
           $id = $request->id;

           $query = "DELETE FROM contactus WHERE id = :id";
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

   // ----- Delete All Contactus Function -----
   public function removeAllContactus()
   {
       try {
           $query = "DELETE FROM contactus";

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

   // ----- Search Contactus by Name Function -----
   public function searchContactusByName(Request $request)
   {
       try {
           $searchTerm = $request->input('search');

           $query = "SELECT * FROM contactus WHERE name LIKE :name OR email LIKE :email OR phone LIKE :phone OR subject LIKE :subject";
           $parameters = [
               'name' => '%' . $searchTerm . '%',
               'email' => '%' . $searchTerm . '%',
               'phone' => '%' . $searchTerm . '%',
               'subject' => '%' . $searchTerm . '%',
           ];

           $contactus = DB::select($query, $parameters);

           if (empty($contactus)) {
               return response()->json(["error" => "No Data Found!!!"], 404);
           }

           Log::info('Successfully Data Retrieved.');

           return response()->json($contactus);

       } catch (QueryException $ex) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
       } catch (Exception $ex) {
           Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
           return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
       }
   }

}
