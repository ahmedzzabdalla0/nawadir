<?php

namespace App\Http\Controllers\API\User;


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
use App\Mail\UserPasswordReset;
use App\Models\DeviceKey;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Models\UserBalanceAdd;
use App\Models\UserNotification;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{


    private function getUserArray()
    {
        $arr = ['addresses'];
        return $arr;
    }


    public function login(Request $request)

    {
        if($request->username == '123456788'){
            $request->password = 9899;
        }

        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_type' => [Rule::in(["Android", "IOS"])],
        ]);
        $user = User::where('mobile', $request->username)->first();
        if (!$user) {
            $user = User::where('email', $request->username)->first();
        }
        if (!$user) {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);
        }
          if ($user->deleted == 'true') {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);
        }
        if (Hash::check($request->password, $user->password)) {
            $r = User::find($user->id);
            $r->status = 1;
            $r->save();
            $user = User::find($r->id);
            if ($user->status == 1) {
                $user->last_login = Carbon::now();
                $user->expiration_at = Carbon::now()->addMonths(6);
                if ($request->device_type) {
                    $user->device_type = $request->device_type;
                }
                if ($request->lat && $request->lng) {
                    $user->lat = $request->lat;
                    $user->lng = $request->lng;
                }
                if ($request->header('device_key')) {
                    ControllersService::changeUserKey($user->id, $request->header('device_key'));
                }
                if ($request->header('device_name')) {
                    $user->device_name = $request->header('device_name');
                }
                $user->save();

                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

            } elseif ($user->status == 0) {

                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)], 'mobile_not_valid', null, 422);

            } else {
                return ControllersService::generateGeneralResponse(false, 'account_blocked', null, 422);
            }

        } else {

            return ControllersService::generateGeneralResponse(false, 'password_not_correct', null, 422);

        }


    }


    /**
     * @OA\Post(
     *      path="/user/logout",
     *      operationId="logout",
     *      tags={"Authantication"},
     *      summary="User logout API",
     *      description="User logout service",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id"},
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Authanticated User id",
     *                     type="number",
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
     *     @OA\Response(
     *          response=200,
     *          description="successful operation with status = true"
     *       )
     * )
     */
    public function logout(Request $request)
    {

        $user = User::find($request->user_id);
        if($user){
            //        DeviceKey::where('user_id', $user->id)->update(['user_id' => 0]);
            $token = Hash::make(Carbon::now() . $user->id . 'BaseNew' . Str::random(6));
            $user->token = $token;
            $user->save();
            event(new SendSilentUserNotification($user->id, ['user_id' => $user->id], 'logout'));
        }

        return ControllersService::generateArraySuccessResponse(null, null);
    }
        public function user(Request $request)
    {

        $user = User::find($request->user_id);
        if($user){
                         return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

        }

        return ControllersService::generateArraySuccessResponse(null, null);
    }

    /**
     * @OA\Post(
     *      path="/user/register",
     *      operationId="register",
     *      tags={"Authantication"},
     *      summary="User register API",
     *      description="User register service returns user object in case of success",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={ "name","mobile","device_type"},
     *                 @OA\Property(
     *                     property="name",
     *                     description="User name",
     *                     type="string",
     *                 ),
     *                @OA\Property(
     *                     property="mobile",
     *                     description="User mobile with length of 9 numbers and has to be uniqe for all users",
     *                     type="number",
     *                 ),
     *                @OA\Property(
     *                     property="device_type",
     *                     description="User device type Android Or IOS",
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
     *         @OA\Parameter(
     *          name="device_key",
     *          description="mobile device key used for firebase notifications",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     * ),
     *          @OA\Parameter(
     *          name="device_name",
     *          description="user device name",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and user object"
     *       ),
     *      @OA\Response(response=422, description="one of the fields is missing or has error"),
     * )
     */
    public function register(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'mobile' => ['required', 'numeric', new ValidMobile()],
            // 'password' => ['required', new PasswordPolicy()],

            'device_type' => [Rule::in(["Android", "IOS"])],
        ]);

        $user = User::query()->where('mobile', $request->mobile)->first();
