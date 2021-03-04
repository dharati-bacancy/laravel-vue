<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0,
                ];
            }

            $checkUser = User::where('email', $request->email)->first();

            if ($checkUser) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $string = 'ABCDEFGH12389IRSTUVWXYZ4567JKLMNOPQ';
                    $token = substr(str_shuffle($string), 0, 17);

                    $checkUser->remember_token = $token;
                    $checkUser->save();

                    $response = [
                        'msg' => 'Login Successful',
                        'status' => 1,
                        'user_id' => $checkUser->id,
                        'token' => $checkUser->remember_token,
                    ];
                } else {
                    $response = [
                        'msg' => 'Invalid Credentials',
                        'status' => 0,
                    ];
                }
            } else {
                $response = [
                    'msg' => 'No such user found in the system',
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0,
                ];
            }

            $user = User::find($request->user_id);
            $user->remember_token = "";
            $user->save();

            $response = [
                'msg' => "Logout Successful",
                'status' => 1,
            ];
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }

    public function checkToken(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'token' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'msg' => $validator->errors()->all(),
                    'status' => 0,
                ];
            }

            $user = User::find($request->user_id);

            if ($user->remember_token == $request->token) {
                $response = [
                    'msg' => "Access Granted",
                    'status' => 1,
                ];
            } else {
                $response = [
                    'msg' => "Un-Authorized access",
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }
}
