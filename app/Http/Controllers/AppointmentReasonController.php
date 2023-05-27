<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AppointmentReasonModel;
use DB;

class AppointmentReasonController extends Controller
{
    // ----- Show All Appointment Reason Function -----
    public function showAppointmentReasons()
    {
        $query = "SELECT * FROM appointment_reason;";
        $appointmentReason = DB::select($query);
        return response()->json($appointmentReason);
    }

    // ----- Create Appointment Reason Function -----
    public function createAppointmentReason(Request $request)
    {
        $validator = Validator::make($request->all(),
             [
                "reason"=>"required"
             ],
             [
                "reason.required" => "Please provide reason!!!"
             ]
        );
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
    
        $reason = $request['reason'];
        $active = $request->has('is_active') ? $request['is_active'] : true;

    
        $query = "INSERT INTO appointment_reason (reason, is_active) VALUES (?, ?)";
        DB::insert($query, [$reason, $active]);
    
    
        return response()->json(["msg" => "Successfully Data Added"], 200);
    }

    // ----- Show Single Appointment Reason Function -----
    public function showSingleAppointmentReason($id)
    {
        $query = "SELECT * FROM appointment_reason WHERE id = :id";
        $data = DB::select($query, ['id' => $id]);
        return response()->json($data);
    }

    // ----- After Edit Store Appointment Reason Function -----
    public function updateAppointmentReason(Request $request)
    {
        
        $validator = Validator::make($request->all(),
             [
                "reason"=>"required"
             ],
             [
                "reason.required" => "Please provide reason!!!",
             ]
        );
        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        $query = "UPDATE appointment_reason SET reason = :reason, is_active = :is_active WHERE id = :id";
        $parameters = [
            'reason' => $request->reason,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
            'id' => $request->id
        ];
    
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Updated"], 200);
    }

    // ----- Deactivate Appointment Reason Function -----
    public function deactivateAppointmentReason(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE appointment_reason SET is_active = 0 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deactivate"], 200);
    
    }

    // ----- Activate Appointment Reason Function -----
    public function activateAppointmentReason(Request $request)
    {
        $id = $request->id;
        $query = "UPDATE appointment_reason SET is_active = 1 WHERE id = :id";
        $parameters = ['id' => $id];
        DB::update($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Activate"], 200);
    
    }

    // ----- Delete Single Appointment Reason Function -----
    public function removeSingleAppointmentReason(Request $request)
    {
        $id = $request->id;

        $query = "DELETE FROM appointment_reason WHERE id = :id";
        $parameters = ['id' => $id];
    
        DB::delete($query, $parameters);

        return response()->json(["msg"=>"Successfully Data Deleted"], 200);

    }
    
    // ----- Delete All Appointment Reason Function -----
    public function removeAllAppointmentReason()
    {
        $query = "DELETE FROM appointment_reason";
    
        DB::delete($query);

        return response()->json(["msg"=>"Successfully All Data Deleted"], 200);

    }

    // ----- Search Appointment Reason by Name Function -----
    public function searchAppointmentReasonByName(Request $request)
    {
        $reason = $request->input('reason');
    
        $query = "SELECT * FROM appointment_reason WHERE reason LIKE :reason";
        $parameters = ['reason' => '%' . $reason . '%'];
    
        $appointmentReason = DB::select($query, $parameters);
    
        return response()->json($appointmentReason);
    }
}
