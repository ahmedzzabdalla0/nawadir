<?php

namespace App\Http\Controllers\API\User;

use App\Events\SendSMS;

use App\Events\SendAdminNotification;
use App\Events\SendUserNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Controllers\MediaController;
use App\Http\Resources\User\BalanceResource;
use App\Http\Resources\User\OrderResource;
use App\Mail\OrderStatusChange;
use App\Models\Area;
use App\Models\Coupon;
use App\Models\Gov;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderCase;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductAmountLog;
use App\Models\ProductVariant;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserBalance;
use App\Models\UserBalanceAdd;
use App\Models\Variant;
use App\Models\DriverLocation;


use App\Rules\ValidMobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class OrderController extends Controller
{


    private function getUserArray()
    {
        $arr = ['addresses'];
        return $arr;
    }

    /**
     * @OA\Get(
     *      path="/user/get_orders",
     *      operationId="getUserOrders",
     *      tags={"GetData"},
     *      summary="Get user orders API",
     *      description="Get user orders api",
     *     security={{ "default": {}}},
     *     @OA\Parameter(
     *          name="user_id",
     *          description="user d",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and orders array"
     *       ),
     * )
     */
    public function getUserOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user_id)->orderBy('id','desc')->get();

        if (count($orders)) {
            $orders = OrderResource::collection($orders);
            return ControllersService::generateArraySuccessResponse(compact('orders'));
        } else {
            return ControllersService::generateGeneralResponse(false, 'orders_not_found', null, 422);
        }
    }


    /**
     * @OA\Get(
     *      path="/user/get_order_details",
     *      operationId="order_details",
     *      tags={"GetData"},
     *      summary="Get order details API",
     *      description="Get order details service",
     *      @OA\Parameter(
     *          name="order_id",
     *          description="valid order id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and order object"
     *       ),
     * )
     */
    public function order_details(Request $request)
    {
        $request->validate([
            'order_id'=>'required|integer|exists:orders,id'
        ]);
        $order = OrderResource::make(Order::findOrFail($request->order_id));

        return ControllersService::generateArraySuccessResponse(compact('order'));

    }

    public function getAddress(Request $request){
      $addresss=UserAddress::where('user_id', $request->user_id)->orderBy('id','asc')->get();
      return ControllersService::generateArraySuccessResponse(compact('addresss')); 

    }
    
    public function getDriverLastLocation(Request $request){
            $request->validate([
            'order_id'=>'required|integer|exists:orders,id'
        ]);
        $order = OrderResource::make(Order::findOrFail($request->order_id));
        if($order){
          $location =   DriverLocation::where('driver_id',$order->driver_id)->orderBy('id', 'DESC')->first();
          
        return ControllersService::generateArraySuccessResponse(compact('location'));
        }
            return ControllersService::generateGeneralResponse(false, 'orders_not_found', null, 422);
    }

    /**
     * @OA\Post(
     *      path="/user/add_user_address",
     *      operationId="addUserAddress",
     *      tags={"PostData"},
     *      summary="add user address API",
     *      description="add user address service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id","address_name","gov_id","area_id","build_number"},
     *                     @OA\Property(
     *                     property="user_id",
     *                     description="user id",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="address_name",
     *                     description="required address name",
     *                     type="number",
     *                 ),
     *                   @OA\Property(
     *                     property="gov_id",
     *                     description="required address governate id",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="area_id",
     *                     description="required address area id",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="street",
     *                     description="address street",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="build_number",
     *                     description="address build_number",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="floor",
     *                     description="address floor",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="flat",
     *                     description="address flat",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="lat",
     *                     description="address lat",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="lng",
     *                     description="address lat",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="full_address",
     *                     description="full_address",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *  @OA\Parameter(
     *          name="X-Authorization",
     *          description="Bearer Token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and user object"
     *       ),
     *      @OA\Response(response=422, description="user not found or one of the fields is missing"),
     * )
     */
    public function addUserAddress(Request $request)
    {
$roles = [
    'user_id' => 'required|exists:users,id',
    'address_name' => 'required',
    'area_id' => ['required',Rule::exists('areas','id')],
    'gov_id' => ['required',Rule::exists('govs','id')],
//    'street' => 'required',
//    'build_number' => 'required',
];
        $this->validate($request, $roles);


        $new_address = new UserAddress();
        $new_address->address_name = $request->address_name;
        $new_address->user_id = $request->user_id;
        $new_address->area_id = $request->area_id;
        $new_address->gov_id = $request->gov_id;
        $new_address->block = $request->block??null;
        $new_address->street = $request->street??null;
        $new_address->sub_street = $request->sub_street??null;
        $new_address->build_or_house = $request->floor?1:2;
        $new_address->build_number = $request->build_number;
        $new_address->home_number = null;
        $new_address->floor = $request->floor??null;
        $new_address->flat = $request->flat??null;
        $new_address->full_address = $request->full_address??null;
        $new_address->lat = $request->lat ? $request->lat : 0;
        $new_address->lng = $request->lng ? $request->lng : 0;
        $new_address->saved = 1;
        $new_address->save();
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($request->user_id)]);

    }



    public function updateUserAddress(Request $request)
    {
$roles = [
    'user_id' => 'required|exists:users,id',
    'address_name' => 'required',
    'area_id' => ['required',Rule::exists('areas','id')],
    'gov_id' => ['required',Rule::exists('govs','id')],
//    'street' => 'required',
//    'build_number' => 'required',
];
        $this->validate($request, $roles);


        $new_address =  UserAddress::find($request->address_id);
        $new_address->address_name = $request->address_name;
        $new_address->user_id = $request->user_id;
        $new_address->area_id = $request->area_id;
        $new_address->gov_id = $request->gov_id;
        $new_address->block = $request->block??null;
        $new_address->street = $request->street??null;
        $new_address->sub_street = $request->sub_street??null;
        $new_address->build_or_house = $request->floor?1:2;
        $new_address->build_number = $request->build_number;
        $new_address->home_number = null;
        $new_address->floor = $request->floor??null;
        $new_address->flat = $request->flat??null;
        $new_address->full_address = $request->full_address??null;
        $new_address->lat = $request->lat ? $request->lat : 0;
        $new_address->lng = $request->lng ? $request->lng : 0;
        $new_address->saved = 1;
        $new_address->update();
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($request->user_id)]);

    }

    /**
     * @OA\Post(
     *      path="/user/delete_user_address",
     *      operationId="deleteUserAddress",
     *      tags={"PostData"},
     *      summary="delete user address API",
     *      description="delete user address service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id","address_id"},
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="user id",
     *                     type="number",
     *                 ),
     *                     @OA\Property(
     *                     property="address_id",
     *                     description="address id",
     *                     type="number",
     *                 )
     *             )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="X-Authorization",
     *          description="Bearer Token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and user object"
     *       ),
     *      @OA\Response(response=422, description="user not found or one of the fields is missing"),
     * )
     */
    public function deleteUserAddress(Request $request)
    {

        $this->validate($request, [
            'address_id' => 'required|exists:users_addresses,id',
        ]);
        $address = UserAddress::find($request->address_id);
        if($request->user_id != $address->user_id){
            return ControllersService::generateGeneralResponse(false, 'address_not_yours', null,422);

        }
        $address->saved = 0;
        $address->save();
        $user = User::find($address->user_id);
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

    }

    /**
     * @OA\Post(
     *      path="/user/add_order",
     *      operationId="apiAddOrder",
     *      tags={"PostData"},
     *      summary="send order API",
     *      description="send order service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id","price","products","payment_type","address_id"},
     *                     @OA\Property(
     *                     property="user_id",
     *                     description="Authanticated user id",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="price",
     *                     description="price",
     *                     type="number",
     *                 ),
     *                 @OA\Property(
     *                     property="products",
     *                     description="array of products in the following format [[product_variant_id,quantity,cut_type_id,cover_type_id,is_slaughtered],[product_variant_id,quantity,cut_type_id,cover_type_id,is_slaughtered]] such as [[43,1,1,0,0],[65,2,2,1,1]],send cover_type_id 0 if no cover for product,get cover_types and cut_types from settings service,is_slaughtered is flag if sent 1 the product is slaughtered ,0 it is not slaughtered",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="payment_type",
     *                     description="payment type *you can find its ids from the get configration api",
     *                     type="number",
     *                 ),
     *                  @OA\Property(
     *                     property="address_id",
     *                     description="required address",
     *                     type="number",
     *                 )
     *     )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language", 
     *          description="language ar|en",
     *          required=false, 
     *          in="header", 
     *          @OA\Schema(
     *              type="string"  
     *          ) 
     *      ),   
     *     @OA\Parameter( 
     *          name="X-Authorization", 
     *          description="Bearer Token",  
     *          required=true,
     *          in="header",  
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ), 
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and user and transaction objects"
     *       ),
     *      @OA\Response(response=422, description="user not found or one of the fields is missing or token is invalid"),
     * )
     */ 
    public function apiAddOrder(Request $request) 
    {      
        $cart  = Cart::where('user_id',$request->user_id)->get();
                       $order_phone = Settings::where('name','order_phone')->first();
                            $order_phone2= Settings::where('name','order_phone2')->first();


        $products = [];
        foreach($cart as $c){
            $products[]= [$c->product_variant_id ,$c->quantity ,$c->cut_type_id , $c->cover_type_id , $c->is_slaughtered ==true ? 1 : 0];
        }
                $request->merge(['products' => json_encode($products ?? '')]);


// [[43,1,1,0,0],[65,2,2,1,1]]  [product_variant_id,quantity,cut_type_id,cover_type_id,is_slaughtered]
        $this->validate($request, [
            'products' => 'required|json',
        ]);
        if (!$request->products) {
            $request->offsetSet('products', []);
 
        }

        if (!is_array($request->products)) {
            if (is_array(json_decode($request->products))) {
                $request->offsetSet('products', json_decode($request->products));
            } else {
                $request->offsetSet('products', []);
            }
        }

$cover_types = Variant::where('variant_type_id',3)->pluck('id')->toArray();
        $cover_types[]=0;
        $cut_types = Variant::where('variant_type_id',2)->pluck('id')->toArray();
        $cut_types[]=0;
        $this->validate($request, [
            'price' => 'required|numeric',
            'payment_type' => 'required|numeric|exists:payment_types,id',
            'address_id' => 'required|numeric|exists:users_addresses,id',
            'products.*.0' => 'required|exists:product_variants,id',
            'products.*.1' => 'required|numeric|min:1',
            'products.*.2' => ['required','integer',Rule::in($cut_types)],
            'products.*.3' => ['required','numeric',Rule::in($cover_types)],
            'products.*.4' => ['required','numeric',Rule::in([0,1])],

        ],
        [
          'address_id.numeric' => 'اختر عنوان من قائمة العناوين بالأعلي', ]
        );

        $cut_types_activation = Settings::where('name','cut_types_activation')->first();
        $activated_cut_type = 1 * $cut_types_activation->value;
        $default_cut_type_id  = 14;
        $tax = Settings::where('name', 'tax')->first()->value or 0;
        $slaughter_cost = Settings::where('name', 'slaughter_cost')->first()->value or 0;
        $total_slaughter_cost=0;
        $delivery_price = 0;
        $delivery_price_type = Settings::where('name', 'delivery_price_type')->first()->value;
if($delivery_price_type == 2){
    $delivery_price = Settings::where('name', 'delivery_price')->first()->value;
}elseif ($delivery_price_type == 1){
    $address = UserAddress::find($request->address_id);
    if($address){
        $area = Area::find($address->area_id);
        if($area){
            $delivery_price = $area->delivery_price;
        }else{
            $delivery_price = 0;
        }
    }else{
        $delivery_price = 0;
    }
}elseif ($delivery_price_type == 3){
        $delivery_price = 0;
}

        // check price
        $totalPrice = 0;
        if (is_array($request->products)) {
            foreach ($request->products as $s) {

                $product = ProductVariant::find($s[0]);
                if(!$product){
                return ControllersService::generateGeneralResponse(false, 'product_not_found', null,422);

                }
                if($delivery_price_type == 3){
                    if($product->product->delivery_price > 0){
                        $delivery_price+=($s[2]*$product->product->delivery_price);
                    }
                }
                // && $s[2] > 0
                if($s[4]==1){
                    $total_slaughter_cost += $slaughter_cost* $s[1];
                }
                $totalPrice += $product->end_price * $s[1];

            }
        }
//        $coupon_id = 0;
//        $coupon_value = 0;
//        if ($request->coupon_id) {
//            $coupon_id = $request->coupon_id;
//            $coupon = Coupon::find($coupon_id);
//            $check_coupon = $this->checkOrderCouponValidity($request->coupon_id,Carbon::now()->toDateString(),$request->user_id);
//            if(!$check_coupon[0]){
//                return ControllersService::generateGeneralResponse(false, ['key' => $check_coupon[1], "text" => $check_coupon[2]], null, 422);
//            }
//            $coupon_value= round($totalPrice * $coupon->amount/100 , 3);
//            $totalPrice = $totalPrice - $coupon_value;
//        }
//        $delivery_period_id = $request->delivery_period_id ?$request->delivery_period_id:1;
        $totalPrice = round((($totalPrice+$total_slaughter_cost) * (1 + ($tax / 100))) + $delivery_price, 2);



//        if ($totalPrice != $request->price) {
//            $cur = Settings::where('name', 'currency_' . \App::getLocale())->first()->value;
//            return ControllersService::generateGeneralResponse(false, ['key' => "price_not_match", "text" => $totalPrice . ' ' . $cur], null,422);
//
//        }
        //end check price


        $user = User::find($request->user_id);
        if ($request->payment_type == 5) {
            // check user balance
            if ($user->balance < ($totalPrice)) {
                return ControllersService::generateGeneralResponse(false, 'dont_have_balance', null, 422);
            }
        }
        if ($request->payment_type == 4) {
            // check Bank info
            $this->validate($request, [
               // 'transaction_id' => 'required',
                'transaction_image' => 'required|image',

            ]);
        }


        if (Order::where('user_id', $request->user_id)
            ->where('total_price', $totalPrice)
            ->where(function ($q){
                $q->where(function ($q1){
                    $q1->where('payment_type','>',1)
                        ->where('is_paid',1);
                })
                    ->orwhere(function ($q1){
                        $q1->where('payment_type',1)
                            ;
                    });
            })
            ->where('created_at', '>', Carbon::now()->subMinute())->count()) {
            return ControllersService::generateGeneralResponse(false, 'already_added', null, 422);
        }
        
        


        if ($request->address_id) {
            $address = UserAddress::where('user_id', $request->user_id)->where('id', $request->address_id)->first();

            if (!$address) {
                return ControllersService::generateGeneralResponse(false, 'address_not_found', null, 400);

            }
            $address_id = $request->address_id;

        }
        if(!is_array($request->products)){
              return ControllersService::generateGeneralResponse(false, 'no_products', null, 422);
        }


        $order = new Order();
        $order->user_id = $request->user_id;
        $order->name = $user->name;
        $order->mobile = $user->mobile;
        $order->payment_type = $request->payment_type;
        $order->address_id = $address_id;
        $order->expected_delivery_time = Carbon::tomorrow()->toDateString();
        $order->case_id = 1;
        $order->total_price = 0;
        $order->tax_price = 0;
        $order->payment_id = $request->PaymentId;
        $order->tranId = $request->TranId;
        $order->trackId = $request->TrackId;
        $order->hash = $request->responseHash;
        $order->save();
        $oc = new OrderCase();
        $oc->case_id = $order->case_id;
        $oc->order_id = $order->id;
        $oc->text_ar = 'تم اضافة الطلب';
        $oc->text_en = 'Order was sent';
        $oc->save();
Cart::where('user_id',$request->user_id)->delete();
        // start services code

        $price = 0;

        if (is_array($request->products)) {
            foreach ($request->products as $s) {
                $service = ProductVariant::find($s[0]);
                $endprice = $service->end_price;
                $n = new OrderProduct();
                $n->order_id = $order->id;
                $n->product_id = $service->product_id;
                $n->product_variant_id = $service->id;
                $n->item_price = $endprice;
                $n->price = $endprice * $s[1];
                $n->slaughter_cost = $s[4]==1?$slaughter_cost * $s[1]:0;
                $n->qty = $s[1];
                $n->cut_type_id = $s[4]==1?($activated_cut_type == 1 && $s[2]>0 ? $s[2] : $default_cut_type_id):0;
                $n->is_covered = $s[3] >0 ?1:0;
                $n->cover_type_id = $s[3]>0?$s[3]:null;
                $n->save();
                $price += $n->price;
//                $product_variant_amount = new ProductAmountLog();
//                $product_variant_amount->product_id = $service->product_id;
//                $product_variant_amount->product_variant_id = $service->id;
//                $product_variant_amount->amount = -1 * $s[2];
//                $product_variant_amount->price = $endprice;
//                $product_variant_amount->order_id=$order->id;
//                $product_variant_amount->type='BuyFromStock';
//                $product_variant_amount->note="شراء كمية من المخزون";
//                $product_variant_amount->is_approved = 1;
//                $product_variant_amount->save();

            }
        }
        $order->slaughter_cost = $total_slaughter_cost;
        $order->products_price = $price;
        $order->total_price = round(($price+$total_slaughter_cost) * (1 + ($tax / 100)), 2) + $delivery_price;
        $order->delivery_price = $delivery_price;
        $order->tax_price = round(($price+$total_slaughter_cost) * (($tax / 100)), 2);
        $order->save();
        // end services code


        // start payment methods ruten

        if ($order->payment_type == 5) {
            // pay from balance
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->payment_type = $order->payment_type;
            $b->type = 'PayToOrder';
            $b->status = 1;
            $b->save();
            $bl = new UserBalance();
            $bl->amount = (-1) * $order->total_price;
            $bl->transaction_id = $b->id;
            $bl->user_id = $user->id;
            $bl->order_id = $order->id;
            $bl->type_id = 1;
            $bl->save();

            $total = round(UserBalance::where('user_id', $user->id)->sum('amount'), 2);
            event(new SendUserNotification($user->id, 'SubFromBalance', ['new_balance' => $total, 'amount' => $order->total_price], 1));

            $order->transaction_id = $b->id;
            $order->is_paid = 1;
            $order->case_id = 2;
            $order->save();
            $oc = new OrderCase();
            $oc->case_id = 2;
            $oc->order_id = $order->id;
            $oc->text_ar = 'تم دفع تكلفة الطلب';
            $oc->text_en = 'Order was paid';
            $oc->save();
            $cart->destroy();
            event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));
          event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $user->activation_code));
           event(new SendSMS(''.$order_phone->value, 'تم اضافة طلب جديد'));
                      event(new SendSMS(''.$order_phone2->value, 'تم اضافة طلب جديد'));

 
        }

        if ($order->payment_type == 4) {
            // pay from bank
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->payment_type = $order->payment_type;
            $b->type = 'PayToOrder';
            $b->transaction_id = time() . rand(1, 9999);
            if ($name = MediaController::SaveFile($request->transaction_image)) {
                $b->image = $name;
            }
            $b->status = 0;
            $b->save();

            $order->transaction_id = $b->id;
            $order->save();
            event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));


        }
        if ($order->payment_type == 1) {
            event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));
             event(new SendSMS(''.$order_phone->value, 'تم اضافة طلب جديد'));
             
                          event(new SendSMS(''.$order_phone2->value, 'تم اضافة طلب جديد'));



        }
        if ($order->payment_type == 3 || $order->payment_type == 2) {
            // pay from Card or mada
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->payment_type = $order->payment_type;
            $b->type = 'PayToOrder';
            $b->transaction_id = time() . rand(1, 9999);
            $b->status = 0;
            $b->save();
            $order->transaction_id = $b->id;
            $order->save();


        }

        // end

        //start notification code
        //end notification code
        $trans = null;
        if ($order->payment_type == 2 || $order->payment_type == 3) {
            $trans = Transaction::find($order->transaction_id);
        }
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($order->user_id), 'transaction' => $trans , 'order_id'=>$order->id , 'total_price'=>$order->total_price]);

    }



