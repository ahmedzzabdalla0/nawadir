<?php

namespace App;


use App\Models\DeviceKey;
use App\Models\Order;
use App\Models\UserAddress;
use App\Models\UserBalance;
use App\Models\UserNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $mobile
 * @property string $password
 * @property string $pne
 * @property int $status
 * @property string|null $avatar
 * @property string|null $activation_code
 * @property string $token
 * @property string|null $last_login
 * @property string|null $remember_token
 * @property int $see_notifications
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $balance
 * @property float|null $lat
 * @property float|null $lng
 * @property string|null $device_name
 * @property string|null $device_type
 * @property string|null $expiration_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserBalance[] $balances
 * @property-read int|null $balances_count
 * @property-read \App\Models\DeviceKey $device
 * @property-read mixed $activation_code_e
 * @property-read mixed $device_key
 * @property-read mixed $image
 * @property-read mixed $image_thumbnail
 * @property-read mixed $neg_balance
 * @property-read mixed $notification_count
 * @property-read mixed $pos_balance
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserNotification[] $notifies
 * @property-read int|null $notifies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActivationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereExpirationAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSeeNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','pne','last_login',
        'remember_token','login_times','avatar',
        'updated_at','lat','lng'
    ];
    //'activation_code', 'created_at',
    protected $appends=['notification_count','image','image_thumbnail','activation_code_e'];

    public static $getRoles = ['id' => 'required|exists:users|integer'];
    public static $validateMobileRoles = ['id' => 'required|exists:users|integer',
        'mobile_number' => 'required|numeric|unique:users|digits:12',];

    public static $createCustomerRoles = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'mobile' => 'required|string|unique:users,mobile',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:5',
        "country_id" => "required|exists:countries,id|integer",


    ];

    public static $updateCustomerRoles = [
        'id' => 'required|exists:users|integer',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'mobile' => 'required|string',
        'email' => 'required|email',

        "country_id" => "required|exists:countries,id|integer",


    ];

    public static $updateCustomerPassRoles = [

        'id' => 'required|exists:users|integer',
        'old_pass' => 'required|min:5',
        'new_pass'         => 'required|min:5',
        'new_pass_confirm' => 'required|same:new_pass'

    ];

    public static function getApiUpdateRoles($id)
    {
        return $apiUpdateRoles = [
            'id' => 'required|exists:users|integer',
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'required|numeric|unique:users,mobile_number,' . $id . '|digits:12',
            'birth_date' => 'required|date'
        ];
    }

    public static $activationRoles = [
        'id' => 'required|exists:users|integer',
        'code' => 'required|numeric|digits:6'
    ];

    public static $passwordResetRoles = [
        'mobile_number' => 'required|numeric|digits:12',
        'code' => 'required|numeric|digits:6',
        'password' => 'required|string|min:5',
    ];

    public static $changeStatusRoles = [
        'id' => 'required|exists:users|integer',
    ];

    public function getImageAttribute()
    {
        $logo=isset($this->attributes['avatar'])?$this->attributes['avatar']:'';

        return $logo?asset('uploads/'.$logo):asset('uploads/avatar.png');
    }
    public function getImageThumbnailAttribute()
    {
        $logo=isset($this->attributes['avatar'])?$this->attributes['avatar']:'';

        return $logo?asset('uploads/'.$logo):asset('uploads/avatar.png');
    }
    public function getActivationCodeEAttribute()
    {
        $ac=$this->activation_code;
        $id=$this->id;
        return ($id*$id)+$ac+3600;
    }
    public function notifies()
    {
        return $this->hasMany(UserNotification::class)->where('user_type','user');
    }
    public function getNotificationCountAttribute()
    {
        return $this->notifies()->count();
    }
    public function addresses()
    {
        return $this->hasMany(UserAddress::class,'user_id')->where('saved',1);
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }
    public function getCanDelAttribute(){
        $b = $this->orders()->count();
        return $b > 0?0:1;
    }
    public function balances()
    {
        return $this->hasMany(UserBalance::class,'user_id');
    }
    public function device()
    {
        return $this->hasOne(DeviceKey::class,'user_id')->where('user_type','user');
    }

    public function getDeviceKeyAttribute()
    {
        return  $this->device?$this->device->d_key:'';
    }
    public function getPosBalanceAttribute()
    {
        $id = $this->attributes['id'];
        $balances = UserBalance::where('user_id', $id)->where('amount','>', 0)->sum('amount');
        return  round($balances,2);
    }

    public function getNegBalanceAttribute()
    {
        $id = $this->attributes['id'];
        $balances = UserBalance::where('user_id', $id)->where('amount','<', 0)->sum('amount');

        return  round($balances,2);
    }

    public function getBalanceAttribute()
    {
        $id = $this->attributes['id'];
        $balances = UserBalance::where('user_id', $id)->sum('amount');
        return round($balances,2);
    }


}
