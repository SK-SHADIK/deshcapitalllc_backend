<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\APIAuth;
use App\Models\ContactusModel;
use DB;

class ContactusController extends Controller
{
    // ----- Show All Contactus Function -----
   public function showContactuss()
   {
       $query = "SELECT * FROM contactus;";
       $contactus = DB::select($query);
       return response()->json($contactus);
   }

   // ----- Create Contactus Function -----
   public function createContactus(Request $request)
   {
       $validator = Validator::make($request->all(),
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
       if ($validator->fails())
       {
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
   
   
       return response()->json(["msg" => "Successfully Data Added"], 200);
   }

   // ----- Show Single Contactus Function -----
   public function showSingleContactus($id)
   {
       $query = "SELECT * FROM contactus WHERE id = :id";
       $data = DB::select($query, ['id' => $id]);
       return response()->json($data);
   }

   // ----- After Edit Store Contactus Function -----
   public function updateContactus(Request $request)
   {
       
       $validator = Validator::make($request->all(),
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
       if ($validator->fails())
       {
           return response()->json($validator->errors(), 422);
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

       return response()->json(["msg"=>"Successfully Data Updated"], 200);
   }

   // ----- Deactivate Contactus Function -----
   public function deactivateContactus(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE contactus SET is_active = 0 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
   
   }

   // ----- Activate Contactus Function -----
   public function activateContactus(Request $request)
   {
       $id = $request->id;
       $query = "UPDATE contactus SET is_active = 1 WHERE id = :id";
       $parameters = ['id' => $id];
       DB::update($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Activate"], 200);
   
   }

   // ----- Delete Single Contactus Function -----
   public function removeSingleContactus(Request $request)
   {
       $id = $request->id;

       $query = "DELETE FROM contactus WHERE id = :id";
       $parameters = ['id' => $id];
   
       DB::delete($query, $parameters);

       return response()->json(["msg"=>"Successfully Data Deleted"], 200);

   }
   
   // ----- Delete All Contactus Function -----
   public function removeAllContactus()
   {
       $query = "DELETE FROM contactus";
   
       DB::delete($query);

       return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

   }

   // ----- Search Contactus by Name Function -----
   public function searchContactusByName(Request $request)
{
    $searchTerm = $request->input('search');

    $query = "SELECT * FROM contactus WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search";
    $parameters = ['search' => '%' . $searchTerm . '%'];

    $contactus = DB::select($query, $parameters);

    return response()->json($contactus);
}

}