//     public function apiAddOrderTest(Request $request)
//     {

//         $this->validate($request, [
//             'products' => 'required|json',
//         ]);
//         if (!$request->products) {
//             $request->offsetSet('products', []);

//         }


//         if (!is_array($request->products)) {
//             if (is_array(json_decode($request->products))) {
//                 $request->offsetSet('products', json_decode($request->products));
//             } else {
//                 $request->offsetSet('products', []);
//             }
//         }

// $cover_types = Variant::where('variant_type_id',3)->pluck('id')->toArray();
//         $cover_types[]=0;
//         $cut_types = Variant::where('variant_type_id',2)->pluck('id')->toArray();
//         $cut_types[]=0;
//         $roles = [
//             'price' => 'required|numeric',
//             'payment_type' => 'required|numeric|exists:payment_types,id',
//             'products.*.0' => 'required|exists:product_variants,id',
//             'products.*.1' => 'required|numeric|min:1',
//             'products.*.2' => ['required','integer',Rule::in($cut_types)],
//             'products.*.3' => ['required','numeric',Rule::in($cover_types)],
//             'products.*.4' => ['required','numeric',Rule::in([0,1])],

//         ];
//         if(!$request->has('user_id')){
//             $roles['name']=['required','string', 'max:100'];
//             $roles['mobile']=['required', 'numeric', new ValidMobile()];
//         }
//         if($request->address_id > 0){
//             $roles['address_id'] = 'required|numeric|exists:users_addresses,id';
//         }
//         if($request->address_id == 0){
//             $roles['address_name']='required';
//             $roles['area_id']= ['required',Rule::exists('areas','id')];
//             $roles['gov_id']= ['required',Rule::exists('govs','id')];
//         }
//         $this->validate($request, $roles);
//         $user = null;
//         if($request->user_id){
//             $user = User::find($request->user_id);
//         }else{
//             $user  = $this->getUser($request->name,$request->mobile,$request->device_type,$request->header('device_name'),$request->header('device_key'));
//         }
//         $user_id = $user->id;
//         $address_id = $request->address_id;
//         if($address_id == 0){
//             $new_address = new UserAddress();
//             $new_address->address_name = $request->address_name;
//             $new_address->user_id = $user_id;
//             $new_address->area_id = $request->area_id;
//             $new_address->gov_id = $request->gov_id;
//             $new_address->block = $request->block??null;
//             $new_address->street = $request->street??null;
//             $new_address->sub_street = $request->sub_street??null;
//             $new_address->build_or_house = $request->floor?1:2;
//             $new_address->build_number = $request->build_number;
//             $new_address->home_number = null;
//             $new_address->floor = $request->floor??null;
//             $new_address->flat = $request->flat??null;
//             $new_address->full_address = $request->full_address??null;
//             $new_address->lat = $request->lat ? $request->lat : 0;
//             $new_address->lng = $request->lng ? $request->lng : 0;
//             $new_address->saved = 1;
//             $new_address->save();
//             $new_address->refresh();
//             $address_id = $new_address->id;
//         }
//         $cut_types_activation = Settings::where('name','cut_types_activation')->first();
//         $activated_cut_type = 1 * $cut_types_activation->value;
//         $default_cut_type_id  = 14;
//         $tax = Settings::where('name', 'tax')->first()->value or 0;
//         $slaughter_cost = Settings::where('name', 'slaughter_cost')->first()->value or 0;
//         $total_slaughter_cost=0;
//         $delivery_price = 0;
//         $delivery_price_type = Settings::where('name', 'delivery_price_type')->first()->value;
// if($delivery_price_type == 2){
//     $delivery_price = Settings::where('name', 'delivery_price')->first()->value;
// }elseif ($delivery_price_type == 1){
//     $address = UserAddress::find($address_id);
//     if($address){
//         $area = Area::find($address->area_id);
//         if($area){
//             $delivery_price = $area->delivery_price;
//         }else{
//             $delivery_price = 0;
//         }
//     }else{
//         $delivery_price = 0;
//     }
// }elseif ($delivery_price_type == 3){
//         $delivery_price = 0;
// }

