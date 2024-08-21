<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Page;
use App\Rules\ValidMobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MailList;
use App\Models\Settings;
use Illuminate\Validation\Rule;
use App\Models\Driver;

class WebsiteController extends Controller
{

    public function gotoIndex()
    {
        return redirect()->route('website.home');
    }
    	public function add_driver(Request $request){
	         $rules = [
            'name' => 'required|string',
            'mobile' => ['required','numeric',new ValidMobile()],
            'email' => ['nullable','email',Rule::unique('drivers')->whereNull('deleted_at')],
            'password' => 'required|min:6|confirmed',
            'car_type'=>'nullable|string',
            'car_number'=>'nullable|string',
            'image'=>'required|string',
            'license_image'=>'required|string',
            'identity_image'=>'required|string',
            'gov_id'=>'required|integer'
        ];
        $this->validate($request,$rules);
 $driver = new Driver();
        $driver->name = $request->name;
        $driver->mobile = $request->mobile;
        $driver->whats_mobile = $request->whats_mobile??null;
        $driver->email = $request->email??null;
        $driver->gov_id = $request->gov_id??null;
        $driver->car_type = $request->car_type??null;
        $driver->car_number = $request->car_number??null;
        $driver->status = 1;
        $driver->avatar = $request->get('image');
        $driver->license = $request->get('license_image');
        $driver->identity = $request->get('identity_image');
        $driver->password = \Hash::make($request->password);
        $driver->pne = str_random(2) . rand(10, 99) . $request->password;
        $driver->lat = $request->lat??0;
        $driver->lng = $request->lng??0;
        $driver->activation_code = rand(1000, 9999);
        $last_login = Carbon::now()->toDateTimeString();
        $token = \Hash::make($last_login . $driver->id . 'BaseNew' . str_random(6));
        $driver->token = $token;
        $driver->last_login = Carbon::now();
        $driver->expiration_at = Carbon::now()->addMonths(6);
        $driver->save();
        $driver->refresh();
        try{
        \HELPER::deleteUnUsedFile([$request->get('image'),$request->get('license_image'),$request->get('identity_image')]);
        }catch (\Exception $exception){}
        $last_login = Carbon::now()->toDateTimeString();
        $token = \Hash::make($last_login . $driver->id . 'NewDriver' . str_random(6));
        $driver->token = $token;
        $driver->last_login = $last_login;
        $driver->save();
        $driver->refresh();
        flash('تمت الاضافة بنجاح');
        return redirect()->back();
	}
    public function index(Request $request)
    {


//     echo 'This home';
//     die();
        $page1 = Page::find(4);
        $page2 = Page::find(5);
        $page3 = Page::find(6);
        $android = Settings::where('name','android')->first()->value;
        $ios = Settings::where('name','ios')->first()->value;
        $instagram = Settings::where('name','instagram')->first()->value;
        $twitter = Settings::where('name','twitter')->first()->value;
        $facebook = Settings::where('name','facebook')->first()->value;
        $email = Settings::where('name','email')->first()->value;
        $whatsapp = Settings::where('name','whatsapp')->first()->value;
        return view("website.home",compact('page3','page2','page1','android','ios','instagram','twitter','facebook','email','whatsapp'));

    }
    public function error419(Request $request)
    {
        if(session()->has('is_logged')){
            session()->forget('is_logged');
        }
        if(session()->has('login_time')){
            session()->forget('login_time');
        }
        Auth::guard('system_admin')->logout();
       return view("website.error419");
    }



    public function register(Request $request)
    {
        return view("website.register",['register' => "activ"]);
    }


    public function contactUs(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'details' => 'required',
        ]);
        $new=new Contact();


        $new->email=$request->email;
        $new->details=$request->details;
        $new->save();
        flash('تم اضافة طلبك بنجاح');
        return redirect('/');
    }


    public function show_page($id)
    {
        $page=Page::findOrFail($id);
        return view('website.page',compact('page'));
    }
    
       public function privacy()
    {
        $page=Page::findOrFail(3);
        return view('content',compact('page'));
    }
     public function terms()
    {
        $page=Page::findOrFail(2);
        return view('content',compact('page'));
    }
    public function show_register(Request $request)
    {

        return view("website.register");
    }


    public function blocked()
    {
        flash('انت محظور','error');
        return redirect('/');

    }
    public function do_activate()
    {
        flash('الرجاء تفعيل حسابك','error');
        return view('website.active');

    }




}
