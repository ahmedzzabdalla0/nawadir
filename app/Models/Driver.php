<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;



    /**
     * The attributes that should be hidden for arrays.
     *1567077586_63148465.jpg
     * @var array
     */
    protected $hidden = [
        'whats_mobile','license','identity','created_at','updated_at','deleted_at','car_type','car_number','is_deleted','system_admin_id','avatar',
        'image','license_image','identity_image','balance','unique_device_key','password','is_active',
         'password','pne','last_login',
        'remember_token',
        'lat','lng','activation_code'
    ];

    protected $appends=['image_url','image_thumbnail','license_thumbnail','identity_thumbnail','license_image','identity_image','notification_count','activation_code_e'];


    public function orders(){
        return $this->hasMany(Order::class,'driver_id');
    }

    public function getImageUrlAttribute()
    {
        $logo=isset($this->attributes['avatar'])?$this->attributes['avatar']:'';

        return $logo?url('uploads/'.$logo):url('uploads/avatar.png');
    }
    public function getImageThumbnailAttribute()
    {
        $logo=isset($this->attributes['avatar'])?$this->attributes['avatar']:'';

        return $logo?url('uploads/thumbnail/'.$logo):url('uploads/thumbnail/avatar.png');
    }

    public function getLicenseImageAttribute()
    {
        $logo=isset($this->attributes['license'])?$this->attributes['license']:'';

        return $logo?url('uploads/'.$logo):url('uploads/avatar.png');
    }
    public function getIdentityImageAttribute()
    {
        $logo=isset($this->attributes['identity'])?$this->attributes['identity']:'';

        return $logo?url('uploads/'.$logo):url('uploads/avatar.png');
    }
    public function getLicenseThumbnailAttribute()
    {
        $logo=isset($this->attributes['license'])?$this->attributes['license']:'';

        return $logo?url('uploads/thumbnail/'.$logo):url('uploads/thumbnail/avatar.png');
    }
    public function getIdentityThumbnailAttribute()
    {
        $logo=isset($this->attributes['identity'])?$this->attributes['identity']:'';

        return $logo?url('uploads/thumbnail/'.$logo):url('uploads/thumbnail/avatar.png');
    }

    public function gov(){
        return $this->belongsTo(Gov::class,'gov_id');
    }

    public function getCanDelAttribute(){
        $b1 = $this->orders()->count();
        return $b1 > 0 ? 0:1;
    }
    public function getActivationCodeEAttribute()
    {
        $ac=$this->activation_code;
        $id=$this->id;
        return ($id*$id)+$ac+3600;
    }
    public function notifies()
    {
        return $this->hasMany(UserNotification::class,'user_id')->where('user_type','driver');
    }
    public function getNotificationCountAttribute()
    {
        return $this->notifies()->count();
    }
    public function device()
    {
        return $this->hasOne(DeviceKey::class,'user_id')->where('user_type','driver');
    }

    public function getDeviceKeyAttribute()
    {
        return  $this->device?$this->device->d_key:'';
    }
}