//         // check price
//         $totalPrice = 0;
//         if (is_array($request->products)) {
//             foreach ($request->products as $s) {

//                 $product = ProductVariant::find($s[0]);
//                 if(!$product){
//                 return ControllersService::generateGeneralResponse(false, 'product_not_found', null,422);

//                 }
//                 if($delivery_price_type == 3){
//                     if($product->product->delivery_price > 0){
//                         $delivery_price+=($s[2]*$product->product->delivery_price);
//                     }
//                 }
//                 // && $s[2] > 0
//                 if($s[4]==1){
//                     $total_slaughter_cost += $slaughter_cost* $s[1];
//                 }
//                 $totalPrice += $product->end_price * $s[1];

//             }
//         }
// //        $coupon_id = 0;
// //        $coupon_value = 0;
// //        if ($request->coupon_id) {
// //            $coupon_id = $request->coupon_id;
// //            $coupon = Coupon::find($coupon_id);
// //            $check_coupon = $this->checkOrderCouponValidity($request->coupon_id,Carbon::now()->toDateString(),$request->user_id);
// //            if(!$check_coupon[0]){
// //                return ControllersService::generateGeneralResponse(false, ['key' => $check_coupon[1], "text" => $check_coupon[2]], null, 422);
// //            }
// //            $coupon_value= round($totalPrice * $coupon->amount/100 , 3);
// //            $totalPrice = $totalPrice - $coupon_value;
// //        }
// //        $delivery_period_id = $request->delivery_period_id ?$request->delivery_period_id:1;
//         $totalPrice = round((($totalPrice+$total_slaughter_cost) * (1 + ($tax / 100))) + $delivery_price, 2);



