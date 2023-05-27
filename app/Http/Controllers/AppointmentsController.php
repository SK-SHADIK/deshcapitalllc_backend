<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\APIAuth;
use App\Models\AppointmentsModel;
use DB;

class AppointmentsController extends Controller
{
    // ----- Show All Appointment Function -----
    public function showAppointments()
    {
        $query = "SELECT * FROM appointments;";
        $appointmentReason = DB::select($query);
        return response()->json($appointmentReason);
    }

    // ----- Create Appointment Function -----
    public function createAppointment(Request $request)
    {
        $validator = Validator::make($request->all(),
             [
                "name"=>"required|regex:/^[a-zA-Z.]+$/",
                "email"=>"required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                "phone"=>"required",
                "date"=>"required",
                "time"=>"required",
                "appointment_reason_id"=>"required",
                "description"=>"required",
             ],
             [
                "name.required" => "Please provide your name!!!",
                "name.regex" => "Numbers and Symbols are not accepted!!!",
                "email.required" => "Please provide your email!!!",
                "email.regex" => "Please provide a valid mail!!!",
                "phone.required" => "Please provide your phone number!!!",
                "date.required" => "Please provide a date!!!",
                "time.required" => "Please provide a time!!!",
                "appointment_reason_id.required" => "Please provide a reason!!!",
                "description.required" => "Please provide a reason!!!",
             ]
        );
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
    
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];
        $date = $request['date'];
        $time = $request['time'];
        $appointment_reason_id = $request['appointment_reason_id'];
        $description = $request['description'];
        $active = $request->has('is_active') ? $request['is_active'] : true;

    
        $query = "INSERT INTO appointments (name, email, phone, date, time, appointment_reason_id, description, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($query, [$name, $email, $phone, $date, $time, $appointment_reason_id, $description, $active]);
    
    
        return response()->json(["msg" => "Successfully Data Added"], 200);
    }

    // ----- Show Single Appointment Function -----
    public function showSingleAppointment($id)
    {
        $query = "SELECT * FROM appointments WHERE id = :id";
        $data = DB::select($query, ['id' => $id]);
        return response()->json($data);
    }

    // ----- After Edit Store Appointment Function -----
    public function updateAppointment(Request $request)
    {
        
        $validator = Validator::make($request->all(),
        [
            "name"=>"required|regex:/^[a-zA-Z.]+$/",
            "email"=>"required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
            "phone"=>"required",
            "date"=>"required",
            "time"=>"required",
            "appointment_reason_id"=>"required",
            "description"=>"required",
         ],
         [
            "name.required" => "Please provide your name!!!",
            "name.regex" => "Numbers and Symbols are not accepted!!!",
            "email.required" => "Please provide your email!!!",
            "email.regex" => "Please provide a valid mail!!!",
            "phone.required" => "Please provide your phone number!!!",
            "date.required" => "Please provide a date!!!",
            "time.required" => "Please provide a time!!!",
            "appointment_reason_id.required" => "Please provide a reason!!!",
            "description.required" => "Please provide a reason!!!",
         ]
        );
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $query = "UPDATE appointments SET name = :name, email = :email, phone = :phone, date = :date, time = :time, appointment_reason_id = :appointment_reason_id, description = :description, is_active = :is_active WHERE id = :id";
        $parameters = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date,
            'time' => $request->time,
            'appointment_reason_id' => $request->appointment_reason_id,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
            'id' => $request->id
        ];
    
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Updated"], 200);
    }

    // ----- Deactivate Appointment Function -----
    public function deactivateAppointment(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE appointments SET is_active = 0 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
    
    }

    // ----- Activate Appointment Function -----
    public function activateAppointment(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE appointments SET is_active = 1 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Activate"], 200);
    
    }

    // ----- Delete Single Appointment Function -----
    public function removeSingleAppointment(Request $request)
    {
        $id = $request->id;

        $query = "DELETE FROM appointments WHERE id = :id";
        $parameters = ['id' => $id];
    
        DB::delete($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deleted"], 200);

    }
    
    // ----- Delete All Appointment Function -----
    public function removeAllAppointment()
    {
        $query = "DELETE FROM appointments";
    
        DB::delete($query);

        return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

    }

    // ----- Search Appointment by Name Function -----
    public function searchAppointmentByName(Request $request)
    {
        $searchTerm = $request->input('search');

        $query = "SELECT * FROM contactus WHERE name LIKE :name OR email LIKE :email OR phone LIKE :phone";
        $parameters = [
            'name' => '%' . $searchTerm . '%',
            'email' => '%' . $searchTerm . '%',
            'phone' => '%' . $searchTerm . '%',
        ];
    
        $appointment = DB::select($query, $parameters);
    
        return response()->json($appointment);
    }
}
