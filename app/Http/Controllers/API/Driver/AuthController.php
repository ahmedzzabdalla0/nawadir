<?php

namespace App\Http\Controllers\API\Driver;


use App\Events\SendSilentUserNotification;
use App\Events\SendSMS;
use App\Events\SendUserEmail;
use App\Events\SendUserNotification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Password\UserPasswordController;
use App\Http\Resources\User\BalanceResource;
use App\Mail\ActivationCode;
use App\Mail\UserPassword;
use App\Mail\UserPasswordReset;
use App\Models\DeviceKey;
use App\Models\Driver;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Models\UserBalanceAdd;
use App\Models\UserNotification;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{


    private function getDriverArray()
    {
        $arr = [];
        return $arr;
    }

    /**
     * @OA\Post(
     *      path="/driver/login",
     *      operationId="login",
     *      tags={"AuthanticationDriver"},
     *      summary="Driver login API",
     *      description="Driver login service returns driver object",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"drivername", "password","device_type"},
     *                 @OA\Property(
     *                     property="drivername",
     *                     description="Driver email or mobile",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Driver Password",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="device_type",
     *                     description="Driver device type Android Or IOS",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar OR en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="device_key",
     *          description="mobile device key used for firebase notifications",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and driver object"
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="status = true : Driver not activated || status = false : Driver not found or password is not correct"
     *     )
     * )
     */
     
              public function delete_profile(Request $request)
    {

        $request->validate([

            'user_id' => 'required|exists:drivers,id'

        ]);
        $user = Driver::find($request->user_id);
        if ($user->id) {
            $user->status = 0;
             $user->save();
              return          ControllersService::generateArraySuccessResponse(['success' => 'deleted']);

        } 
        return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

    }
    public function login(Request $request)

    {

        $request->validate([
            'drivername' => 'required',
            'password' => 'required',
            'device_type' => [Rule::in(["Android", "IOS"])],
        ]);
        $driver = Driver::where('mobile', $request->drivername)->first();
        if (!$driver) {
            $driver = Driver::where('email', $request->drivername)->first();
        }
        if (!$driver) {
            return ControllersService::generateGeneralResponse(false, 'driver_not_found', null, 422);
        }
        if (Hash::check($request->password, $driver->password)) {
            if ($driver->status == 1) {
                $driver->last_login = Carbon::now();
                $driver->expiration_at = Carbon::now()->addMonths(6);
                if ($request->device_type) {
                    $driver->device_type = $request->device_type;
                }
                if ($request->lat && $request->lng) {
                    $driver->lat = $request->lat;
                    $driver->lng = $request->lng;
                }
                if ($request->header('device_key')) {
                    ControllersService::changeUserKey($driver->id, $request->header('device_key'),'driver');
                }
                if ($request->header('device_name')) {
                    $driver->device_name = $request->header('device_name');
                }
                $driver->save();

                return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)]);

            }
