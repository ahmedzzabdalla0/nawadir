<?php

namespace App\Http\Controllers;

use App\Events\SendAdminNotification;
use App\Events\SendUserNotification;
use App\Mail\OrderStatusChange;
use App\Models\CaseGeneral;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderCase;
use App\Models\ProductAmountLog;
use App\Models\Settings;
use App\Models\UserAddress;
use App\Models\UserBalance;
use App\SystemAdmin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function mainIndex(Request $request){
        $orders =Order::paid()->orderBy('id','DESC')->whereIn('case_id',[1,2,3,4])->count();

        $archived =Order::paid()->orderBy('id','DESC')->whereIn('case_id',[5])->count();
        $canceled = Order::paid()->orderBy('id','DESC')->whereIn('case_id',[6])->count();
        return view('system_admin.orders.main-index', compact('orders','archived','canceled'));
    }

    public function index(Request $request)
    {

//        $o = Order::paid()->orderBy('id','DESC');
        $o1=Order::paid()->orderBy('id','DESC')->where('case_id',1);
        $o2=Order::paid()->orderBy('id','DESC')->where('case_id',2);
        $o3=Order::paid()->orderBy('id','DESC')->where('case_id',3);
        $o4=Order::paid()->orderBy('id','DESC')->where('case_id',4);

//        if($request->case_id >-1){
//            $o->where( 'case_id',$request->case_id);
//        }
        if($request->name){
//            $o->where('name','like','%'.$request->name.'%');;
            $o1->where('name','like','%'.$request->name.'%');;
            $o2->where('name','like','%'.$request->name.'%');;
            $o3->where('name','like','%'.$request->name.'%');;
            $o4->where('name','like','%'.$request->name.'%');;
        }
        if($request->price_from){
//            $o->where('total_price','>=',$request->price_from);
            $o1->where('total_price','>=',$request->price_from);
            $o2->where('total_price','>=',$request->price_from);
            $o3->where('total_price','>=',$request->price_from);
            $o4->where('total_price','>=',$request->price_from);
        }
        if($request->price_to){
//            $o->where('total_price','<=',$request->price_to);
            $o1->where('total_price','<=',$request->price_to);
            $o2->where('total_price','<=',$request->price_to);
            $o3->where('total_price','<=',$request->price_to);
            $o4->where('total_price','<=',$request->price_to);
        }
        if($request->date_from){
//            $o->where('date','>=',$request->date_from);
            $o1->where('expected_delivery_time','>=',$request->date_from);
            $o2->where('expected_delivery_time','>=',$request->date_from);
            $o3->where('expected_delivery_time','>=',$request->date_from);
            $o4->where('expected_delivery_time','>=',$request->date_from);
        }
        if($request->date_to){
//            $o->where('date','<=',$request->date_to);
            $o1->where('expected_delivery_time','<=',$request->date_to);
            $o2->where('expected_delivery_time','<=',$request->date_to);
            $o3->where('expected_delivery_time','<=',$request->date_to);
            $o4->where('expected_delivery_time','<=',$request->date_to);
        }


//        $out = $o->paginate(15);
        $out1 = $o1->get();
        $out2 = $o2->get();
        $out3 = $o3->get();
        $out4 = $o4->get();
        $cases=CaseGeneral::all();
        return view('system_admin.orders.index', compact('out1','out2','out3','out4','cases'));

    }

    public function archive(Request $request)
    {

        $o=Order::orderBy('id','DESC')->whereIn( 'case_id',[5]);

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
        $statuses=CaseGeneral::whereIn('id',[5])->get();
        $drivers = Driver::all();
        $out->appends($request->all());
        return view('system_admin.orders.archive', compact('out','statuses','drivers'));

    }
    public function canceled(Request $request)
    {

        $o=Order::query()->orderBy('id','DESC')->whereIn('case_id',[6]);

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



        $out = $o->paginate(15);
        $out->appends($request->all());

        return view('system_admin.orders.canceled', compact('out'));

    }
    public function indexO(Request $request)
    {

        $o=Order::orderBy('id','DESC');

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
            $o->where('date','>=',$request->date_from);
        }
        if($request->date_to){
            $o->where('date','<=',$request->date_to);
        }

        if($request->case_id > 0){
            $o->where( 'case_id',$request->case_id);
        }

        $out = $o->paginate(15);
        $cases=CaseGeneral::all();
        return view('system_admin.orders.indexo', compact('out','cases'));

    }

    public function new_row(Request $request)
    {
        $a = Order::find($request->id);

            $view = \View::make('system_admin.orders.order_row', compact('a'));
            $output=$view->render();
            return ['out' => $output, 'done' => 1] ;

    }
    public function new_row_2(Request $request)
    {
        $a = Order::find($request->id);

            $view = \View::make('system_admin.orders.order_row_2', compact('a'));
            $output=$view->render();
            return ['out' => $output, 'done' => 1] ;

    }
    public function details($id)
    {
        $drivers = Driver::query()->where('status',1)->get();
        $cancel_type = Settings::where('name','cancel_type')->first()->value;
        $out=Order::findOrFail($id);
     return view('system_admin.orders.details',compact('out','cancel_type','drivers'));


    }


    public function change_order_status_to_one(Request $request)
    {
        $order=Order::find($request->id);
        if($order->case_id ==1 &&$order->payment_type==4){
            $oc=new OrderCase();
            $oc->case_id=2;
            $oc->order_id=$order->id;
            $oc->text_ar='تم تأكيد الطلب';
            $oc->text_en='Order was confirmed ';
            $oc->save();
            $order->case_id =2;
            $order->is_paid = 1;
            $order->save();

            event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
            event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم تحويل حالة الطلب رقم '.$order->id]));

            return ['done'=>true];
        }elseif($order->case_id ==1 && $order->is_paid){
            $oc=new OrderCase();
            $oc->case_id=2;
            $oc->order_id=$order->id;

            $oc->text_ar='تم تأكيد الطلب';
            $oc->text_en='Order was confirmed ';
            $oc->save();
            $order->case_id = 2;
          //  $order->is_paid = 1;
            //$order->payment_type = 1;
            $order->save();
            event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
            event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم تحويل حالة الطلب رقم '.$order->id]));
            return ['done'=>true];
        }elseif($order->case_id ==1 && !$order->is_paid){
            $oc=new OrderCase();
            $oc->case_id=2;
            $oc->order_id=$order->id;
            $oc->text_ar='تم تأكيد الطلب';
            $oc->text_en='Order was confirmed';
            $oc->save();
            $order->case_id =2;
            $order->is_paid = 1;
            $order->save();

            event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
            event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم تحويل حالة الطلب رقم '.$order->id]));
            return ['done'=>true];
        }

        return ['done'=>false];

    }
    public function change_order_status_to_prepared(Request $request){
        $order=Order::find($request->id);
        if($order->case_id == 2) {
            $address = $order->address;
            $area = $address->area;
            $gov_division = $area->gov_division;
            $expected_delivery_time = $order->expected_delivery_time;
//            $driver = $this->getAvailableDriver($expected_delivery_time,$gov_division->id);
            $driver=$request->driver_id;
            if($driver > 0){
                $oc=new OrderCase();
                $oc->case_id=3;
                $oc->order_id=$order->id;
                $oc->text_ar='تم بدء الذبح و تعيين مندوب التوصيل';
                $oc->text_en='Order is being prepared and delivery is assigned';
                $oc->save();
                $order->driver_id = $driver;
                $order->case_id = 3;
                $order->save();

                event(new SendUserNotification($driver,  'NewDriverOrder',  ['order_id'=>$order->id],1,'driver'));
                event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
                event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id' => $order->id,"order_status"=>$order->case_id,'text'=>'تم تحويل حالة الطلب رقم '.$order->id]));

                return ['done'=>true];
            }else{
                return ['done'=>false,'msg'=>'الرجاء اضافة مندوب توصيل جديد لعدم توفر مندوبين متفرغين'];
            }

        }

        return ['done'=>false];
    }
        function getAvailableDriver($expected_delivery_time,$gov_division_id){
           $not_valid_drivers = [];
           $driver = 0;
            $driver_daily_orders = Settings::where('name','driver_daily_orders')->first()->value;
            $driver_daily_orders = 1*$driver_daily_orders;
            while ($driver == 0){
               $test_driver = Driver::query()->where('gov_division_id',$gov_division_id)->where('status',1)->whereNotIn('id',$not_valid_drivers)->orderBy('id','asc')->first();
               if($test_driver){
                   $orders = Order::where('case_id','<>',6)->where('expected_delivery_time',$expected_delivery_time)->count();
                   if ($orders < $driver_daily_orders){
                       $driver = $test_driver->id;
                   }else{
                       $not_valid_drivers[]=$test_driver->id;
                   }
               }
           }
           return $driver;
        }
    public function change_order_status_to_tow(Request $request)
    {

        $order=Order::find($request->id);
        if($order->case_id ==3){
            $oc=new OrderCase();
            $oc->case_id=4;
            $oc->order_id=$order->id;
            $oc->text_ar='تم بدء توصيل الطلب';
            $oc->text_en='Order delivery is started';
            $oc->save();
            $order->case_id = 4;
            $order->save();
            if($order->driver_id > 0){
                event(new SendUserNotification($order->driver_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1,'driver'));

            }
            event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
            event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم تحويل حالة الطلب رقم '.$order->id]));


            return ['done'=>true];
        }


        return ['done'=>false];


    }
    public function change_order_status_to_three(Request $request)
    {


        $order=Order::find($request->id);
        if($order->case_id ==4 ){

            $oc=new OrderCase();
            $oc->case_id=5;
            $oc->order_id=$order->id;
            $oc->text_ar='تم تسليم الطلب';
            $oc->text_en='Order was delivered';
            $oc->save();
            $order->case_id = 5;
            $order->save();
            if($order->driver_id > 0){
                event(new SendUserNotification($order->driver_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1,'driver'));

            }
            event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
            event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم تحويل حالة الطلب رقم '.$order->id]));

            return ['done'=>true];
        }


        return ['done'=>false];


    }

    public function change_order_status_to_can(Request $request)
    {
        $order=Order::find($request->id);
        if($order->case_id < 5){
            $oc=new OrderCase();
            $oc->case_id=6;
            $oc->order_id=$order->id;
            $oc->text_ar='تم الغاء الطلب';
            $oc->text_en='Order was canceled';
            $oc->save();
            $order->case_id = 6;
            $order->save();
            if($order->driver_id > 0){
                event(new SendUserNotification($order->driver_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1,'driver'));

            }
            event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],1));
            event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم الغاء الطلب رقم '.$order->id]));

            if($order->is_paid == 1) {
                $tran = $order->transaction;
                $tran->status = 2;
                $tran->save();
                // return balance to user

                $user_balance = new UserBalance();
                $user_balance->user_id = $order->user_id;
                $user_balance->order_id = $order->id;
                $user_balance->amount = $order->total_price;
                $user_balance->type = 3;
                $user_balance->transaction_id = $order->transaction_id;
                $user_balance->save();
                $user=User::find($user_balance->user_id);
                event(new SendUserNotification($order->user_id,  'AddToBalance',  ['new_balance'=>$user->balance,'amount'=>$user_balance->amount],1));

            }
