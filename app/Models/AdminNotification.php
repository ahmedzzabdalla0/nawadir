<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\AdminNotification
 *
 * @property int $id
 * @property string $text
 * @property int $seen
 * @property string $channel
 * @property string $event
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminNotification extends Model
{
    protected $table='admin_notifications';
    protected $hidden=['created_at','updated_at'];
    protected $fillable=['seen','title'];

    public function getDataAttribute()
    {
        $d=$this->attributes['data'];
        return json_decode($d);
    }
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }
}
