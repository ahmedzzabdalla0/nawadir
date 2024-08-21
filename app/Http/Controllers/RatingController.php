<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Order;
use App\Models\SubOrder;
use App\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request){

        $users = User::query()->pluck('id')->toArray();
        $orders_query = Order::query()
            ->whereIn('user_id',$users)
            ->where('is_rate_approved',0)
        ;
        if($request->has('is_rate_approved') && $request->is_rate_approved != -1){
            $orders_query->where('is_rate_approved', $request->is_rate_approved);
        }
        if($request->date_from){
            $orders_query->whereDate('rate_time','>=',$request->date_from);
        }
        if($request->date_to){
            $orders_query->whereDate('rate_time','<=',$request->date_to);
        }

        $out = $orders_query->orderBy('updated_at','desc')->paginate(15);
        $out->appends($request->all());
        return view('system_admin.ratings.index', compact(['out']));
    }
    public function show(Request $request, $id)
    {
        $out = Order::findOrFail($id);
        return view('system_admin.ratings.show-rate', compact(['out']));
    }
    public function accept(Request $request)
    {
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $o = Order::find($id);
                if($o->is_rate_approved==0){
                    $o->is_rate_approved = 1;
                    $o->save();
                }
            }
            return ['done' => 1];

        } else {
            $o = Order::find($request->id);
            if($o->is_rate_approved==0) {
                $o->is_rate_approved = 1;
                $o->save();
            }
            return ['done' => 1];
        }
    }
    public function decline(Request $request)
    {

        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $o = Order::find($id);
                if($o->is_rate_approved==0){
                    $o->is_rate_approved = 2;
                    $o->save();
                }
            }
            return ['done' => 1];
        } else {
            $o = Order::find($request->id);
            if($o->is_rate_approved == 0){
                $o->is_rate_approved = 2;
                $o->save();
            }
            return ['done' => 1];
        }
    }
}
