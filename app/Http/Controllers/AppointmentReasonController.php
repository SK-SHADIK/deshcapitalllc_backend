<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\APIAuth;
use App\Models\AppointmentReasonModel;
use DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class AppointmentReasonController extends Controller
{
    // ----- Show All Appointment Reason Function -----
    public function showAppointmentReasons()
    {
        try {
            $query = "SELECT * FROM appointment_reason WHERE is_active = 1;";
            $appointmentReason = DB::select($query);

            if (empty($appointmentReason)) {
                return response()->json(['error' => 'No Data Found!!!'], 404);
            }

            Log::info('Successfully Data Retrieved.');
            return response()->json($appointmentReason);

        } catch (QueryException $e) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

    // ----- Create Appointment Reason Function -----
    public function createAppointmentReason(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "reason" => "required"
                ],
                [
                    "reason.required" => "Please provide your reason!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $reason = $request['reason'];
            $active = $request->has('is_active') ? $request['is_active'] : true;


            $query = "INSERT INTO appointment_reason (reason, is_active) VALUES (?, ?)";
            DB::insert($query, [$reason, $active]);

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

    // ----- Show Single Appointment Reason Function -----
    public function showSingleAppointmentReason($id)
    {
        try {
            $query = "SELECT * FROM appointment_reason WHERE id = :id";
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

    // ----- After Edit Store Appointment Reason Function -----
    public function updateAppointmentReason(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "reason" => "required"
                ],
                [
                    "reason.required" => "Please provide your reason!!!"
                ]
            );
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $id = $request->id;
            $appointmentReason = DB::table('appointment_reason')->where('id', $id)->first();

            if (!$appointmentReason) {
                return response()->json(["error" => "Data Not Found!!!"], 404);
            }

            $query = "UPDATE appointment_reason SET reason = :reason, is_active = :is_active WHERE id = :id";
            $parameters = [
                'reason' => $request->reason,
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

    // ----- Deactivate Appointment Reason Function -----
    public function deactivateAppointmentReason(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE appointment_reason SET is_active = 0 WHERE id = :id";
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


    // ----- Activate Appointment Reason Function -----
    public function activateAppointmentReason(Request $request)
    {
        try {
            $id = $request->id;
            $query = "UPDATE appointment_reason SET is_active = 1 WHERE id = :id";
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

    // ----- Delete Single Appointment Reason Function -----
    public function removeSingleAppointmentReason(Request $request)
    {
        try {
            $id = $request->id;

            $query = "DELETE FROM appointment_reason WHERE id = :id";
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

    // ----- Delete All Appointment Reason Function -----
    public function removeAllAppointmentReason()
    {
        try {
            $query = "DELETE FROM appointment_reason";

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

    // ----- Search Appointment Reason by Name Function -----
    public function searchAppointmentReasonByName(Request $request)
    {
        try {
            $reason = $request->input('reason');

            $query = "SELECT * FROM appointment_reason WHERE reason LIKE :reason";
            $parameters = ['reason' => '%' . $reason . '%'];

            $appointmentReason = DB::select($query, $parameters);

            if (empty($appointmentReason)) {
                return response()->json(["error" => "No Data Found!!!"], 404);
            }

            Log::info('Successfully Data Retrieved.');

            return response()->json($appointmentReason);

        } catch (QueryException $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "Database Error Occurred!!! Please Try Again."], 500);
        } catch (Exception $ex) {
            Log::error(__FILE__ . ' || Line ' . __LINE__ . ' || ' . $ex->getMessage() . ' || ' . $ex->getCode());
            return response()->json(["error" => "An Unexpected Error Occurred!!! Please Try Again."], 500);
        }
    }

}