// //        if ($totalPrice != $request->price) {
// //            $cur = Settings::where('name', 'currency_' . \App::getLocale())->first()->value;
// //            return ControllersService::generateGeneralResponse(false, ['key' => "price_not_match", "text" => $totalPrice . ' ' . $cur], null,422);
// //
// //        }
//         //end check price


//         $user = User::find($user_id);
//         if ($request->payment_type == 5) {
//             // check user balance
//             if ($user->balance < ($totalPrice)) {
//                 return ControllersService::generateGeneralResponse(false, 'dont_have_balance', null, 422);
//             }
//         }
//         if ($request->payment_type == 4) {
//             // check Bank info
//             $this->validate($request, [
//               // 'transaction_id' => 'required',
//                 'transaction_image' => 'required|image',

//             ]);
//         }


//         if (Order::where('user_id', $user_id)
//             ->where('total_price', $totalPrice)
//             ->where(function ($q){
//                 $q->where(function ($q1){
//                     $q1->where('payment_type','>',1)
//                         ->where('is_paid',1);
//                 })
//                     ->orwhere(function ($q1){
//                         $q1->where('payment_type',1)
//                             ;
//                     });
//             })
//             ->where('created_at', '>', Carbon::now()->subMinute())->count()) {
//             return ControllersService::generateGeneralResponse(false, 'already_added', null, 422);
//         }