//            if($order->is_amount_returned == 0){
//                foreach ($order->products as $product){
//                    $product_variant_amount = new ProductAmountLog();
//                    $product_variant_amount->product_id = $product->productVariant->product_id;
//                    $product_variant_amount->product_variant_id = $product->productVariant->id;
//                    $product_variant_amount->amount = $product->qty	;
//                    $product_variant_amount->price = $product->item_price;
//                    $product_variant_amount->order_id=$order->id;
//                    $product_variant_amount->type='AddToStock';
//                    $product_variant_amount->note="ارجاع كمية طلب ملغي";
//                    $product_variant_amount->is_approved = 1;
//                    $product_variant_amount->save();
//                }
//                $order->is_amount_returned = 1;
//                $order->save();
//                $order->refresh();
//            }
            try {
                $user = User::find($order->user_id);
                \Mail::to($user)->send(new OrderStatusChange(' تم الغاء الطلب رقم '.$order->order_number,' تم الغاء الطلب رقم '.$order->order_number,$order->refresh()));
            } catch (\Exception $e) {

            }

            return ['done'=>true];

        }

        return ['done'=>false];
    }
    public function delete(Request $request)
    {
        $order=Order::find($request->id);
        if($order->case_id <= 2){
            if($order->driver_id > 0){
                event(new SendUserNotification($order->driver_id,  'DeleteOrder',  ['order_id'=>$order->id],1,'driver'));

            }
            event(new SendUserNotification($order->user_id,  'DeleteOrder',  ['order_id'=>$order->id],1));
            event(new SendAdminNotification('alqasim_orders', 'delete_order', ['order_id'=>$order->id,'text'=>'تم حذف الطلب رقم '.$order->id]));

//            if($order->is_amount_returned == 0){
//                foreach ($order->products as $product){
//                    $product_variant_amount = new ProductAmountLog();
//                    $product_variant_amount->product_id = $product->productVariant->product_id;
//                    $product_variant_amount->product_variant_id = $product->productVariant->id;
//                    $product_variant_amount->amount = $product->qty	;
//                    $product_variant_amount->price = $product->item_price;
//                    $product_variant_amount->order_id=$order->id;
//                    $product_variant_amount->type='AddToStock';
//                    $product_variant_amount->note="ارجاع كمية طلب ملغي";
//                    $product_variant_amount->is_approved = 1;
//                    $product_variant_amount->save();
//                }
//                $order->is_amount_returned = 1;
//                $order->save();
//                $order->refresh();
//            }
            $order->products()->delete();
            $order->balances()->delete();
            $order->transaction()->delete();
            $order->delete();
            return ['done'=>true];

        }
        return ['done'=>false];
    }
    public function refundCanceledOrder(Request $request){
        $this->validate($request,[
            'price'=>['required','numeric','min:1'],
            'transaction_image'=>['required','string'],
            'transaction_number'=>['required','numeric','min:1'],
            'order_id'=>['required','integer','exists:sub_orders,id'],
        ]);
        $order=Order::find($request->order_id);
        $user = User::find($order->user_id);
        if($order->is_canceled_refunded == 0) {
            $order->is_canceled_refunded = 1;
            $order->refunded_amount = $request->price;
            $order->transaction_image = $request->transaction_image;
            $order->transaction_number = $request->transaction_number;
            $order->save();
            try {
                $user = User::find($order->user_id);
                \Mail::to($user)->send(new OrderStatusChange(' تم اعادة قيمة الطلب الملغي رقم '.$order->order_number,' تم اعادة قيمة الطلب الملغي رقم '.$order->order_number,$order->refresh()));
            } catch (\Exception $e) {

            }

        }
        flash('تم القيام بالعملية بنجاح');
        return redirect()->back();
    }
    public function trackOrderOnMap(Request $request,$id){
        $out = Order::find($id);
        if(!$out){
            flash('الطلب غير موجود');
            return redirect()->route('system.orders.index');
        }

        $user_lat = $out->address->lat;
        $user_lng = $out->address->lng;

        return view('system_admin.orders.trackonmap', compact(['out','user_lat','user_lng']));

    }

}
