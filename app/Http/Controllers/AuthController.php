<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //

    public function sign_in(SignInRequest $request){
        $form_data = $request->all();
        
        if (!Auth::attempt($form_data)) {
            return $this->error('Credentials not match', 401);
        }
        // dd();
        return response(
            [
                'status' => "success",
                'token' => auth()->user()->createToken('API Token', [auth()->user()->role])->plainTextToken    
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

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }

        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Password reset successfully'
            ]);
        }

        return response([
            'message' => __($status)
        ], 500);
    }
}
