<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\NotificationText
 *
 * @property int $id
 * @property string $notification_key
 * @property string $title_ar
 * @property string $title_en
 * @property string $message_ar
 * @property string $message_en
 * @property string $data_to_send
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\UserNotification $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereDataToSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereMessageAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereMessageEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereNotificationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationText whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationText extends Model
{
    protected $table='notifications_texts';
    protected $hidden=['created_at','updated_at'];

    protected $fillable=[
        'title_ar',
        'message_ar',
        'title_en',
        'message_en',
        'notification_key',
        'data_to_send'
    ];

    public function notifications()
    {
        return $this->belongsTo(UserNotification::class,'notification_id');
    }
    public function getDataToSendAttribute()
    {
        $d=str_replace('\"','"',$this->attributes['data_to_send']);
        return json_decode($d);
    }
}
