<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\UserFavorite
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserFavorite whereUserId($value)
 * @mixin \Eloquent
 */
class UserFavorite extends Model
{
    protected $table='favorites';


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
//    public function travel()
//    {
//        return $this->belongsTo(Travel::class,'travel_id');
//    }
}
