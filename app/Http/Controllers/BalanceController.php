<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function user(Request $request)
    {
        $o = User::has('balances')->orderBy('id','DESC');

        if($request->name){
            $o->where('name', 'like' ,'%'.$request->name.'%');
        }
        if($request->mobile){
            $o->where('mobile', $request->mobile);
        }
        if($request->email){
            $o->where('email', 'like' ,'%'.$request->email.'%');
        }

        $out = $o->paginate(15);
        $out->appends($request->all());
        return view('system_admin.balance.user-balance', compact(['out']));
    }


    public function showUser(Request $request, $id)
    {
        $out = User::findOrFail($id);
        $balances=UserBalance::where('user_id',$out->id)->orderBy('order_id','DESC')->orderBy('created_at','ASC');
        if($request->date_from){
            $balances->whereDate('created_at','>=',$request->date_from);
        }
        if($request->date_to){
            $balances->whereDate('created_at','<=',$request->date_to);
        }
        $balances = $balances->paginate(15);

        return view('system_admin.balance.show-user', compact(['out','balances']));
    }


}
