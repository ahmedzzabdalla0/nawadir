<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Matcher\Not;


/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property int $user_id
 * @property int $key_id
 * @property int $notification_id
 * @property int $global_id
 * @property string $data
 * @property string $firebase_response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $message
 * @property-read mixed $title
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereFirebaseResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserNotification whereUserId($value)
 * @mixin \Eloquent
 */
class UserNotification extends Model
{
    protected $table='users_notifications';
    protected $hidden=['created_at','updated_at','notification_id','global_id','firebase_response','global_not'];
    protected $appends=['title','message','created_text','order_id'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function globalNot()
    {
        return $this->belongsTo(GlobalNotification::class,'global_id');
    }
    public function notificationText()
    {
        return $this->belongsTo(Not::class,'notification_id');
    }

    public function getDataAttribute()
    {
        $d=$this->attributes['data'];
        return json_decode($d);
    }
    public function getCreatedTextAttribute()
    {
        $d=$this->attributes['created_at'];
        return $d?Carbon::parse($d)->format('Y/m/d , h:i A'):'';
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }
    public function getOrderIdAttribute($value)
    {
        $d = $this->data && isset($this->data->order_id)?sprintf("#%06d", $this->data->order_id):null;
        return $d;
    }
    public function getTitleAttribute()
    {
        if($this->globalNot){
            return $this->globalNot->title;
        }else{
            $t=NotificationText::find($this->notification_id);
            $tt='title_'.\App::getLocale();
            $text=$t->$tt;
            return $text;
        }


    }
    public function getMessageAttribute()
    {
        if($this->globalNot){
            return $this->globalNot->message;
        }else{
        $t=NotificationText::find($this->notification_id);
        $tt='message_'.\App::getLocale();
        $text=$t->$tt;
        foreach ($this->data as $key=>$value){
            $text=str_replace(':'.$key, $value, $text);
        }
        return $text;
        }
    }

}
