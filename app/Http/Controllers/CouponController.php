<?php

namespace App\Http\Controllers;

use App\Events\SendUserNotification;
use App\Models\Coupon;
use App\Models\GlobalNotification;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\Rules\ValidUrl;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class CouponController extends Controller
{
    public function index(Request $request){
        $out=Coupon::query()->where('is_deleted',0)->orderBy('id','DESC');
        if($request->code){
            $code = $request->code;
            $out->where('code', 'like' ,'%'.$code.'%');
        }

        if($request->has('status') && $request->status != -1){
            $val = $request->status;
            if($val == 1){
                $out->where('is_valid' ,$val)
                    ->whereDate('end_date','>=',Carbon::now());;
            }else{
                $out->where('is_valid' ,$val)
                    ->orWhereDate('end_date','<',Carbon::now());
            }

        }
        if($request->valid_from){
            $out->whereDate('start_date','>=',$request->valid_from);
        }
        if($request->valid_to){
            $out->whereDate('end_date','<=',$request->valid_to);
        }
         $out=$out->paginate(15);
        return view('system_admin.coupons.index',compact('out'));
    }


    public function showCreateView(){
        return view('system_admin.coupons.create');
    }


    public function create(Request $request){

        $date = Carbon::now()->format('Y-m-d');

        $roles=[
            'coupon_code' => ['required','string','max:255',new ValidString(),'unique:coupons,code'],
            'discount'=>'required|integer|min:1|max:100',
            'valid_count' => ['required','integer','min:10'],
            'start_date' => 'required|date|after_or_equal:'.$date,
            'end_date' => 'required|date|after:start_date',
        ];
        if($request->has('send_user_notification')){
            $roles['title']= 'nullable|string';
            $roles['message']= 'nullable|string';
        }
        $this->validate($request, $roles);

        $out=new Coupon();
        $out->code = $request->coupon_code;
        $out->amount = $request->discount;
        $out->valid_count = $request->valid_count;
        $out->start_date = $request->start_date;
        $out->end_date = $request->end_date;
        $out->send_user_notification = $request->has('send_user_notification')?1:0;
        $out->is_valid = 1;
        $out->save();
        flash('تم اضافة الكوبون بنجاح');
        if($request->has('send_user_notification')){
            $code = $request->coupon_code;
            $users = User::where('status',1)->get();
            $notification = new GlobalNotification();
            $notification->title = $request->title;
            $notification->message = $request->message;
            $notification->system_admin_id = \Auth::guard('system_admin')->user()->id;
            $notification->save();
            $notification->fresh();
            foreach($users as $usr){
                event(new SendUserNotification($usr->id,  'AdminNotification',  ['global_notification'=>$notification->id],0));
            }
        }
        return redirect()->route('system.coupons.index');

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
            $c=Coupon::find($id);
            if($c->can_del){
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
            $o = Coupon::find($id);
            $o->is_valid=1;
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
            $o = Coupon::find($id);
            $o->is_valid=0;
            $o->save();
        }
        return ['done' => 1];
    }



}
