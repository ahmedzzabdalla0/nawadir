<?php
namespace App\Http\Controllers\API\User;

use App\Ad;
use App\Events\SendSilentUserNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Mail\NewContactUs;
use App\Models\AdminNotification;
use App\Models\Bank;
use App\Models\CaseGeneral;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\DeliveryPeriod;
use App\Models\Gov;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Page;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductAmountLog;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\UserFavorite;
use App\Models\UserNotification;
use App\Models\Variant;
use App\Rules\ValidMobile;
use App\User;
use Carbon\Carbon;
use Cassandra\Varint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class GeneralController extends Controller
{

    /**
     * @OA\Get(
     *      path="/user/get_configuration",
     *      operationId="config",
     *      tags={"GetGeneraLData"},
     *      summary="Get configrations API",
     *      description="Get configrations service",
     *      @OA\Parameter(
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
     *          description="successful operation with status = true and config,payment_types,user_types and cases arraies"
     *       ),
     * )
     */
    public function config()
    {
        $conf = Settings::all()->pluck('value','name');
        $config = [];
        $config['name']=$conf['name'];
        $config['email']=$conf['email'];
        $config['mobile']=$conf['mobile'];
        $config['whatsapp']=$conf['whatsapp'];
        $config['ios']=$conf['ios'];
        $config['tax']=$conf['tax'];
        $config['android']=$conf['android'];
        $config['facebook']=$conf['facebook'];
        $config['twitter']=$conf['twitter'];
        $config['instagram']=$conf['instagram'];
        $config['snapchat']=$conf['snapchat'];
        $config['currency_ar']=$conf['currency_ar'];
        $config['currency_en']=$conf['currency_en'];
        $config['map_geolocation_key']=$conf['map_geolocation_key'];
        $config['delivery_price_type']=$conf['delivery_price_type'];
        $config['product_properties']=$conf['product_properties'];
        $config['delivery_price']=$conf['delivery_price'];
        $config['tax_number']=$conf['tax_number'];
        $config['slaughter_cost']=$conf['slaughter_cost'];
        $config['cut_types_activation']=$conf['cut_types_activation'];
        $payment_types=PaymentType::orderBy('id','asc')->whereIn('id',[1,6])->get();
        $cases=CaseGeneral::orderBy('id','asc')->get();
        $cut_types = Variant::where('variant_type_id',2)->where('id','<>',14)->get();
        $cut_types_activation = Settings::where('name','cut_types_activation')->first();
        if($cut_types_activation->value == 0){
            $cut_types = Variant::where('id',14)->get();
        }
        $cover_types = Variant::where('variant_type_id',3)->get();
        return ControllersService::generateArraySuccessResponse(compact('config','payment_types','cases','cut_types','cover_types'));

    }
    /**
     * @OA\Get(
     *      path="/user/get_about_page",
     *      operationId="getAboutPage",
     *      tags={"GetGeneraLData"},
     *      summary="Get about page API",
     *      description="Get about page service",
     *      @OA\Parameter(
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
     *          description="successful operation with status = true and page object"
     *       ),
     * )
     */
    public function getAboutPage()
    {
        $page = Page::find(1);
        return ControllersService::generateArraySuccessResponse(compact('page'));

    }
    /**
     * @OA\Get(
     *      path="/user/get_rules_page",
     *      operationId="getRulesPage",
     *      tags={"GetGeneraLData"},
     *      summary="Get about page API",
     *      description="Get about page service",
     *      @OA\Parameter(
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
     *          description="successful operation with status = true and page object"
     *       ),
     * )
     */
    public function getRulesPage()
    {
        $page = Page::find(2);
        return ControllersService::generateArraySuccessResponse(compact('page'));

    }


    public function getPolicesPage()
    {
        $page = Page::find(3);
        return ControllersService::generateArraySuccessResponse(compact('page'));

    }
    /**
     * @OA\Get(
     *      path="/user/get_categories",
     *      operationId="cats",
     *      tags={"GetGeneraLData"},
     *      summary="Get categories API",
     *      description="Get categories service",
     *      @OA\Parameter(
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
     *          description="successful operation with status = true and categories array"
     *       ),
     * )
     */
    public function cats()
    {
        $categories=Category::where('status',1)->orderBy('sorted','asc')->get();
        return ControllersService::generateArraySuccessResponse(compact('categories'));

    }
    public function ads()
    {
        $slider = request()->get('slider');
        $ads=Ad::where('status',1)->where('slider',$slider)->orderBy('id','asc')->get();
        return ControllersService::generateArraySuccessResponse(compact('ads'));

    }
    public function cats_with_products()
    {
        $cats = [];
        $categories=Category::where('status',1)->orderBy('sorted','asc')->get();
        foreach($categories as $cat){
            $cats[] = array(
                'cat' => $cat,
                'products' => Product::where('category_id',$cat->id)->where('status','1')->skip(0)->take(10)->get()
            );

        }
        return ControllersService::generateArraySuccessResponse(compact('cats'));

    }

    public function countries()
    {
        $countries=Country::where('status',1)->get();
        return ControllersService::generateArraySuccessResponse(compact('countries'));

    }
    /**
     * @OA\Get(
     *      path="/user/get_areas",
     *      operationId="getAreas",
     *      tags={"GetGeneraLData"},
     *      summary="Get govs and areas API",
     *      description="Get govs and areas service",
     *         @OA\Parameter(
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
     *          description="successful operation with status = true and govs array"
     *       ),
     * )
     */
    public function getAreas(Request $request)
    {

        $feild = 'name_en';
        $lang = app()->getLocale();
        if($lang == 'en'){
            $feild = 'name_en';
        }else{
            $feild = 'name_ar';
        }
        $govs = Gov::with(['areas'=>function($q)use($feild){
            $q->orderBy($feild,'asc');
        }])->orderBy($feild,'asc')
            ->get();

        return ControllersService::generateArraySuccessResponse(compact('govs'));

    }
    /**
     * @OA\Get(
     *      path="/user/get_cut_types_images",
     *      operationId="get_cut_types_images",
     *      tags={"GetGeneraLData"},
     *      summary="Get get cut_types images API",
     *      description="Get  get cut_types images service",
     *         @OA\Parameter(
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
     *          description="successful operation with status = true and images array"
     *       ),
     * )
     */
    public function get_cut_types_images(Request $request)
    {

      $images=[];
      $cut_types = Variant::where('variant_type_id',2)->get();
      foreach ($cut_types as $cut){
          $images[]=$cut->image_url;
      }
        return ControllersService::generateArraySuccessResponse(compact('images'));

    }

    /**
     * @OA\Post(
     *      path="/user/contact_us",
     *      operationId="contactUs",
     *      tags={"PostData"},
     *      summary="contact us API",
     *      description="contact us service",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"name","mobile","email","title","details"},
     *                @OA\Property(
     *                     property="name",
     *                     description="sender name",
     *                     type="string",
     *                 ),
     *                     @OA\Property(
     *                     property="mobile",
     *                     description="sender mobile",
     *                     type="number",
     *                 ),
     *                   @OA\Property(
     *                     property="email",
     *                     description="sender valid email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     description="message title",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="details",
     *                     description="message details",
     *                     type="string",
     *                 ),
     *                @OA\Property(
     *                     property="user_id",
     *                     description="sender user id if exist",
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
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and message object"
     *       ),
     *      @OA\Response(response=422, description="one of the fields is not formated"),
     * )
     */

    public function contactUs(Request $request)
    {
        $request->validate( [
            'name' => 'required|string|max:100',
            'mobile' => ['required','numeric',new ValidMobile()],
           // 'email' => 'required|email',
            'title' => 'required|max:300',
            'details' => 'required|max:400',
        ]);
        $new = new Contact();
        $new->name = $request->name;
        $new->mobile = $request->mobile;
        $new->email = $request->email ? $request->email : '';
        $new->title = $request->title ? $request->title : '';
        $new->details = $request->details;
        $new->user_id = $request->user_id ?? 0;
        $new->save();
        $email = $request->email ? $request->email : '';
        $name =$request->name;
        $mobile =$request->mobile;
        $title =$request->title;
        $details =$request->details;
        $support = Settings::query()->where('name','email')->first()->value;
        try{
            Mail::to($support)->send(new NewContactUs($name,$mobile,$email,$title,$details));

        }catch (\Exception $e){}
        return ControllersService::generateArraySuccessResponse($new);

    }




//    public function DeleteUserNotification(Request $request)
//    {
//        $request->validate( [
//            'notification_id' => 'required|exists:users_notifications,id',
//        ]);
//        if ($not = UserNotification::where('user_id', $request->user_id)->find($request->notification_id)) {
//
//            $not->delete();
//            return ControllersService::generateArraySuccessResponse(null, 'notification_deleted');
//
//        }
//        return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);
//
//
//    }


    public function cronJobs()
    {
        //////      Log out Expired Users       ////////////
        $users=User::where('expiration_at','<',Carbon::now())->get();
        foreach ($users as $user){
            $token = Hash::make(Carbon::now() . $user->id . 'BaseNew' . Str::random(6));
            $user->token = $token;
            $user->device_key = '';
            $user->save();
            event(new SendSilentUserNotification($user->id, ['user_id'=>$user->id], 'logout'));
        }
        ////////////////////////////////////////////////////
        ///////  delete Old User Notification   ////////////
        $periodo=Settings::where('name','delete_user_notification_period')->first();
        $period=$periodo?$periodo->value:2;
        $periodo=Settings::where('name','delete_global_notification_period')->first();
        $period2=$periodo?$periodo->value:2;
        UserNotification::where('created_at','<',Carbon::now()->subDays($period))->whereNull('global_id')->delete();
        UserNotification::where('created_at','<',Carbon::now()->subDays($period2))->whereNotNull('global_id')->delete();

        ////////////////////////////////////////////////////
        ///////  delete Old admin Notification   ///////////
        AdminNotification::where('created_at','<',Carbon::now()->subDays(3))->delete();

        ////////////////////////////////////////////////////
        ///////  delete unpaid orders   ///////////
        $orders = Order::query()->where('case_id',1)->where('is_paid',0)->whereIn('payment_type',[2,3])->get();
        foreach ($orders as $order){
            $same = Carbon::parse($order->created_at)->addMinutes(5);
            $is_time = Carbon::now()->greaterThanOrEqualTo($same);
            if($is_time){
                $order_obj=Order::find($order->id);
                if($order_obj){
//                    foreach ($order->products as $product){
//                        $product_variant_amount = new ProductAmountLog();
//                        $product_variant_amount->product_id = $product->productVariant->product_id;
//                        $product_variant_amount->product_variant_id = $product->productVariant->id;
//                        $product_variant_amount->amount = $product->qty	;
//                        $product_variant_amount->price = $product->item_price;
//                        $product_variant_amount->order_id=$order->id;
//                        $product_variant_amount->type='AddToStock';
//                        $product_variant_amount->note="ارجاع كمية طلب ملغي";
//                        $product_variant_amount->is_approved = 1;
//                        $product_variant_amount->save();
//                    }
                    Transaction::query()->where('id',$order_obj->transaction_id)->forceDelete();
                    OrderProduct::query()->where('order_id',$order_obj->id)->forceDelete();
                    $order_obj->forceDelete();
                }
            }

        }
    }


  public function forgetPassword(Request $request)
    {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
     $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
 return ControllersService::generateArraySuccessResponse(compact('status'));

}
      ////////////////////////////////////////////////////
    }