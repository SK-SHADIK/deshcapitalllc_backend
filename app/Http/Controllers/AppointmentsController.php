<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\APIAuth;
use App\Models\AppointmentsModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class AppointmentsController extends Controller
{
    // ----- Show All Appointments Function -----
    public function showAppointments()
    {
        try {
            $query = "SELECT * FROM appointments WHERE is_active = 1;";
            $appointment = DB::select($query);

            if (empty($appointment)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($appointment);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Appointments Function -----
    public function createAppointment(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/",
                    "email" => "required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                    "phone" => "required",
                    "date" => "required",
                    "time" => "required",
                    "appointment_reason_id" => "required",
                    "description" => "required",
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
            if ($validator->fails()) {
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

    // ----- Show Single Appointment Function -----
    public function showSingleAppointment($id)
    {
        try {
            $query = "SELECT * FROM appointments WHERE id = :id";
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

    // ----- After Edit Store Appointment Function -----
    public function updateAppointment(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "name" => "required|regex:/^[a-zA-Z.]+$/",
                    "email" => "required|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,3}$/",
                    "phone" => "required",
                    "date" => "required",
                    "time" => "required",
                    "appointment_reason_id" => "required",
                    "description" => "required",
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
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $appointment = DB::table('appointments')->where('id', $id)->first();

            if (!$appointment) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
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

    // ----- Deactivate Appointment Function -----
    public function deactivateAppointment(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE appointments SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Appointment Function -----
    public function activateAppointment(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE appointments SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Appointment Function -----
    public function removeSingleAppointment(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM appointments WHERE id = :id";
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

    // ----- Delete All Appointment Function -----
    public function removeAllAppointment()
    {
        try {
            $query = "DELETE FROM appointments";

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

    // ----- Search Appointment by Name Function -----
    public function searchAppointmentByName(Request $request)
    {
        try {

            $searchTerm = $request->input('search');

            $query = "SELECT * FROM appointments WHERE name LIKE :name OR email LIKE :email OR phone LIKE :phone OR date LIKE :date";
            $parameters = [
                'name' => '%' . $searchTerm . '%',
                'email' => '%' . $searchTerm . '%',
                'phone' => '%' . $searchTerm . '%',
                'date' => '%' . $searchTerm . '%',
            ];

            $appointment = DB::select($query, $parameters);

            if (empty($appointment)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($appointment);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}