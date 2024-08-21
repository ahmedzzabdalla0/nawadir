<?php

namespace App\Http\Controllers;

use App\Helpers\UUID;
use App\Models\CaseGeneral;
use App\Models\Driver;
use App\Models\Gov;
use App\Models\GovDivision;
use App\Models\Order;
use App\Models\Variant;
use App\Rules\ValidMobile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use Validator;

class DriverController extends Controller
{

    public function index(Request $request)
    {
        $o = Driver::query()->orderBy('id','DESC');

        if($request->name){
            $o->where('name', 'like' ,'%'.$request->name.'%');
        }
        if($request->mobile){
            $o->where('mobile', $request->mobile);
        }
        if($request->email){
            $o->where('email', 'like' ,'%'.$request->email.'%');
        }
        if($request->has('status')  && $request->status != -1){
            $o->where('status', $request->status);
        }
        if($request->has('gov_division_id')  && $request->gov_division_id != -1){
            $o->where('gov_division_id', $request->gov_division_id);
        }
        $out = $o->paginate(20);
        $gov_divisions = GovDivision::all();
        $out->appends($request->all());
        return view('system_admin.drivers.index', compact(['out','gov_divisions']));
    }

    public function show(Request $request, $id)
    {
        $out = Driver::findOrFail($id);
        return view('system_admin.drivers.profile', compact('out'));
    }
    public function orders(Request $request, $id)
    {
        $driver = Driver::find($id);
        $o = Order::query()->where('driver_id',$id);
        if($request->name){
            $o->where('name','like','%'.$request->name.'%');;
        }
        if($request->price_from){
            $o->where('total_price','>=',$request->price_from);
        }
        if($request->price_to){
            $o->where('total_price','<=',$request->price_to);
        }
        if($request->date_from){
            $o->where('expected_delivery_time','>=',$request->date_from);
        }
        if($request->date_to){
            $o->where('expected_delivery_time','<=',$request->date_to);
        }
        if($request->status_id >-1){
            $o->where( 'case_id',$request->status_id);
        }
        if($request->driver_id >-1){
            $o->where( 'driver_id',$request->driver_id);
        }
        $out = $o->paginate(15);
        $statuses=CaseGeneral::all();
        $out->appends($request->all());
        return view('system_admin.drivers.orders', compact('out','driver','statuses'));
    }

    public function showCreateView(){
        $govs= Gov::all();
        return view('system_admin.drivers.create',compact('govs'));
    }

    public function create(Request $request){

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
        return redirect()->route('system.drivers.index');
    }

    public function showUpdateView($id){
        $out =Driver::find($id);
        $govs= Gov::all();
        return view('system_admin.drivers.update',compact('out','govs'));
    }

    public function update(Request $request,$id){

        $rules = [
            'name' => 'required|string',
            'mobile' => ['required','numeric',new ValidMobile()],
            'email' => ['nullable','email',Rule::unique('drivers')->whereNull('deleted_at')->whereNot('id',$id)],
            'car_type'=>'nullable|string',
            'car_number'=>'nullable|string',
            'image'=>'nullable|string',
            'license_image'=>'nullable|string',
            'identity_image'=>'nullable|string',
            'password'=>'nullable|min:6|confirmed',
            'gov_id'=>'required|integer'
        ];
        $this->validate($request,$rules);


        $driver = Driver::find($id);
        $driver->name = $request->name;
        $driver->mobile = $request->mobile;
        $driver->whats_mobile = $request->whats_mobile??null;
        $driver->email = $request->email??null;
        $driver->gov_id = $request->gov_id??null;
        $driver->car_type = $request->car_type??null;
        $driver->car_number = $request->car_number??null;
        $driver->save();
        if($request->has('license_image')){
            $driver->license = $request->license_image;
        }
        if($request->has('password')){
            $driver->password = \Hash::make($request->password);
            $driver->pne = str_random(2) . rand(10, 99) . $request->password;
        }
        if($request->has('image')){
            $driver->avatar = $request->image;
        }
        if($request->has('identity_image')){
            $driver->identity = $request->identity_image;
        }
        $driver->save();
        try{
        \HELPER::deleteUnUsedFile([$request->identity_image,$request->image,$request->license_image]);
    }catch (\Exception $exception){}
        flash('تم التعديل بنجاح');
        return redirect()->route('system.drivers.index');
    }

    public function delete(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }
        foreach ($ids as $id){
            $c=Driver::find($id);
            if($c->orders()->count()  ==  0){
                $c->delete();
            }
        }
        return ['done'=>1];

    }

    public function activate(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Driver::find($id);
            $o->status=1;
            $o->save();

        }
        return ['done' => 1];

    }

    public function deactivate(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Driver::find($id);
            $o->status=2;
            $o->save();
        }
        return ['done' => 1];

    }
}