//         if ($address_id) {
//             $address = UserAddress::where('user_id', $user_id)->where('id', $address_id)->first();
//             if (!$address) {
//                 return ControllersService::generateGeneralResponse(false, 'address_not_found', null, 400);

//             }
//         }


//         $order = new Order();
//         $order->user_id = $user_id;
//         $order->name = $user->name;
//         $order->mobile = $user->mobile;
//         $order->payment_type = $request->payment_type;
//         $order->address_id = $address_id;
//         $order->expected_delivery_time = Carbon::tomorrow()->toDateString();
//         $order->case_id = 1;
//         $order->total_price = 0;
//         $order->tax_price = 0;
//         $order->tax_ratio = $tax;
//         $order->save();

//         $oc = new OrderCase();
//         $oc->case_id = $order->case_id;
//         $oc->order_id = $order->id;
//         $oc->text_ar = 'تم اضافة الطلب';
//         $oc->text_en = 'Order was sent';
//         $oc->save();

//         // start services code

//         $price = 0;

//         if (is_array($request->products)) {
//             foreach ($request->products as $s) {
//                 $service = ProductVariant::find($s[0]);
//                 $endprice = $service->end_price;
//                 $n = new OrderProduct();
//                 $n->order_id = $order->id;
//                 $n->product_id = $service->product_id;
//                 $n->product_variant_id = $service->id;
//                 $n->item_price = $endprice;
//                 $n->price = $endprice * $s[1];
//                 $n->slaughter_cost = $s[4]==1?$slaughter_cost * $s[1]:0;
//                 $n->qty = $s[1];
//                 $n->cut_type_id = $s[4]==1?($activated_cut_type == 1 && $s[2]>0 ? $s[2] : $default_cut_type_id):0;
//                 $n->is_covered = $s[3] >0 ?1:0;
//                 $n->cover_type_id = $s[3]>0?$s[3]:null;
//                 $n->save();
//                 $price += $n->price;
// //                $product_variant_amount = new ProductAmountLog();
// //                $product_variant_amount->product_id = $service->product_id;
// //                $product_variant_amount->product_variant_id = $service->id;
// //                $product_variant_amount->amount = -1 * $s[2];
// //                $product_variant_amount->price = $endprice;
// //                $product_variant_amount->order_id=$order->id;
// //                $product_variant_amount->type='BuyFromStock';
// //                $product_variant_amount->note="شراء كمية من المخزون";
// //                $product_variant_amount->is_approved = 1;
// //                $product_variant_amount->save();

