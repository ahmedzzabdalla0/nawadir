<?php

namespace App\Http\Controllers;

use App\Events\SendAdminNotification;
use App\Events\SendUserNotification;
use App\Models\Country;
use App\Models\MaintenanceRequest;
use App\Models\Order;
use App\Models\OrderCase;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\SubOrder;
use App\Models\SubOrderCase;
use App\Models\SubOrderStatus;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Models\UserBalanceAdd;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request){
        $obj=Transaction::where('transaction_id',$request->TID)->first();
        if(!$obj){
            return view('payment.fail',['message_ar'=>'الطلب غير موجود','message_en'=>'order not found']);
        }
        $ip = $request->server('SERVER_ADDR');
        $ch = $this->initializePayment($obj,$this->get_server_ip());
        $server_output = curl_exec($ch);
        curl_close($ch);
$o = $server_output;
        $server_output = json_decode($server_output,true);

        if(isset($server_output['payid']) && isset($server_output['targetUrl']) && $server_output['payid'] != NULL&&$server_output['targetUrl'] != NULL){
            // header("location:".route('payment.fail'));
            $url=$server_output['targetUrl']."?paymentid=".$server_output['payid'];
         //   return view('payment.frame',['url'=>$url]);
            header('Location: '. $url,true,301);
        }else{
            return view('payment.fail',['message_ar'=>'فشلت عملية الدفع','message_en'=>($server_output['error_msg']??'')]);
        }
    }
    public function success(Request $request)
    {


        $PaymentID = $request->PaymentId;
        $pResult = $request->Result;
        $orderID = $request->OrderID;
        $postDate = $request->PostDate;
        $tranID = $request->TranId;
        $responseHash = $request->responseHash;
        $responseCode = $request->ResponseCode;
        $trackID = $request->TrackId;
        $auth = $request->Auth??null;
        $amount = $request->amount;
//        $requestHash ="".$tranID."|e73be5fbf70116e89e904f312dd26fa833fbe550320b5ecfeb257d08e93ee996|".$responseCode."|".$amount."";
        $requestHash ="".$tranID."|963757fd48ac12ed99df5c0ffe035aa4cfef4ddb1b9bee174bd8c37e57d0e72f|".$responseCode."|".$amount."";
        $hash=hash('sha256', $requestHash);
        $result_url = route('payment.fail');
        $result_params = "?PaymentID=" . $PaymentID.'&trackID='.$trackID ;
        if($trans=Transaction::where('id',$trackID)->first()){

            $trans->payment_id=$PaymentID;
            $trans->result=$pResult;
            $trans->postdate=$postDate??date('Y-m-d');
            $trans->tranid=$tranID;
            $trans->auth=$auth;
            $trans->ref=$responseHash;
            $trans->trackid=$trackID;
            $trans->responce_json=json_encode($request->all());
            $trans->status=1;
            $trans->save();
            if ( $pResult == "Successful" && $hash == $responseHash)
            {
                if($trans->type=='AddToBalance' ){
                    if($order=UserBalanceAdd::where('transaction_id',$trans->id)->first()){
                        $user_balance = new UserBalance();
                        $user_balance->user_id = $order->user_id;
                        $user_balance->order_id = 0;
                        $user_balance->amount = $order->amount;
                        $user_balance->type_id = 2;
                        $user_balance->transaction_id =$trans->id;
                        $user_balance->save();
                        $user= \App\User::find($order->user_id);
                        $order->status=1;
                        $order->save();
                        event(new SendUserNotification($order->user_id,  'AddToBalance',  ['new_balance'=>$user->balance,'amount'=>$order->amount],1));
                    }
                }elseif($trans->type == 'PayToOrder'){
                    if($trans->order){
                        $order = $trans->order;

                        $trans->status = 1;
                        $trans->save();
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
                }
                $result_url = route('payment.success.done');

                $result_params = "?PaymentID=" . $PaymentID ;






            }
            else
            {
                if($trans->type == 'PayToOrder'){
                    if($trans->order){
                        $order=Order::find($trans->order->id);
                        $order->products()->forceDelete();
                        $order->forceDelete();
                        $trans->forceDelete();
                    }
                }
                $result_url = route('payment.fail');
                $result_params = "?PaymentID=" . $PaymentID ;

            }

        }
//        echo "REDIRECT=".$result_url.$result_params;
       // echo "REDIRECT=".$result_url;
        header("location:".$result_url.$result_params);


        return ;



    }

    public function successdone()
    {
        echo '<h1 style="text-align: center;padding-top: 100px;color: #05b41a;">تم الدفع بنجاح</h1>';
    }
    public function fail(Request $request)
    {


        echo '<h1 style="text-align: center;padding-top: 100px;color: #b41500;">فشلت عملية الدفع</h1>';
    }

    public function initializePayment($transaction,$ip){
        if (! function_exists( 'curl_version' )) {
            exit ( "Enable cURL in PHP" );
        }
        $orderId = $transaction->id;
        $user = \App\User::find($transaction->user_id);
        $email='info@nwader.com.sa';
        if ($user && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $email =  $user->email;
        }

        $amount = round($transaction->amount,1);


//        $txn_details= "$orderId|nawder|nawder@123|e73be5fbf70116e89e904f312dd26fa833fbe550320b5ecfeb257d08e93ee996|$amount|SAR";
        $txn_details= "$orderId|nawader|nawader@URWAY_951|963757fd48ac12ed99df5c0ffe035aa4cfef4ddb1b9bee174bd8c37e57d0e72f|$amount|SAR";
        $hash=hash('sha256', $txn_details);
        $fields = array(
            'trackid' => $orderId ,
            'terminalId' => "nawader",
//            'terminalId' => "nawder",
            'customerEmail' => $email,
            'action' => "1", // action is always 1
            'merchantIp' =>$ip,
//            'password'=>"nawder@123",
            'password'=>"nawader@URWAY_951",
            'currency' => "SAR",
            'country'=>"SA",
            // 'redirect_url'=>$success_url,
            //'success_url'=>$success_url,
            'amount' => ($amount),
            'requestHash' => $hash ,//generated Hash
            'udf2' => route('payment.success') //generated Hash
        );

        $fields_string = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
//        curl_setopt($ch, CURLOPT_URL,'https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
        //$ch=curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
        // curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length:' . strlen($fields_string)));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // dd(curl_exec($ch));
        return $ch;

//        ------------------

//        $txn_details= "$orderId|selselam|selselam@123|46ea47c46142d9083222e382297e4a03b392edae9e77ed6c904fb6f540af7576|$amount|SAR";
//        $hash=hash('sha256', $txn_details);
//        $success_url = route('payment.success');
//        $error_url = route('payment.fail');
//        $fields = array(
//            'trackid' => $orderId ,
//            'terminalId' => "selselam",
////            'customerEmail' => $email,
//            'action' => "1", // action is always 1
//             'merchantIp' =>$ip,
//            'password'=>"selselam@123",
//            'currency' => "SAR",
//           'country'=>"SA",
//            'error_url'=>$error_url,
//            'success_url'=>$success_url,
//            'amount' => $amount,
//            'requestHash' => $hash //generated Hash
//        );
//
//        $fields_string = json_encode($fields);
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL,'https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
//////        $ch=curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
//////        curl_setopt($ch, CURLOPT_POST, 1);
////
////        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
////        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
////
////        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length:' . strlen($fields_string)));
////        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
////        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
////        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//       // dd(curl_exec($ch));
////        $ch=curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest'); // Will be provided by URWAY
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($fields_string))
//        );
//        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//        return $ch;
    }
    function get_server_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
