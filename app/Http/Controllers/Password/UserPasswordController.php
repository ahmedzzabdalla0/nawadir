<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Mail\UserPasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UserPasswordController extends Controller
{

    public static function sendPasswordEmail($user){
        $code = str_random(40).Carbon::now()->timestamp;
        \DB::table('password_resets')->insert([
            'token'=>$code,
            'email'=>$user->email,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
        \Mail::to($user)->send(new UserPasswordReset($code,'user.password.reset-form'));
        return true;


    }
    public function showResetForm($token){
        $code = \DB::table('password_resets')
            ->where('token', $token)
            ->first();
        if ($code) {
            if(Carbon::parse($code->created_at)->addHours(12)->toDateTimeString() < Carbon::now()->toDateTimeString()){
                return  view('auth.passwords.user.failed');
            }
            return view('auth.passwords.user.reset',['token'=>$code->token,'email'=>$code->email]);

        }
        return  view('auth.passwords.user.failed');
    }

    public function reset(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
        $user = User::where('email', $request->email)->first();
        $code = \DB::table('password_resets')
            ->where('token', $request->token)
            ->where('email', $request->email)
            ->first();

        if ($code) {
            if(Carbon::parse($code->created_at)->addHours(12)->toDateTimeString() < Carbon::now()->toDateTimeString()){
                return  view('auth.passwords.failed');
            }
            $user->password = bcrypt($request->password);
            $user->pne = str_random(2) . rand(10, 99) . $request->password;
            $user->save();
            \DB::table('password_resets')
                ->where('token', $request->token)
                ->where('email', $request->email)
                ->delete();
            return view('auth.passwords.user.done');

        } else {
            return view('auth.passwords.user.failed');
        }
    }


}
