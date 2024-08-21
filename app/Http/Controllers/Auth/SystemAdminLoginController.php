<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SystemAdminLoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:system_admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('system_admin.system_admin_login');
    }

    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required', 'password' => 'required']);
        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];

        if (Auth::guard('system_admin')->attempt($credentials, false)) {
            switch (Auth::guard('system_admin')->user()->status) {
                case 1:
                    session(['is_logged'=>1]);
                    session(['login_time'=>Carbon::now()->toDateTimeString()]);
                    return redirect()->route('system_admin.dashboard');
                    break;

                case 2:
                    return redirect()->route('system_admin.activation');
                    break;

            }
        }else{
            
            flash(bcrypt("123456789"),'error');
        }

        return redirect()->back()->withErrors(['email'=>"اسم المستخدم او كلمة المرور خاطئة"])->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
       if(session()->has('is_logged')){
           session()->forget('is_logged');
       }
       if(session()->has('login_time')){
           session()->forget('login_time');
       }
        Auth::guard('system_admin')->logout();
//        $request->session()->invalidate();
        return redirect()->route('system_admin.login');
    }

}
