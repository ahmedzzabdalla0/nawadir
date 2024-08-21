<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\DeviceKey
 *
 * @property int $id
 * @property string|null $d_key
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey whereDKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeviceKey whereUserId($value)
 * @mixin \Eloquent
 */
class DriverLocation extends Model
{
    protected $table='driver_locations';

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
}
