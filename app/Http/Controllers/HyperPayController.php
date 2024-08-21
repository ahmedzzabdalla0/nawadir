<?php

namespace App\Http\Controllers;


use App\Events\SendAdminNotification;
use App\Events\SendUserNotification;
use App\Models\OrderCase;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Models\UserBalanceAdd;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HyperPayController extends Controller
{

    public function index(Request $request)
    {
        $transaction_id = $request->TID;
        if ($transaction = Transaction::where('transaction_id', $transaction_id)->where('status', 0)->first()) {

            if($transaction->type=="PayToOrder"){
                ////////////////////////////////////////////////
                ///     for test only  activate order        ///
                if($transaction->order){
                    $order = $transaction->order;

                    $transaction->status = 1;
                    $transaction->save();
                    $order->is_paid = 1;
                    $order->case_id = 2;
                    $order->save();

                    $oc=new OrderCase();
                    $oc->case_id=$order->case_id;
                    $oc->order_id=$order->id;
                    $oc->text_ar='تم دفع تكلفة الطلب';
                    $oc->text_en='Order was paid';
                    $oc->save();
                    event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));

                }
            }elseif($transaction->type =='AddToBalance'){
                if($order=UserBalanceAdd::where('transaction_id',$transaction->id)->first()){
                    $user_balance = new UserBalance();
                    $user_balance->user_id = $order->user_id;
                    $user_balance->order_id = 0;
                    $user_balance->amount = $order->amount;
                    $user_balance->type_id = 2;
                    $user_balance->transaction_id =$transaction->id;
                    $user_balance->save();
                    $user=User::find($order->user_id);
                    $order->status=1;
                    $order->save();
                    event(new SendUserNotification($order->user_id,  'AddToBalance',  ['new_balance'=>$user->balance,'amount'=>$order->amount],1));
                }

            }
            return ['done'=>true];






            ////////////////////////////////////////////////
            $url = "https://test.oppwa.com/v1/checkouts";
            $user=$transaction->user;
            $data = "entityId=8ac7a4ca6a304583016a40a53a970d06" .
                "&amount=".number_format($transaction->amount,2,'.','')  .
                "&currency=SAR" .
                "&paymentType=DB".
                "&testMode=EXTERNAL".
                "&merchantTransactionId=".$request->TID.
                "&customer.email=".$user->email.
                "&customer.merchantCustomerId=".$transaction->user_id.
                "&customer.givenName=".$user->name.
                "&customer.mobile=".$user->mobile
            ;

            //testMode=EXTERNAL
            //- merchantTransactionId="your unique ID in your database"
            //- customer.email = The user's email.

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGFjN2E0Y2E2YTMwNDU4MzAxNmE0MGE1MDE3YzBkMDJ8RjJXaGJoV1pmOQ=='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            $data = json_decode($responseData);

            if(preg_match('/^(000\.200)/', $data->result->code)) {
                $transaction->bank_id = $data->id;
                $transaction->save();
                return view('hyperpay.form', compact('data','transaction'));
            }
            return ['response_code'=>0,'message'=>$data->result->description];


        }
        return ['response_code'=>0,'message'=>'No transaction found'];

    }

    public function return_from_transaction(Request $request)
    {

        $url = "https://test.oppwa.com/" . $request->resourcePath;
        $url .= "?entityId=8ac7a4ca6a304583016a40a53a970d06";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E2YTMwNDU4MzAxNmE0MGE1MDE3YzBkMDJ8RjJXaGJoV1pmOQ=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $data = json_decode($responseData);
        if ($transaction = Transaction::where('bank_id', $data->ndc)->where('status', 0)->first()) {
            $transaction->bank_response=$data->result->description;
            $transaction->bank_code=$data->result->code;
            $transaction->bank_id = $data->id;

            $transaction->save();
            if(preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $data->result->code)){
                if ($transaction->order) {
                    $order = $transaction->order;

                    $transaction->status = 1;
                    $transaction->save();
                    $order->is_paid = 1;
                    $oc=new OrderCase();
                    $oc->case_id=2;
                    $oc->order_id=$order->id;
                    $oc->save();
                    $order->order_case_id = $oc->id;
                    $order->save();
                    return ['response_code'=>1,'message'=>$data->result->description];
                } elseif ($transaction->user_balance) {

                    $user = User::find($transaction->user_id);
                    $transaction->status = 1;
                    $transaction->save();
                    $nn = new UserBalance();
                    $nn->user_id = $user->id;
                    $nn->transaction_id = $transaction->id;
                    $nn->amount = $request->amount;
                    if ($transaction->is_mada) {
                        $nn->type = 'AdFrmMada';
                    } elseif ($transaction->is_card) {
                        $nn->type = 'AdFrmCard';

                    }
                    $nn->save();
                    $total = 0;
                    foreach (UserBalance::where('user_id', $user->id)->get() as $ub) {
                        $total += $ub->amount;
                    }
                    $user->balance = $total;
                    $user->save();

                    return ['response_code'=>1,'message'=>$data->result->description];
                } else {
                    return ['response_code'=>0,'message'=>'No Object related to this transaction'];
                }

                // end for test
            } else {
                return ['response_code'=>0,'message'=>$data->result->description];
            }
        } else {
            return ['response_code'=>0,'message'=>'NO TRANSACTION'];
        }
    }

}