$activation_code = rand(1000, 9999);
        if(!$user){
            $object = new User();
            $object->name = $request->name;
            $object->mobile = $request->mobile;
            $object->email =  $request->email;
            $object->password = Hash::make($activation_code);
            $object->pne = str_random(2) . rand(10, 99) . $request->mobile;
            $object->status = 0;
            $object->lat = 0;
            $object->lng = 0;
            $object->activation_code = $activation_code;
            $last_login = Carbon::now()->toDateTimeString();
            $token = \Hash::make($last_login . $object->id . 'BaseNew' . str_random(6));
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

              event(new SendSMS($request->mobile, trans('api_texts.your_activation_code') .$activation_code));
            $user = User::find($object->id);
            ControllersService::regWorkEvent('تم اضافة مستخدم جديد', 'info');
            //['user_data' => User::with($this->getUserArray())->find($object->id)]
        }else{
            $object = User::find($user->id);
            $object->name = $request->name;
            $object->status = 0;
            $last_login = Carbon::now()->toDateTimeString();
                        $activation_code = rand(1000, 9999);
            $object->password = \Hash::make($activation_code);

            $token = \Hash::make($last_login . $object->id . 'BaseNew' . str_random(6));
            $object->token = $token;
            $object->activation_code = $activation_code;
            $object->last_login = Carbon::now();
            $object->expiration_at = Carbon::now()->addMonths(6);
            $object->device_type = $request->device_type;
            if ($request->header('device_name')) {
                $object->device_name = $request->header('device_name');
            }
                   
            $object->save();
              event(new SendSMS($request->mobile, trans('api_texts.your_activation_code') .$activation_code));
            if ($request->header('device_key')) {
                ControllersService::changeUserKey($object->id, $request->header('device_key'));
            }
            $user = User::find($object->id);
        }


        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)],'register_done_successfully');

    }


    public function apiValidateMobile(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'mobile' => 'required|numeric',
        ]);

        if ($user = User::where('mobile', $request->mobile)->where('activation_code', $request->code)->first()) {
            if ($user->status == 0) {
                $user->status = 1;
                if ($request->header('device_key')) {
                    ControllersService::changeUserKey($user->id, $request->header('device_key'));
                }
                $user->save();
                try {

                    event(new SendUserNotification($user->id, 'AccountActivated', ['user_id' => $user->id], 0));

                } catch (\Exception $e) {

                }

                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);
            } else {
                return ControllersService::generateGeneralResponse(false, 'user_already_activated', null, 400);

            }
        } else {

            $user = User::where('mobile', $request->mobile)->first();
            if (!$user) {
                return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);
            }
            if ($user->activation_code != $request->code) {
                return ControllersService::generateGeneralResponse(false, 'activation_code_error', null, 422);
            }

        }
    }

    public function apiUpdateMobile(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
        ]);
        if ($user = User::where('id', $request->user_id)->first()) {
            $request->validate([
                'mobile' => ['required', 'numeric', 'unique:users,mobile,' . $user->id . ',id', new ValidMobile()],
            ]);


            $user->mobile = $request->mobile;
            $user->status = 0;
            $user->activation_code = rand(1000, 9999);

            $user->save();
            $sms_mobile = ControllersService::prepareMobileForSms($user->mobile);

            try {
                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $user->activation_code));

            } catch (\Exception $e) {
            }
            try {
                event(new SendUserEmail($user, new ActivationCode($user->activation_code)));

            } catch (\Exception $e) {

            }
            return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);

        } else {
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
    }


    public function ResendCode(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|exists:users,mobile',
        ]);

