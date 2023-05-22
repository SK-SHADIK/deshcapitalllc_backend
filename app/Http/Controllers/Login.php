<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datetime;
use DateInterval;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Token;
use App\Models\LoanOfficerModel;
use App\Models\ClientsModel;
use DB;

class Login extends Controller
{
    //
    function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email'=>"required",
            'password'=>"required",
        ],
        [
            "email.required" => "Please provide your email!!!",
            "password.required" => "Please provide your password!!!",
        ]);

        $email = $request['email'];

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user1 = DB::select("SELECT * FROM loan_officer WHERE email = '$email' LIMIT 1;");
        $user2 = DB::select("SELECT * FROM clients WHERE email = '$email' LIMIT 1;");

        $key = Str::random(40);
        $token = new Token();

        if($user1){
            $user1 = $user1[0];
            if(md5($request->password) == $user1->password){

                $token->token_key = $key;
                $token->email = $user1->email;
                $token->created_at = new Datetime();
                $token->expired_at = (new DateTime())->add(new DateInterval('P1D'));
                $token->save();
                return response()->json(["token"=>$key, "user"=>"Loan Officer"], 200);

            }else{
                return response()->json(["msg"=>"Invalid Username or Password!!!"], 422);
            }

        }else if($user2){
            $user2 = $user2[0];
            if(md5($request->password) == $user2->password){

                $token->token_key = $key;
                $token->email = $user2->email;
                $token->created_at = new Datetime();
                $token->expired_at = (new DateTime())->add(new DateInterval('P1D'));
                $token->save();
                return response()->json(["token"=>$key, "user"=>"Client"], 200);

            }else{
                return response()->json(["msg"=>"Invalid Username or Password!!!"], 422);
            }
        }else{
            return response()->json(["msg"=>"This Email Is Not Registered!!!"], 422);
        }

    }
    function loginUserInfo(Request $request, $token){
        $userData = Token::where('token_key', '=', $request->token)->whereNULL('expired_at')->first();
        if($userData){
            return response()->json([$userData]);
        }
        return response()->json([$userData]);
    }
}