//             }
//         }
//         $order->slaughter_cost = $total_slaughter_cost;
//         $order->products_price = $price;
//         $order->total_price = round(($price+$total_slaughter_cost) * (1 + ($tax / 100)), 2) + $delivery_price;
//         $order->delivery_price = $delivery_price;
//         $order->tax_price = round(($price+$total_slaughter_cost) * (($tax / 100)), 2);
//         $order->save();
//         // end services code


//         // start payment methods ruten

//         if ($order->payment_type == 5) {
//             // pay from balance
//             $b = new Transaction();
//             $b->user_id = $user->id;
//             $b->amount = $order->total_price;
//             $b->payment_type = $order->payment_type;
//             $b->type = 'PayToOrder';
//             $b->status = 1;
//             $b->save();
//             $bl = new UserBalance();
//             $bl->amount = (-1) * $order->total_price;
//             $bl->transaction_id = $b->id;
//             $bl->user_id = $user->id;
//             $bl->order_id = $order->id;
//             $bl->type_id = 1;
//             $bl->save();

//             $total = round(UserBalance::where('user_id', $user->id)->sum('amount'), 2);
//             event(new SendUserNotification($user->id, 'SubFromBalance', ['new_balance' => $total, 'amount' => $order->total_price], 1));

//             $order->transaction_id = $b->id;
//             $order->is_paid = 1;
//             $order->case_id = 2;
//             $order->save();
//             $oc = new OrderCase();
//             $oc->case_id = 2;
//             $oc->order_id = $order->id;
//             $oc->text_ar = 'تم دفع تكلفة الطلب';
//             $oc->text_en = 'Order was paid';
//             $oc->save();
//             event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));


