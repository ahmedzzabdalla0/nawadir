<?php

namespace App\Http\Controllers;

use App\Mail\ActivationCode;
use App\Models\Gov;
use App\Models\Category;
use App\Models\DeviceKey;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderCase;
use App\Models\OrderProduct;
use App\Models\Page;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\UserBalance;
use App\Models\UserFavorite;
use App\Models\UserNotification;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;

class ApiController extends Controller
{


    private function getUserArray()
    {
        $arr = ['addresses'];
        return $arr;
    }

    private function getProductArray($appends='')
    {
        $arr = ['category','images'];
        if($appends){
            foreach ($arr as $a){
                $new[]=$appends.'.'.$a;
            }
            $arr=$new;
        }
        return $arr;
    }

    private function getOrderArray()
    {
        $arr = ['address','paymentType','products.product','transaction'];
        return $arr;
    }

    /*////----------------------------------------Apis User--------------------------------------------------------
    ---------------------------------------------------------------------------------------------------------------------//////*/


    public function register(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'mobile' => ['required', 'numeric', 'unique:users,mobile', new ValidMobile()],
            'email' => 'required|email|unique:users,email',
            'password' => ['required', new PasswordPolicy()],
            'confirm_password' => ['required', 'same:password'],
        ]);
        $object=new User();
        $object->name=$request->name;
        $object->mobile=$request->mobile;
        $object->email=$request->email;
        $object->password=Hash::make($request->password);
        $object->pne=str_random(2).rand(10,99).$request->password;
        $object->status = 0;
        $object->activation_code = rand(1000, 9999);
