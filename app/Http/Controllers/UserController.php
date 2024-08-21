<?php

namespace App\Http\Controllers;

use App\Mail\ActivationCode;
use App\Rules\PasswordPolicy;
use App\User;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    private $isApiRequest;

    public function __construct(Request $request)
    {
        $this->isApiRequest = ControllersService::isApiRoute($request);
    }

    public function index(Request $request)
    {
        $o = User::orderBy('id','DESC');

        if($request->name){
            $o->where('name', 'like' ,'%'.$request->name.'%');
        }
        if($request->email){
            $o->where('email', 'like' ,'%'.$request->email.'%');
        }
        if($request->mobile){
            $o->where('mobile', $request->mobile);
        }
        if($request->status > -1){
            $o->where('status', $request->status);
        }

        $out = $o->paginate(15);

            return view('system_admin.customers.index', compact('out'));
    }

    public function show(Request $request, $id)
    {
        $out = User::findOrFail($id);
        return view('system_admin.customers.profile', compact('out'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'mobile' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],

            "country_id" => "required|exists:countries,id|integer",


        ]);
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->mobile = $request->get('mobile');
        $user->email = $request->get('email');
        $user->country_id = $request->get("country_id");
        $isSaved = $user->save();
        flash('تم تحديث البيانات بنجاح');
        return redirect()->route('customer.profile');
    }


    public function update_image(Request $request)
    {
        $this->validate($request, ['uploaded_file' => 'image']);

        if ($name = MediaController::SaveFile($request->uploaded_file)) {

            $user = Auth::user();
            $user->avatar = $name;
            $user->save();
            return ['filelink' => url('uploads/' . $name), 'file_name' => $name, 'status' => 1];
        } else {
            return ['status' => 0, 'errors' => 'ERROR'];
        }
    }

    public function delete(Request $request)
    {
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $o = User::find($id);
                if($o->can_del){
                    $o->delete();
                }


            }
            return ['done' => 1];

        } else {
//            $this->validate($request, Order::$getRoles);
            $o = User::find($request->id);
            if($o->can_del){
                $o->delete();
            }
            return ['done' => 1];
        }
    }

    public function activate(Request $request)
    {
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $o = User::find($id);
                $o->status = 1;
                $o->save();

            }
            return ['done' => 1];

        } else {
//            $this->validate($request, Order::$getRoles);
            $o = User::find($request->id);
            $o->status = 1;

            $o->save();
            return ['done' => 1];
        }
    }

    public function deactivate(Request $request)
    {
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $o = User::find($id);
                $o->status = 2;

                $o->save();

            }
            return ['done' => 1];

        } else {
//            $this->validate($request, Order::$getRoles);
            $o = User::find($request->id);
            $o->status = 2;
            $o->save();
            return ['done' => 1];
        }
    }


    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);


        return view("website.profile", ['user' => $user]);

    }

    public function show_orders()
    {
        return view("website.orders_user");

    }

    public function logout()
    {
        Auth::guard('web')->logout();
//        $request->session()->invalidate();
        return redirect()->route('website.login');
    }












}