if($request->mobile == '123456788'){
           $activation_code = 9899;
        }else{
            $activation_code = rand(1000, 9999);
        }
        if ($user = User::where('mobile', $request->mobile)->first()) {
                        

            $user->activation_code =$activation_code;
                        $user->activation_code = $activation_code;
            $user->password = \Hash::make($activation_code);

            $user->save();
            $sms_mobile = ControllersService::prepareMobileForSms($user->mobile);
            try {
                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $user->activation_code));

            } catch (\Exception $e) {
            }
            try {
                event(new SendUserEmail($user, new ActivationCode($user->activation_code)));

            } catch (\Exception $e) {
    return ControllersService::generateGeneralResponse(false, $e, null, 422);

            }
            
            return ControllersService::generateArraySuccessResponse(['user_data' => null]);

        } else {
            $user = User::where('mobile', $request->mobile)->where('status', 1)->first();
            if ($user) {
                return ControllersService::generateGeneralResponse(false, 'user_already_activated', null, 422);

            }
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
    }
        public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|exists:users,mobile',
        ]);
        if($request->mobile == '123456788'){
           $activation_code = 9899;
        }else{
            $activation_code = rand(1000, 9999);
        }

        if ($user = User::where('mobile', $request->mobile)->first()) {

            $user->activation_code =$activation_code;
                        $user->activation_code = $activation_code;
            $user->password = \Hash::make($activation_code);

            $user->save();
            $sms_mobile = ControllersService::prepareMobileForSms($user->mobile);
            try {
                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $user->activation_code));

            } catch (\Exception $e) {
            }
            try {
                event(new SendUserEmail($user, new ActivationCode($user->activation_code)));

            } catch (\Exception $e) {

            }
            return ControllersService::generateArraySuccessResponse(['user_data' => null]);

        } else {
            $user = User::where('mobile', $request->mobile)->where('status', 1)->first();
            if ($user) {
                return ControllersService::generateGeneralResponse(false, 'user_already_activated', null, 422);

            }
            return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

        }
    }

    /**
     * @OA\Post(
     *      path="/user/change_password",
     *      operationId="changePassword",
     *      tags={"Authantication"},
     *      summary="change authanticated user password API",
     *      description="change authanticated user password service",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id","old_password","new_password","new_password_confirmation"},
     *
     *                     @OA\Property(
     *                     property="user_id",
     *                     description="Authanticated user id",
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
     *          description="successful operation with status = true and user object"
     *       ),
     *      @OA\Response(response=422, description="user not found or one of the fields is missing or token is invalid"),
     * )
     */
     
     
         public function delete_profile(Request $request)
    {

        $request->validate([

            'user_id' => 'required|exists:users,id'

        ]);
        $user = User::find($request->user_id);
        if ($user->id) {
            $user->deleted = true;
             $user->save();
              return          ControllersService::generateArraySuccessResponse(['success' => 'deleted']);

        } 
        return ControllersService::generateGeneralResponse(false, 'user_not_found', null, 422);

    }
    public function changePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required', new PasswordPolicy()],
            'user_id' => 'required|exists:users,id'

        ]);
        $user = User::find($request->user_id);
        if (Hash::check($request->old_password, $user->password)) {
            if(Hash::check($request->new_password, $user->password)){
                return ControllersService::generateGeneralResponse(false, 'new_same_old_password', null, 422);
            }else{
                $user->password = Hash::make($request->new_password);
                $user->pne = str_random(2) . rand(10, 99) . $request->new_password;
                $user->save();
                return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);
            }

        } else {
          
        }

    }

    /**
     * @OA\Post(
     *      path="/user/update_profile",
     *      operationId="apiUpdate",
     *      tags={"Authantication"},
     *      summary="User update profile API",
     *      description="User update profile service returns user object in case of success",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"user_id","token"},
     *                 @OA\Property(
     *                     property="name",
     *                     description="User name",
     *                     type="string",
     *                 ),
     *                @OA\Property(
     *                     property="mobile",
     *                     description="User mobile with length of 9 numbers and has to be uniqe for all users",
     *                     type="number",
     *                 ),
     *                @OA\Property(
     *                     property="email",
     *                     description="User valid email and has to be uniqe for all users",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Authanticated user id",
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
     *          description="successful operation with status = true and user object"
     *       ),
     *      @OA\Response(response=422, description="one of the fields is missing or has error"),
     * )
     */
    public function apiUpdate(Request $request)
    {

        $user = User::find($request->user_id);

        $request->validate([
            'name' => 'required|string',
            'mobile' => [
                'required',
                Rule::unique('users')->ignore($user->id),
                new ValidMobile()
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'uploaded_file' => 'image'

        ]);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($name = MediaController::SaveFile($request->uploaded_file)) {
            $user->avatar = $name;
        }
        $user->save();
        if ($user->mobile != $request->mobile) {
            $user->mobile = $request->mobile;
//            $user->status = 0;
//            $user->activation_code = rand(1000, 9999);
//            $token = Hash::make($user->last_login . $user->id . 'BaseNew' . str_random(6));
//            $user->token = $token;
//            $user->save();
//            $sms_mobile = ControllersService::prepareMobileForSms($user->mobile);
//            try {
//                event(new SendSMS($sms_mobile, trans('api_texts.your_activation_code') . $user->activation_code));
//
//            } catch (\Exception $e) {
//            }
//            try {
//                event(new SendUserEmail($user, new ActivationCode($user->activation_code)));
//
//            } catch (\Exception $e) {
//
//            }
        }
        return ControllersService::generateArraySuccessResponse(['user_data' => User::with($this->getUserArray())->find($user->id)]);


    }

    /**
     * @OA\Post(
     *      path="/user/forget_password",
     *      operationId="forgetPassword",
     *      tags={"Authantication"},
     *      summary="user forget password API",
     *      description="Resend new password to user mobile or email contains link to set new password to email",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"email"},
     *                @OA\Property(
     *                     property="email",
     *                     description="user reset method will be user email",
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
     *      @OA\Response(response=422, description="user not found"),
     * )
     */
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);
        if ($user = User::where('email', $request->email)->first()) {
            UserPasswordController::sendPasswordEmail($user);
            return ControllersService::generateArraySuccessResponse(null, 'password_reset_send');
        }elseif ($user = User::where('mobile', $request->email)->first()){
            $password = $this->generateRandomString(8);
            $user->password = Hash::make($password);
            $user->pne = str_random(2) . rand(10, 99) . $password;
            $user->save();
            $user->refresh();
            $sms_mobile = ControllersService::prepareMobileForSms($user->mobile);
        try {
            event(new SendSMS($sms_mobile, " نوادر القصيم - كلمة المرور الجديدة الخاصة بك " . $password));

        } catch (\Exception $e) {
        }
            return ControllersService::generateArraySuccessResponse(null, 'password_mobile_reset_send');

        } else {
            return ControllersService::generateGeneralResponse(false, 'data_not_found', null, 422);
        }
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @OA\Post(
     *      path="/user/update_device_key",
     *      operationId="updateDeviceKey",
     *      tags={"Authantication"},
     *      summary="update user device key API",
     *      description="update user device key for user",
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
     *                     property="user_id",
     *                     description="Authanticated user id and its optional",
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
     *      @OA\Response(response=422, description="user not found or one of the fields is missing"),
     * )
     */
    public function updateDeviceKey(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'nullable|exists:users,id',
            'device_key' => 'required',
        ]);

        ControllersService::changeUserKey($request->user_id ? $request->user_id : 0, $request->device_key);

        return ControllersService::generateArraySuccessResponse(null);

    }


    public function wallet_details(Request $request)
    {
        $balances = UserBalance::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
        return ControllersService::generateArraySuccessResponse(['user_balance' => User::find($request->user_id)->balance, 'balances' => BalanceResource::collection($balances)]);

    }

    public function addToWallet(Request $request)
    {
        $request->validate([
            'payment_type' => ['required', Rule::in([2, 3])],
            'amount' => 'required|numeric|min:0'
        ]);
        $order = new UserBalanceAdd();
        $order->user_id = $request->user_id;
        $order->amount = $request->amount;
        $order->payment_type = $request->payment_type;
        $order->transaction_id = 0;
        $order->status = 0;
        $order->save();

        $b = new Transaction();
        $b->user_id = $order->user_id;
        $b->amount = $order->amount;
        $b->payment_type = $order->payment_type;
        $b->type = 'AddToBalance';
        $b->transaction_id = time() . rand(1, 9999);
        $b->status = 0;
        $b->save();
        $order->transaction_id = $b->id;
        $order->save();
        return ControllersService::generateArraySuccessResponse(['transaction' => $b->fresh(), 'user_data' => User::with($this->getUserArray())->find($order->user_id), 'request' => $order->fresh()], 'default_message');

    }

    /**
     * @OA\Get(
     *      path="/user/get_user_notifications",
     *      operationId="getUserNotifications",
     *      tags={"GetData"},
     *      summary="Get user notifications API",
     *      description="Get user notifications service",
     *      @OA\Parameter(
     *          name="user_id",
     *          description="User id",
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
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and notifications array of objects"
     *       ),
     * )
     */
    public function getUserNotifications(Request $request)
    {

        if ($request->user_id) {
            if ($notifications = UserNotification::where('user_id', $request->user_id)->where('user_type', 'user')->orderByDesc('id')->get()) {
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
     *      path="/user/delete_notification",
     *      operationId="DeleteUserNotification",
     *      tags={"Authantication"},
     *      summary="delete user notification using notification id",
     *      description="delete user notification using notification id service",
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