//         }

//         if ($order->payment_type == 4) {
//             // pay from bank
//             $b = new Transaction();
//             $b->user_id = $user->id;
//             $b->amount = $order->total_price;
//             $b->payment_type = $order->payment_type;
//             $b->type = 'PayToOrder';
//             $b->transaction_id = time() . rand(1, 9999);
//             if ($name = MediaController::SaveFile($request->transaction_image)) {
//                 $b->image = $name;
//             }
//             $b->status = 0;
//             $b->save();

//             $order->transaction_id = $b->id;
//             $order->save();
//             event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));


//         }
//         if ($order->payment_type == 1 || $order->payment_type == 6) {
//             event(new SendAdminNotification('alqasim_orders', 'add_order', ['order_id' => $order->id, "order_status" => $order->case_id, 'text' => 'تم اضافة طلب جديد']));


//         }
//         if ($order->payment_type == 3 || $order->payment_type == 2) {
//             // pay from Card or mada
//             $b = new Transaction();
//             $b->user_id = $user->id;
//             $b->amount = $order->total_price;
//             $b->payment_type = $order->payment_type;
//             $b->type = 'PayToOrder';
//             $b->transaction_id = time() . rand(1, 9999);
//             $b->status = 0;
//             $b->save();
//             $order->transaction_id = $b->id;
//             $order->save();


//         }

//         // end

//         //start notification code
//         //end notification code
//         $trans = null;
//         if ($order->payment_type == 2 || $order->payment_type == 3) {
//             $trans = Transaction::find($order->transaction_id);
//         }
//         return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($order->user_id), 'transaction' => $trans]);

//     }
    public function update_status(Request $request)
    {


        $this->validate($request, [
            'order_id' => 'required|integer',
        ]);
        $user = User::find($request->user_id);
        if (!$user) {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);
        }
        $order = Order::query()->find($request->order_id);

        if (!$order) {
            return ControllersService::generateGeneralResponse(false, 'order_not_found', null, 422);
        }

        if ($order && $order->status->case_id == 6) {
            return ControllersService::generateGeneralResponse(false, 'new_order_already_canceled', null, 422);
        }
        if ($order && $order->status->case_id > 5) {
            return ControllersService::generateGeneralResponse(false, 'new_order_only_canceled', null, 422);
        }


        if($order->is_paid != 1) {
            $tran = $order->transaction;
            $tran->status = 1;
                            $tran->payment_id = $request->PaymentId;
        $tran->tranid = $request->TranId;
        $tran->result = $request->result;

            $tran->save();
            // return balance to user

            // $user_balance = new UserBalance();
            // $user_balance->user_id = $order->user_id;
            // $user_balance->order_id = $order->id;
            // $user_balance->amount = $order->total_price;
            // $user_balance->type_id = 3;
            // $user_balance->transaction_id = $order->transaction_id;
            // $user_balance->save();
            // $user=User::find($user_balance->user_id);

        }