//            elseif ($driver->status == 0) {
//
//                return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)], 'mobile_not_valid', null, 422);
//
//            }
            else {
                return ControllersService::generateGeneralResponse(false, 'account_blocked', null, 422);
            }

        } else {
 
            return ControllersService::generateGeneralResponse(false, 'password_not_correct', null, 422);

        }


    }


    public function logout(Request $request)
    {

        $driver = Driver::find($request->driver_id);
        DeviceKey::where('user_id', $driver->id)->where('user_type','driver')->update(['user_id' => 0]); 
        event(new SendSilentUserNotification($driver->id, ['driver_id' => $driver->id], 'logout'));
        return ControllersService::generateArraySuccessResponse(null, null);

    }
      public function driver(Request $request)
    {

        $user = Driver::find($request->driver_id);
        if($user){
                         return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($user->id)]);

        }

        return ControllersService::generateArraySuccessResponse(null, null);
    }
    public function register(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'mobile' => ['required', 'numeric', 'unique:drivers,mobile,NULL,id', new ValidMobile()],
            'email' => 'nullable|email|unique:drivers,email',
            'password' => ['required', new PasswordPolicy(), 'confirmed'],
            'device_type' => [Rule::in(["Android", "IOS"])],
        ]);

        $object = new Driver();
        $object->name = $request->name;
        $object->mobile = $request->mobile;
        $object->email = $request->email ?? null;
        $object->password = Hash::make($request->password);
        $object->pne = str_random(2) . rand(10, 99) . $request->password;
        $object->status = 0;
        $object->lat = $request->lat;
        $object->lng = $request->lng;
        $object->activation_code = rand(1000, 9999);
        $last_login = Carbon::now()->toDateTimeString();
        $token = Hash::make($last_login . $object->id . 'Lubna' . str_random(6));
        $object->token = $token;
        $object->last_login = Carbon::now();
        $object->expiration_at = Carbon::now()->addMonths(6);
        $object->device_type = $request->device_type;
        if ($request->header('device_name')) {
            $object->device_name = $request->header('device_name');
        }
        $object->save();
        if ($request->header('device_key')) {
            ControllersService::changeUserKey($object->id, $request->header('device_key'));
        }


        $sms_mobile = ControllersService::prepareMobileForSms($object->mobile);
        try {
            event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $object->activation_code));
        } catch (\Exception $e) { }
        if($object->email){
            try {
                event(new SendUserEmail($object, new ActivationCode($object->activation_code)));
            } catch (\Exception $e) { }
        }

        ControllersService::regWorkEvent('تم اضافة مستخدم جديد', 'info');
        return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($object->id)],'register_done_successfully');

    }


    public function apiValidateMobile(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'mobile' => 'required|numeric',
        ]);

        if ($driver = Driver::where('mobile', $request->mobile)->where('activation_code', $request->code)->first()) {
            if ($driver->status == 0) {
                $driver->status = 1;
                if ($request->header('device_key')) {
                    ControllersService::changeUserKey($driver->id, $request->header('device_key'));
                }
                $driver->save();
                try {

                    event(new SendUserNotification($driver->id, 'AccountActivated', ['driver_id' => $driver->id], 0));

                } catch (\Exception $e) {

                }

                return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)]);
            } else {
                return ControllersService::generateGeneralResponse(false, 'driver_already_activated', null, 400);

            }
        } else {

            $driver = Driver::where('mobile', $request->mobile)->first();
            if (!$driver) {
                return ControllersService::generateGeneralResponse(false, 'driver_not_found', null, 422);
            }
            if ($driver->activation_code != $request->code) {
                return ControllersService::generateGeneralResponse(false, 'activation_code_error', null, 422);
            }

        }
    }

    public function apiUpdateMobile(Request $request)
    {

        $request->validate([
            'driver_id' => 'required',
        ]);
        if ($driver = Driver::where('id', $request->driver_id)->first()) {
            $request->validate([
                'mobile' => ['required', 'numeric', 'unique:drivers,mobile,' . $driver->id . ',id', new ValidMobile()],
            ]);


            $driver->mobile = $request->mobile;
            $driver->status = 0;
            $driver->activation_code = rand(1000, 9999);

            $driver->save();
            $sms_mobile = ControllersService::prepareMobileForSms($driver->mobile);

            try {
                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $driver->activation_code));

            } catch (\Exception $e) {
            }
            try {
                event(new SendUserEmail($driver, new ActivationCode($driver->activation_code)));

            } catch (\Exception $e) {

            }
            return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)]);

        } else {
            return ControllersService::generateGeneralResponse(false, 'driver_not_found', null, 422);

        }
    }


    public function ResendCode(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|exists:drivers,mobile',
        ]);

        if ($driver = Driver::where('mobile', $request->mobile)->where('status', 0)->first()) {
            $driver->activation_code = rand(1000, 9999);
            $driver->save();
            $sms_mobile = ControllersService::prepareMobileForSms($driver->mobile);
            try {
                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $driver->activation_code));
            } catch (\Exception $e) { }
            if($driver->email){
                try {
                    event(new SendUserEmail($driver, new ActivationCode($driver->activation_code)));
                } catch (\Exception $e) { }
            }

            return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)]);

        } else {
            $driver = Driver::where('mobile', $request->mobile)->where('status', 1)->first();
            if ($driver) {
                return ControllersService::generateGeneralResponse(false, 'driver_already_activated', null, 422);

            }
            return ControllersService::generateGeneralResponse(false, 'driver_not_found', null, 422);

        }
    }

    /**
     * @OA\Post(
     *      path="/driver/change_password",
     *      operationId="changePassword",
     *      tags={"AuthanticationDriver"},
     *      summary="change authanticated driver password API",
     *      description="change authanticated driver password service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"driver_id","old_password","new_password","new_password_confirmation"},
     *
     *                     @OA\Property(
     *                     property="driver_id",
     *                     description="Authanticated driver id",
     *                     type="number",
     *                 ),
     *                   @OA\Property(
     *                     property="old_password",
     *                     description="Account old password",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="new_password",
     *                     description="Account new password shoud be at least 6 chars and different from old one",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="new_password_confirmation",
     *                     description="should be same as new_password",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar Or en",
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
     *          description="successful operation with status = true and driver object"
     *       ),
     *      @OA\Response(response=422, description="driver not found or one of the fields is missing or token is invalid"),
     * )
     */
    public function changePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', new PasswordPolicy(), 'confirmed'],
            'driver_id' => 'required|exists:drivers,id'

        ]);
        $driver = Driver::find($request->driver_id);
        if (Hash::check($request->old_password, $driver->password)) {
            if(Hash::check($request->new_password, $driver->password)){
                return ControllersService::generateGeneralResponse(false, 'new_same_old_password', null, 422);
            }else{
                $driver->password = Hash::make($request->new_password);
                $driver->pne = str_random(2) . rand(10, 99) . $request->new_password;
                $driver->save();
                return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)]);
            }

        } else {
            return ControllersService::generateGeneralResponse(false, 'invalid_old_password', null, 422);
        }

    }

    /**
     * @OA\Post(
     *      path="/driver/update_profile",
     *      operationId="apiUpdate",
     *      tags={"AuthanticationDriver"},
     *      summary="Driver update profile API",
     *      description="Driver update profile service returns driver object in case of success",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"driver_id"},
     *                 @OA\Property(
     *                     property="name",
     *                     description="Driver name",
     *                     type="string",
     *                 ),
     *                @OA\Property(
     *                     property="mobile",
     *                     description="Driver mobile with length of 9 numbers and has to be uniqe for all drivers",
     *                     type="number",
     *                 ),
     *                @OA\Property(
     *                     property="email",
     *                     description="Driver valid email and has to be uniqe for all drivers",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="driver_id",
     *                     description="Authanticated driver id",
     *                     type="string",
     *                 ),
     *              @OA\Property(
     *                     property="uploaded_file",
     *                     description="profile image",
     *                     format="binary",
     *                     type="string",
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="X-Authorization",
     *          description="Bearer Token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar Or en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and driver object"
     *       ),
     *      @OA\Response(response=422, description="one of the fields is missing or has error"),
     * )
     */
    public function apiUpdate(Request $request)
    {

        $driver = Driver::find($request->driver_id);

        $request->validate([
            'name' => 'required|string',
            'mobile' => [
                'required',
                Rule::unique('drivers')->ignore($driver->id),
                new ValidMobile()
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('drivers')->ignore($driver->id),
            ],
            'uploaded_file' => 'image'

        ]);
        $driver->name = $request->get('name');
        $driver->email = $request->get('email');
        $driver->mobile = $request->get('mobile');

        if ($name = MediaController::SaveFile($request->uploaded_file)) {
            $driver->avatar = $name;
        }
        $driver->save();
//        if ($driver->mobile != $request->mobile) {
//            $driver->mobile = $request->mobile;
//            $driver->status = 0;
//            $driver->activation_code = rand(1000, 9999);
//            $token = Hash::make($driver->last_login . $driver->id . 'Lubna' . str_random(6));
//            $driver->token = $token;
//            $driver->save();
//            $sms_mobile = ControllersService::prepareMobileForSms($driver->mobile);
//            try {
//                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $driver->activation_code));
//            } catch (\Exception $e) { }
//            if($driver->email){
//                try {
//                    event(new SendUserEmail($driver, new ActivationCode($driver->activation_code)));
//                } catch (\Exception $e) { }
//            }
//
//        }
        return ControllersService::generateArraySuccessResponse(['driver_data' => Driver::with($this->getDriverArray())->find($driver->id)]);


    }
    /**
     * @OA\Post(
     *      path="/driver/forget_password",
     *      operationId="forgetPassword",
     *      tags={"AuthanticationDriver"},
     *      summary="driver forget password API",
     *      description="Resend new password to driver mobile or email contains link to set new password to email",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"drivername"},
     *                @OA\Property(
     *                     property="drivername",
     *                     description="it accept the email or the mobile of the driver reset method will be the first match",
     *                     type="string",
     *                 ),
     *             )
     *         )
     *     ),
     *    @OA\Parameter(
     *          name="language",
     *          description="language ar Or en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true"
     *       ),
     *      @OA\Response(response=422, description="driver not found"),
     * )
     */
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'drivername' => 'required',
//            'send_via' => ['required',Rule::in('sms','email')],
        ]);

        if($driver = Driver::where('mobile', $request->drivername)->first()) {

            $newPass=rand(1000,9999).str_random(2);
            $driver->password=Hash::make($newPass);
            $driver->pne=str_random(2) . rand(10, 99) . $newPass;
            $driver->save();
            $sms_mobile = ControllersService::prepareMobileForSms($driver->mobile);
            try {
                event(new SendSMS($sms_mobile, trans('api_texts.your_new_password') . $newPass));
            } catch (\Exception $e) {}
            if($driver->email){

                try {
                    event(new SendUserEmail($driver, new UserPassword($newPass)));
                } catch (\Exception $e) { }
            }


            return ControllersService::generateArraySuccessResponse(null, 'password_mobile_reset_send');
        } else {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);
        }
    }



    /**
     * @OA\Post(
     *      path="/driver/update_device_key",
     *      operationId="updateDeviceKey",
     *      tags={"AuthanticationDriver"},
     *      summary="update driver device key API",
     *      description="update driver device key for driver",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"device_key"},
     *                @OA\Property(
     *                     property="device_key",
     *                     description="new device key",
     *                     type="string",
     *                 ),
     *                     @OA\Property(
     *                     property="driver_id",
     *                     description="Authanticated driver id and its optional",
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
     *          description="successful operation with status = true"
     *       ),
     *      @OA\Response(response=422, description="driver not found or one of the fields is missing"),
     * )
     */
    public function updateDeviceKey(Request $request)
    {
        $this->validate($request, [
            'driver_id' => 'nullable|exists:drivers,id',
            'device_key' => 'required',
        ]);

        ControllersService::changeUserKey($request->driver_id ? $request->driver_id : 0, $request->device_key,'driver');

        return ControllersService::generateArraySuccessResponse(null);

    }


    public function wallet_details(Request $request)
    {
        $balances = UserBalance::where('driver_id', $request->driver_id)->orderBy('id', 'desc')->get();
        return ControllersService::generateArraySuccessResponse(['driver_balance' => Driver::find($request->driver_id)->balance, 'balances' => BalanceResource::collection($balances)]);

    }

    public function addToWallet(Request $request)
    {
        $request->validate([
            'payment_type' => ['required', Rule::in([2, 3])],
            'amount' => 'required|numeric|min:0'
        ]);
        $order = new UserBalanceAdd();
        $order->driver_id = $request->driver_id;
        $order->amount = $request->amount;
        $order->payment_type = $request->payment_type;
        $order->transaction_id = 0;
        $order->status = 0;
        $order->save();

        $b = new Transaction();
        $b->driver_id = $order->driver_id;
        $b->amount = $order->amount;
        $b->payment_type = $order->payment_type;
        $b->type = 'AddToBalance';
        $b->transaction_id = time() . rand(1, 9999);
        $b->status = 0;
        $b->save();
        $order->transaction_id = $b->id;
        $order->save();
        return ControllersService::generateArraySuccessResponse(['transaction' => $b->fresh(), 'driver_data' => Driver::with($this->getDriverArray())->find($order->driver_id), 'request' => $order->fresh()], 'default_message');

    }

    /**
     * @OA\Get(
     *      path="/driver/get_driver_notifications",
     *      operationId="getUserNotifications",
     *      tags={"GetDataDriver"},
     *      summary="Get driver notifications API",
     *      description="Get driver notifications service",
     *     security={{ "default": {}}},
     *      @OA\Parameter(
     *          name="driver_id",
     *          description="Driver id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *         @OA\Parameter(
     *          name="device_key",
     *          description="device_key",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
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
     *          description="successful operation with status = true and notifications array of objects"
     *       ),
     * )
     */
    public function getUserNotifications(Request $request)
    {

        if ($request->driver_id) {
            if ($notifications = UserNotification::where('user_id', $request->driver_id)->where('user_type', 'driver')->orderByDesc('id')->get()) {
                return ControllersService::generateArraySuccessResponse(compact('notifications'));
            } else {
                return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);
            }
        } elseif ($request->device_key) {
            $device = DeviceKey::where('d_key', $request->device_key)->first();
            if($device){
                if ($notifications = UserNotification::where('device_id', $device->id)->orderByDesc('id')->get()) {
                    return ControllersService::generateArraySuccessResponse(compact('notifications'));
                } else {
                    return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);
                }

            }else{
                return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);

            }
        }

    }

    /**
     * @OA\Post(
     *      path="/driver/delete_notification",
     *      operationId="DeleteUserNotification",
     *      tags={"AuthanticationDriver"},
     *      summary="delete driver notification using notification id",
     *      description="delete driver notification using notification id service",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"notification_id"},
     *                     @OA\Property(
     *                     property="notification_id",
     *                     description="deletable notification id",
     *                     type="number",
     *                 )
     *             )
     *         )
     *     ),
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
     *          description="successful operation with status = true along with message"
     *       ),
     *      @OA\Response(response=422, description="notification not found"),
     * )
     */
    public function DeleteUserNotification(Request $request)
    {
        $request->validate( [
            'notification_id' => 'required|exists:users_notifications,id',
        ]);
        if ($not = UserNotification::find($request->notification_id)) {

            $not->delete();
            return ControllersService::generateArraySuccessResponse(null, 'notification_deleted');

        }
        return ControllersService::generateGeneralResponse(false, 'notifications_not_found', null, 422);


    }
}
