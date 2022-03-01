<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //

    public function sign_in(SignInRequest $request){
        $form_data = $request->all();
        if (!Auth::attempt($form_data)) {
            return $this->error('Credentials not match', 401);
        }

        return response(
            [
                'status' => "success",
                'token' => auth()->user()->createToken('API Token')->plainTextToken    
            ],
            200
        );
    }

    public function sign_up(SignUpRequest $request){
        $form_data = $request->all();

        try{

            $user = User::create([
                'name' => $form_data['name'],
                'password' => bcrypt($form_data['password']),
                'email' => $form_data['email']
            ]);
    
            return response(
                [
                    'status' => "success",
                    'token' => $user->createToken('tokens')->plainTextToken    
                ],
                200
            );
        } catch(Exception $e){
            Log::error($e->getMessage());
            return response(
                [
                    'status' => "Error",
                    'message' => 'Something went wrong. Try Again later.'
                ],
                500
            );
        }
        
    }

    public function sendPasswordResetToken(Request $request){
        $request->validate(
            [
                "email" =>"required|email|exists:users,email"
            ]
        );

        $request->email;

        $user = User::where('email', $request->email)->first();
        try{
            $reset_link_sent = $user->sendPasswordResetLink();
            if($reset_link_sent){
                return response(
                    [
                        'status' => "success",
                        'token' => "A password reset token has been sent to your email"  
                    ],
                    200
                );
            }

        } catch(Exception $e){

            Log::error($e->getMessage());
            return response(
                [
                    'status' => "Error",
                    'message' => 'Something went wrong. Try Again later.'
                ],
                500
            );
        }

    }
}