//        $user->activation_code = '1234';
        $last_login = Carbon::now()->toDateTimeString();
        $token = Hash::make($last_login . $object->id . 'BASE' . str_random(6));
        $object->token = $token;
        $object->last_login = Carbon::now();
        $d_key = $request->header('device_key');
        if ($d_key) {
            if ($d_key) {
                if ($dkey = DeviceKey::where('key', $d_key)->first()) {
                    $dkey->user_id=$object->id;
                    $dkey->save();
                } else {
                    $dkey = new DeviceKey();
                    $dkey->key = $d_key;
                    $dkey->user_id=$object->id;
                    $dkey->save();

                }
            }
        }
        $object->save();
        \HELPER::send_sms($object->mobile, 'كود التفعيل الخاص بك هو ' . $object->activation_code);
        try{
            \Mail::to($object)->send(new ActivationCode($object->activation_code));
        }catch (\Exception $e){

        }


        ControllersService::regWorkEvent('تم اضافة مستخدم جديد', 'info');
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($object->id)]);

    }
    public function apiValidateMobile(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'mobile' => 'required',
        ]);
        if ($user = User::where('mobile', $request->mobile)->where('activation_code', $request->code)->first()) {
            if ($user->status == 0) {
                $user->status = 1;
                $d_key = $request->header('device_key');
                if ($d_key) {
                    if ($dkey = DeviceKey::where('key', $d_key)->first()) {
                        $dkey->user_id=$user->id;
                        $dkey->save();
                    } else {
                        $dkey = new DeviceKey();
                        $dkey->key = $d_key;
                        $dkey->user_id=$user->id;
                        $dkey->save();

                    }
                }
                $user->save();
                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);
            } else {
                return ControllersService::generateGeneralResponse(false, 'user_already_activated', null, 400);

            }
        } else {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
    }

    public function apiUpdateMobile(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'mobile' => ['required', 'string', 'unique:users,mobile', new ValidMobile()],
        ]);
        if ($user = User::where('id', $request->user_id)->first()) {
            $user->mobile = $request->mobile;
            $user->status = 0;
            $user->activation_code = rand(1000, 9999);

            $isSaved = $user->save();
            \HELPER::send_sms($user->mobile, 'كود التفعيل الخاص بك هو ' . $user->activation_code);
            try{
                \Mail::to($user)->send(new ActivationCode($user->activation_code));
            }catch (\Exception $e){

            }
            return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

        } else {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
    }

    public function ResendCode(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
        ]);
        if ($user = User::where('mobile', $request->mobile)->where('status', 0)->first()) {
            $user->activation_code = rand(1000, 9999);
            $isSaved = $user->save();
            \HELPER::send_sms($user->mobile, 'كود التفعيل الخاص بك هو ' . $user->activation_code);
            try{
                \Mail::to($user)->send(new ActivationCode($user->activation_code));
            }catch (\Exception $e){

            }
            return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

        } else {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
    }

    public function login(Request $request)

    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('mobile', $request->username)->first();
        if(!$user){
            $user = User::where('email', $request->username)->first();
        }
        if(!$user){
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
        if (Hash::check($request->password, $user->password)) {
            if ($user->status == 1) {

                $user->last_login = Carbon::now();
                $d_key = $request->header('device_key');
                if ($d_key) {
                    if ($dkey = DeviceKey::where('key', $d_key)->first()) {
                        $dkey->user_id=$user->id;
                        $dkey->save();
                    } else {
                        $dkey = new DeviceKey();
                        $dkey->key = $d_key;
                        $dkey->user_id=$user->id;
                        $dkey->save();

                    }
                }
                $user->save();

                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

            } elseif ($user->status == 0) {

                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)], 'mobile_not_valid',null, 422);

            } else {

                return ControllersService::generateGeneralResponse(false, 'account_blocked',  null, 422);
            }

        } else {

            return ControllersService::generateGeneralResponse(false, 'password_not_correct',  null, 422);

        }


    }

    public function logout(Request $request)
    {

        $user = User::find($request->user_id);
        $last_login = $user->last_login;
        $token = Hash::make($last_login . $user->id . 'BASE' . str_random(6));
        $user->token = $token;
        $user->save();
        return ControllersService::generateArraySuccessResponse(null, "logout_done");

    }

    public function forgetPassword(Request $request)

    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);

        $response = Password::broker('users')->sendResetLink(
            $request->only('email')
        );
        return $response == Password::RESET_LINK_SENT

            ? ControllersService::generateArraySuccessResponse(null,"forget_link_sended")

            : ControllersService::generateGeneralResponse(false, "user_not_found", null, 400);

    }
    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => ['required', new PasswordPolicy()],
            'confirm_password' => 'required|same:new_password',
            'user_id' => 'required|exists:users,id'

        ]);

        $user = User::find($request->user_id);
        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->new_password);
            $user->pne = str_random(2).rand(10,99).$request->new_password;
            $user->save();

            return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);
        } else {
            return ControllersService::generateGeneralResponse(false, 'invalid_old_password', null, 422);
        }

    }
    public function apiUpdate(Request $request)
    {

        $user = User::find($request->user_id);

        $this->validate($request, [
            'name' => 'required|string',
            'mobile' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                new ValidMobile()
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'uploaded_file' => 'image'

        ]);
        $user->name = $request->get('name');
        $user->mobile = $request->get('mobile');
        $user->email = $request->get('email');
        if ($name = MediaController::SaveFile($request->uploaded_file)) {
            $user->avatar = $name;
        }
        $user->save();
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);


    }


    public function updateDeviceKey(Request $request)

    {


        $this->validate($request, [

            'device_key' => 'required',
        ]);

        if (!$dkey = DeviceKey::where('key', $request->device_key)->first()) {
            $dkey = new DeviceKey();
            $dkey->key = $request->device_key;
            $dkey->user_id=$request->user_id?$request->user_id:0;
            $dkey->save();
        }
        return ControllersService::generateArraySuccessResponse(null );

    }


    /*////----------------------------------------Apia get--------------------------------------------------------
    ---------------------------------------------------------------------------------------------------------------------//////*/


    public function config()
    {
        $conf = Settings::all();
        $config = [];
        foreach ($conf as $c) {
            $config[$c->name] = $c->value;
        }
        return ControllersService::generateArraySuccessResponse(compact('config'));

    }

    public function cats()
    {
        $categories=Category::with(['products'])->get();
        return ControllersService::generateArraySuccessResponse(compact('categories'));

    }

    public function getAreas()
    {

        $govs = Gov::with('areas')->get();

        return ControllersService::generateArraySuccessResponse(compact('govs'));

    }
    public function getProducts(Request $request)
    {
        $page = 0;
        $per_page = 10;
        if ($request->page) {
            if ($request->page > 1) {
                $page = $request->page - 1;
            }
        }
        $products=Product::with($this->getProductArray())->orderBy('id','DESC')->take($per_page)->offset(($per_page * $page))->get();
        $has_more = Product::select('id')->take($per_page)->offset(($per_page * ($page + 1)))->first() ? true : false;

        return ControllersService::generateArraySuccessResponse(compact('products'),'default_message',$has_more);


    }
    public function getProductDetails(Request $request)
    {

        $product=Product::with($this->getProductArray())->find($request->product_id);

        return ControllersService::generateArraySuccessResponse(compact('product'));


    }


    public function getAboutPage()
    {
        $page = Page::find(1);
        return ControllersService::generateArraySuccessResponse(compact('page'));

    }

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






    public function getUserNotifications(Request $request)
    {

        if ($notifications = UserNotification::where('user_id', $request->user_id)->get()) {

            return ControllersService::generateArraySuccessResponse(compact('notifications'));
        } else {
            return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);
        }
    }

    public function getUserOrders(Request $request)
    {
        $orders = Order::with($this->getOrderArray())->where('user_id', $request->user_id)->get();

        if (count($orders)) {
            return ControllersService::generateArraySuccessResponse(compact('orders'));
        } else {
            return ControllersService::generateGeneralResponse(false, 'orders_not_found', null, 422);
        }
    }

    public function getUserFav(Request $request)
    {
        $b = UserFavorite::where('user_id', $request->user_id)->get();
        $ids = [];
        foreach ($b as $bb) {
            $ids[] = $bb->product_id;
        }
        $products = Product::with($this->getProductArray())->where('status', 1)->whereIn('id', $ids)->get();


        return ControllersService::generateArraySuccessResponse(compact('products'));

    }



    /*////----------------------------------------Apia post--------------------------------------------------------
    ---------------------------------------------------------------------------------------------------------------------//////*/


    public function contactUs(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => ['required'],
            'email' => 'required|email',
            'title' => 'required|max:50',
            'details' => 'required',
        ]);
        $new = new Contact();
        $new->name = $request->name;
        $new->mobile = $request->mobile;
        $new->email = $request->email;
        $new->title = $request->title;
        $new->details = $request->details;
        $new->user_id = $request->user_id ? $request->user_id : 0;
        $new->save();
        return ControllersService::generateArraySuccessResponse($new);

    }

    public function setUserNotificationToSeen(Request $request)
    {
        $this->validate($request, [
            'notification_id' => 'required|exists:users_notifications,id',
        ]);
        if ($notification = UserNotification::where('user_id', $request->user_id)->where('id', $request->notification_id)->first()) {
            $notification->is_seen = 1;
            $notification->save();
            return ControllersService::generateArraySuccessResponse(compact('notification'));
        } else {
            return ControllersService::generateGeneralResponse(false, 'notification_seen_before', null, 422);

        }

    }

    public function DeleteUserNotification(Request $request)
    {
        $this->validate($request, [
            'notification_id' => 'required|exists:users_notifications,id',
        ]);
        if ($not = UserNotification::where('user_id', $request->user_id)->find($request->notification_id)) {

            $not->delete();
            return ControllersService::generateArraySuccessResponse(null, 'notification_deleted');

        }
        return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);


    }
    public function apiAddOrder(Request $request)
    {

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


        $this->validate($request, [
            'price' => 'required|numeric',
            'products.*.0' => 'required|exists:products,id',
            'products.*.1' => 'required|numeric',

        ]);


        $tax = Settings::where('name', 'tax')->first()->value or 0;
        $delivery_price = Settings::where('name', 'delivery_price')->first()->value or 0;



        // check price
        $totalPrice = 0;
        if (is_array($request->products)) {
            foreach ($request->products as $s) {
                $product = Product::find($s[0]);
                $totalPrice += $product->price * $s[1];
            }
        }
        $totalPrice = round(($totalPrice * (1 + ($tax / 100)))+$delivery_price,2);

        if ($totalPrice != $request->price) {
            $cur = Settings::where('name', 'currency_'.\App::getLocale())->first()->value;
            return ControllersService::generateGeneralResponse(false, ['key'=>"price_not_match","text"=>$totalPrice.' '.$cur], 422);

        }
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
                'transaction_id' => 'required',
                'transaction_image' => 'required|image',

            ]);
        }


        if (Order::where('user_id', $request->user_id)
            ->where('total_price', $totalPrice)
            ->where('created_at','>', Carbon::now()->subMinute())->count()) {
            return ControllersService::generateGeneralResponse(false, 'already_added', null, 422);
        }




        if ($request->address_id) {
            $address = UserAddress::where('user_id', $request->user_id)->where('id', $request->address_id)->first();

            if (!$address) {
                return ControllersService::generateGeneralResponse(false, 'address_not_found', null, 400);

            }
            $address_id = $request->address_id;

        } else {
            $this->validate($request, [
                'area_id' => 'required',
                'gov_id' => 'required',
                'block' => 'required',
                'street' => 'required',
                'build_or_house' => 'required|in:1,2',

            ]);
            if ($request->build_or_house == 1) {
                $this->validate($request, [
                    'build_number' => 'required',
                ]);
            } elseif ($request->build_or_house == 2) {
                $this->validate($request, [
                    'home_number' => 'required',
                ]);
            }
            if ($request->save_address) {
                $new_address = new UserAddress();
                $new_address->user_id = $request->user_id;
                $new_address->area_id = $request->area_id;
                $new_address->gov_id = $request->gov_id;
                $new_address->block = $request->block;
                $new_address->street = $request->street;
                $new_address->sub_street = $request->sub_street;
                $new_address->build_or_house = $request->build_or_house;
                $new_address->build_number = $request->build_number ? $request->build_number : '';
                $new_address->home_number = $request->home_number ? $request->home_number : '';
                $new_address->floor = $request->floor;
                $new_address->flat = $request->flat;
                $new_address->full_address = $request->full_address;
                $new_address->lat = $request->lat ? $request->lat : 0;
                $new_address->lng = $request->lng ? $request->lng : 0;
                $new_address->saved = 1;
                $new_address->save();
                $address_id = $new_address->id;
            } else {
                $new_address = new UserAddress();
                $new_address->user_id = $request->user_id;
                $new_address->area_id = $request->area_id;
                $new_address->gov_id = $request->gov_id;
                $new_address->block = $request->block;
                $new_address->street = $request->street;
                $new_address->sub_street = $request->sub_street;
                $new_address->build_or_house = $request->build_or_house;
                $new_address->build_number = $request->build_number;
                $new_address->home_number = $request->home_number;
                $new_address->floor = $request->floor;
                $new_address->flat = $request->flat;
                $new_address->full_address = $request->full_address;
                $new_address->lat = $request->lat ? $request->lat : 0;
                $new_address->lng = $request->lng ? $request->lng : 0;
                $new_address->saved = 0;
                $new_address->save();
                $address_id = $new_address->id;
            }
        }


        $order = new Order();
        $order->user_id = $request->user_id;
        $order->name = $user->name;
        $order->mobile = $user->mobile;
        $order->payment_type = $request->payment_type;
        $order->address_id = $address_id;
        $order->order_case_id = 0;
        $order->total_price = 0;
        $order->tax_price = 0;
        $order->tax_ratio = $tax;

        $order->save();
        $oc=new OrderCase();
        $oc->case_id=$order->payment_type !=1?1:2;
        $oc->order_id=$order->id;
        $oc->save();
        $order->order_case_id = $oc->id;

        // start services code

        $price = 0;

        if (is_array($request->products)) {
            foreach ($request->products as $s) {
                $service = Product::find($s[0]);

                $n = new OrderProduct();
                $n->order_id = $order->id;
                $n->product_id = $service->id;
                $n->item_price = $service->price;
                $n->price = $service->price*$s[1];
                $n->qty = $s[1];
                $n->color_id = isset($s[2])?$s[2]:0;
                $n->size_id = isset($s[3])?$s[3]:0;
                $n->save();
                $price += $n->price;

            }
        }
        $order->products_price=$price;
        $order->total_price = round($price * (1 + ($tax / 100)),2)+$delivery_price;
        $order->delivery_price = $delivery_price;
        $order->tax_price = round($price * (($tax / 100)),2);
        $order->save();
        // end services code



        // start payment methods ruten

        if ($order->payment_type == 5) {
            // pay from balance
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->is_balance = 1;
            $b->status = 1;
            $b->save();
            $bl = new UserBalance();
            $bl->amount = (-1) * $order->total_price;
            $bl->transaction_id = $b->id;
            $bl->user_id = $user->id;
            $bl->type = 'PayToOrder';
            $bl->save();
            //change user balance
            $total = 0;
            foreach (UserBalance::where('user_id', $user->id)->get() as $ub) {
                $total += $ub->amount;
            }
            $user->balance = $total;
            $user->save();
            $order->transaction_id = $b->id;
            $order->is_paid = 1;
            $oc=new OrderCase();
            $oc->case_id= 2;
            $oc->order_id=$order->id;
            $oc->save();
            $order->order_case_id = $oc->id;
            $order->save();
        }

        if ($order->payment_type == 4) {
            // pay from bank
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->is_bank = 1;
            $b->transaction_id = $request->transaction_id;
            if ($name = MediaController::SaveFile($request->transaction_image)) {
                $b->image = $name;
            }
            $b->status = 0;
            $b->save();

            $order->transaction_id = $b->id;
            $order->save();
            // for testing perpose
            $b->status = 1;
            $b->save();
        }
        if ($order->payment_type == 3) {
            // pay from Card
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->is_card = 1;
            $b->transaction_id = time() . rand(1, 9999);
            $b->status = 0;
            $b->save();
            $order->transaction_id = $b->id;
            $order->save();


        }
        if ($order->payment_type == 2) {
            // pay from mada
            $b = new Transaction();
            $b->user_id = $user->id;
            $b->amount = $order->total_price;
            $b->is_mada = 1;
            $b->transaction_id = time() . rand(1, 9999);
            $b->status = 0;
            $b->save();

            $order->transaction_id = $b->id;
            $order->save();

        }


        // end

        //start notification code
        ControllersService::NotificationToAdmin('orders', 'add_order', ['order_id' => $order->id, 'text' => 'تم اضافة طلب جديد']);
        //end notification code
        $trans = null;
        if ($order->payment_type == 2 || $order->payment_type == 3) {
            $trans = Transaction::find($order->transaction_id);
        }        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($order->user_id), 'transaction' => $trans]);


    }




    public function add_remove_fav(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required',

        ]);
            if ($product = Product::where('id', $request->product_id)->first()) {
                if ($u = UserFavorite::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first()) {
                    $u->delete();
//                $user_data=User::find($request->user_id);

                    return ControllersService::generateArraySuccessResponse(null, 'deleted_from_fav');
                }
                $u = new UserFavorite();
                $u->user_id = $request->user_id;
                $u->product_id = $request->product_id;
                $u->save();

                return ControllersService::generateArraySuccessResponse(null, 'added_to_fav');

            }
            return ControllersService::generateGeneralResponse(false, 'product_not_found', null, 422);




    }

    public function DeleteAddress(Request $request)
    {
        $this->validate($request, [
            'address_id' => 'required|exists:users_addresses,id',
        ]);
        if ($addrress = UserAddress::where('user_id', $request->user_id)->where('saved',1)->where('id', $request->address_id)->first()) {
            $addrress->saved = 0;
            $addrress->save();
            return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($request->user_id)]);

        } else {
            return ControllersService::generateGeneralResponse(false, 'address_not_found', null, 422);

        }

    }



}