//        if($order->is_amount_returned == 0){
//            foreach ($order->products as $product){
//                $product_variant_amount = new ProductAmountLog();
//                $product_variant_amount->product_id = $product->productVariant->product_id;
//                $product_variant_amount->product_variant_id = $product->productVariant->id;
//                $product_variant_amount->amount = $product->qty	;
//                $product_variant_amount->price = $product->item_price;
//                $product_variant_amount->order_id=$order->id;
//                $product_variant_amount->type='AddToStock';
//                $product_variant_amount->note="ارجاع كمية طلب ملغي";
//                $product_variant_amount->is_approved = 1;
//                $product_variant_amount->save();
//            }
//            $order->is_amount_returned = 1;
//            $order->save();
//            $order->refresh();
//        }

        // $oc=new OrderCase();
        // $oc->case_id=6;
        // $oc->order_id=$order->id;
        // $oc->text_ar='تم الغاء الطلب';
        // $oc->text_en='Order was canceled';
        // $oc->save();
        $order->is_paid = 1;
                $order->payment_id = $request->PaymentId;
        $order->tranId = $request->TranId;
        $order->trackId = $request->TrackId;
        $order->hash = $request->responseHash;
        $order->save();
     
        return ControllersService::generateArraySuccessResponse(['order' => new OrderResource($order)]);
    }

    /**
     * @OA\Post(
     *      path="/user/cancel_order",
     *      operationId="apiCancelOrder",
     *      tags={"PostData"},
     *      summary="cancel order API",
     *      description="cancel order service",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id","order_id"},
     *             @OA\Property(
     *                     property="user_id",
     *                     description="Authanticated user id",
     *                     type="number",
     *                 ),
     *              @OA\Property(
     *                     property="order_id",
     *                     description="order id",
     *                     type="number",
     *                 )
     *             )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="X-Authorization",
     *          description="Bearer Token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and canceled order object"
     *       ),
     *      @OA\Response(response=422, description="user not found or order not found or token is invalid or order is already canceled"),
     * )
     */
    public function apiCancelOrder(Request $request)
    {


        $this->validate($request, [
            'order_id' => 'required|integer',
        ]);
        $user = User::find($request->user_id);
        if (!$user) {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);
        }
        $order = Order::query()->find($request->order_id);

        if (!$order) {
            return ControllersService::generateGeneralResponse(false, 'order_not_found', null, 422);
        }

        if ($order && $order->status->case_id == 6) {
            return ControllersService::generateGeneralResponse(false, 'new_order_already_canceled', null, 422);
        }
        if ($order && $order->status->case_id > 5) {
            return ControllersService::generateGeneralResponse(false, 'new_order_only_canceled', null, 422);
        }


        if($order->is_paid == 1) {
            $tran = $order->transaction;
            $tran->status = 2;
            $tran->save();
            // return balance to user

            $user_balance = new UserBalance();
            $user_balance->user_id = $order->user_id;
            $user_balance->order_id = $order->id;
            $user_balance->amount = $order->total_price;
            $user_balance->type_id = 3;
            $user_balance->transaction_id = $order->transaction_id;
            $user_balance->save();
            $user=User::find($user_balance->user_id);

        }

//        if($order->is_amount_returned == 0){
//            foreach ($order->products as $product){
//                $product_variant_amount = new ProductAmountLog();
//                $product_variant_amount->product_id = $product->productVariant->product_id;
//                $product_variant_amount->product_variant_id = $product->productVariant->id;
//                $product_variant_amount->amount = $product->qty	;
//                $product_variant_amount->price = $product->item_price;
//                $product_variant_amount->order_id=$order->id;
//                $product_variant_amount->type='AddToStock';
//                $product_variant_amount->note="ارجاع كمية طلب ملغي";
//                $product_variant_amount->is_approved = 1;
//                $product_variant_amount->save();
//            }
//            $order->is_amount_returned = 1;
//            $order->save();
//            $order->refresh();
//        }

        $oc=new OrderCase();
        $oc->case_id=6;
        $oc->order_id=$order->id;
        $oc->text_ar='تم الغاء الطلب';
        $oc->text_en='Order was canceled';
        $oc->save();
        $order->case_id = 6;
        $order->save();
        try {
            $user = User::find($order->user_id);
            \Mail::to($user)->send(new OrderStatusChange(' تم الغاء الطلب رقم '.$order->order_number,' تم الغاء الطلب رقم '.$order->order_number,$order->refresh()));
        } catch (\Exception $e) {

        }
        event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم الغاء الطلب رقم '.$order->id]));
        return ControllersService::generateArraySuccessResponse(['order' => new OrderResource($order)]);
    }

    public function getUser($name,$mobile,$device_type,$device_name,$device_key)
    {

        $user = User::query()->where('mobile', $mobile)->first();

        if(!$user){
            $object = new User();
            $object->name = $name;
            $object->mobile = $mobile;
            $object->email =  null;
            $object->password = \Hash::make($mobile);
            $object->pne = str_random(2) . rand(10, 99) . $mobile;
            $object->status = 1;
            $object->lat = 0;
            $object->lng = 0;
            $object->activation_code = rand(1000, 9999);
            $last_login = Carbon::now()->toDateTimeString();
            $token = \Hash::make($last_login . $object->id . 'BaseNew' . str_random(6));
            $object->token = $token;
            $object->last_login = Carbon::now();
            $object->expiration_at = Carbon::now()->addMonths(6);
            $object->device_type = $device_type;
            if ($device_name) {
                $object->device_name = $device_name;
            }
            $object->save();
            $object->refresh();
            if ($device_key) {
                ControllersService::changeUserKey($object->id, $device_key);
            }
            $user = User::find($object->id);
            ControllersService::regWorkEvent('تم اضافة مستخدم جديد', 'info');
            //['user_data' => User::with($this->getUserArray())->find($object->id)]
        }else{
            $object = User::find($user->id);
            $object->name = $name;
            $object->status = 1;
            $last_login = Carbon::now()->toDateTimeString();
            $token = \Hash::make($last_login . $object->id . 'BaseNew' . str_random(6));
            $object->token = $token;
            $object->last_login = Carbon::now();
            $object->expiration_at = Carbon::now()->addMonths(6);
            $object->device_type = $device_type;
            if ($device_name) {
                $object->device_name = $device_name;
            }
            $object->save();
            $object->refresh();
            if ($device_key) {
                ControllersService::changeUserKey($object->id, $device_key);
            }
            $user = User::find($object->id);
        }
        return $user;

    }

}
