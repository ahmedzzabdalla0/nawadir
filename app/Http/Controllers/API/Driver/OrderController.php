<?php

namespace App\Http\Controllers\API\Driver;


use App\Events\SendAdminNotification;
use App\Events\SendUserNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Controllers\MediaController;
use App\Http\Resources\OrderSubResource;
use App\Http\Resources\User\BalanceResource;
use App\Http\Resources\User\OrderResource;
use App\Mail\OrderStatusChange;
use App\Models\Area;
use App\Models\CancelPrice;
use App\Models\Coupon;
use App\Models\DailyMeal;
use App\Models\Driver;
use App\Models\DriverLocation;
use App\Models\MealSpecial;
use App\Models\Order;
use App\Models\OrderCase;
use App\Models\OrderMeal;
use App\Models\Meal;
use App\Models\Package;
use App\Models\ProductAmountLog;
use App\Models\ProductVariant;
use App\Models\Settings;
use App\Models\Subscription;
use App\Models\SubscriptionOrder;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserBalance;
use App\Models\UserBalanceAdd;
use App\Models\UserSubscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class OrderController extends Controller
{


    private function getUserArray()
    {
        $arr = [];
        return $arr;
    }

    /**
     * @OA\Get(
     *      path="/driver/get_orders",
     *      operationId="getUserOrders",
     *      tags={"GetDataDriver"},
     *      summary="Get driver orders API",
     *      description="Get driver orders api",
     *     security={{ "default": {}}},
     *     @OA\Parameter(
     *          name="driver_id",
     *          description="driver d",
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
     *          description="successful operation with status = true and orders array"
     *       ),
     * )
     */
    public function getUserOrders(Request $request)
    {
        $orders = Order::query()->whereIn('case_id',[3,4])->where('driver_id', $request->driver_id)->get();

        if (count($orders)) {
            $orders=OrderResource::collection($orders);
            return ControllersService::generateArraySuccessResponse(compact('orders'));
        } else {
            return ControllersService::generateGeneralResponse(false, 'orders_not_found', null, 422);
        }
    }
    /**
     * @OA\Get(
     *      path="/driver/get_archived_orders",
     *      operationId="getUserArchivedOrders",
     *      tags={"GetDataDriver"},
     *      summary="Get driver archived orders API",
     *      description="Get driver archived orders api",
     *     security={{ "default": {}}},
     *     @OA\Parameter(
     *          name="driver_id",
     *          description="driver d",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page",
     *          description="page number, in case if use in home page start it 2 to get second page after the four shown products",
     *          required=false,
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
     *          description="successful operation with status = true and orders array"
     *       ),
     * )
     */
    public function getUserArchivedOrders(Request $request)
    {
        $page = 0;
        $per_page = 4;
        if ($request->page) {
            if ($request->page > 1) {
                $page = $request->page - 1;
            }
        }
        $q=Order::query()->whereIn('case_id',[5])->where('driver_id', $request->driver_id);
        $orders_out=$q->take($per_page+1)->offset(($per_page * $page))->get();

        $has_more = false;
        if(count($orders_out)>$per_page){
            $has_more=true;
            $orders = $orders_out->forPage(1, $per_page);

        }else{
            $orders=$orders_out;
        }
        $orders=OrderResource::collection($orders);
        return ControllersService::generateArraySuccessResponse(compact('orders'),'default_message',$has_more);

//        if (count($orders)) {
//            $orders=OrderResource::collection($orders);
//            return ControllersService::generateArraySuccessResponse(compact('orders'));
//        } else {
//            return ControllersService::generateGeneralResponse(false, 'orders_not_found', null, 422);
//        }
    }


   public function order_details(Request $request)
    {
        $request->validate([
            'order_id'=>'required|integer|exists:orders,id'
        ]);
        $order = OrderResource::make(Order::findOrFail($request->order_id));

        return ControllersService::generateArraySuccessResponse(compact('order'));

    }

    /**
     * @OA\Post(
     *      path="/driver/change_order_status",
     *      operationId="ChangeOrderStatus",
     *      tags={"PostDataDriver"},
     *      summary="Change Order Status  API",
     *      description="Change Order Status service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"driver_id","order_id"},
     *             @OA\Property(
     *                     property="driver_id",
     *                     description="Authanticated driver id",
     *                     type="number",
     *                 ),
     *              @OA\Property(
     *                     property="order_id",
     *                     description="order id",
     *                     type="number",
     *                 )
     *              )
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
     *      @OA\Response(response=422, description="driver not found or order not found or token is invalid or order is already canceled"),
     * )
     */
    public function ChangeOrderStatus(Request $request)
    {


        $this->validate($request, [
            'order_id' => 'required|integer|exists:orders,id',
            'driver_id' => 'required|integer',
        ]);
        $driver = Driver::find($request->driver_id);
        if (!$driver) {
            return ControllersService::generateGeneralResponse(false, 'driver_not_found', null, 422);
        }
        $order = Order::query()->where('id',$request->order_id)->where('driver_id',$request->driver_id)->first();

        if (!$order) {
            return ControllersService::generateGeneralResponse(false, 'order_not_found', null, 422);
        }

        if ($order && $order->case_id == 6) {
            return ControllersService::generateGeneralResponse(false, 'new_order_already_canceled', null, 422);
        }
//        if ($order && $order->case_id > 5) {
//            return ControllersService::generateGeneralResponse(false, 'new_order_only_canceled', null, 422);
//        }
        if(in_array($order->case_id,[3,4])){
        $text_ar=null;
        $text_en=null;
            if($order->case_id == 3){
                $text_ar='تم بدء توصيل الطلب من قبل السائق';
                $text_en='Driver has started order delivery';
                $order->case_id=4;
            }elseif($order->case_id == 4){
                $text_ar='قام السائق بتسليم الطلب للعميل';
                $text_en='Driver has delivered order to the client';
                $order->case_id=5;
            }

                $oc=new OrderCase();
                $oc->case_id=$order->case_id;
                $oc->order_id=$order->id;
//            $oc->text_ar='تم تغيير الحالة من قبل السائق';
//            $oc->text_en='Order Status changed by driver';
                $oc->text_ar=$text_ar;
                $oc->text_en=$text_en;
                $oc->save();
                $order->save();
                $order->refresh();
                event(new SendUserNotification($order->user_id,  'ChangeOrderStatus',  ['order_id'=>$order->id,'new_status_ar'=>$order->status->name_ar,'new_status_en'=>$order->status->name_en],0,'user'));

                event(new SendAdminNotification('alqasim_orders', 'change_order', ['order_id'=>$order->id,"order_status"=>$order->case_id,'text'=>'تم تغيير الحالة من قبل السائق للطلب رقم '.$order->id]));

            }



        return ControllersService::generateArraySuccessResponse(['order' => new OrderResource($order)]);
    }



    /**
     * @OA\Post(
     *      path="/driver/UpdateDriverLocation",
     *      operationId="UpdateDriverLocation",
     *      tags={"PostDataDriver"},
     *      summary="Update Driver Location  API",
     *      description="Update Driver Location service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"driver_id","lat","lng"},
     *             @OA\Property(
     *                     property="driver_id",
     *                     description="Authanticated driver id",
     *                     type="number",
     *                 ),
     *              @OA\Property(
     *                     property="lat",
     *                     description="lat",
     *                     type="number",
     *                 ),
     *              @OA\Property(
     *                     property="lng",
     *                     description="lng",
     *                     type="number",
     *                 )
     *              )
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
     *      @OA\Response(response=422, description="driver not found or order not found or token is invalid or order is already canceled"),
     * )
     */
    public function UpdateDriverLocation(Request $request)
    {


        $this->validate($request, [
            'lat' => 'required',
            'lng' => 'required',
        ]);
        $driver = Driver::find($request->driver_id);
        if (!$driver) {
            return ControllersService::generateGeneralResponse(false, 'driver_not_found', null, 422);
        }

        $n=new DriverLocation();
        $n->driver_id=$driver->id;
        $n->lat=$request->lat;
        $n->lng=$request->lng;
        $n->save();

        // Notify Users




        return ControllersService::generateArraySuccessResponse(null);
    }



}
