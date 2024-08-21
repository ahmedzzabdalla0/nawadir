<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\GlobalNotification
 *
 * @property int $id
 * @property string $title
 * @property string $message
 * @property int $system_admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification whereSystemAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GlobalNotification extends Model
{
    protected $table='global_notifications';
    protected $hidden=['created_at','updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
