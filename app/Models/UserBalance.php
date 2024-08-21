<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\UserBalance
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $order_id
 * @property float $amount
 * @property int|null $type_id
 * @property string $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\BalanceType|null $Btype
 * @property-read mixed $is_alone
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalance whereUserId($value)
 * @mixin \Eloquent
 */
class UserBalance extends Model
{
    protected $table='user_balances';
    protected $hidden=['created_at','updated_at'];

    public function Btype()
    {
        return $this->belongsTo(BalanceType::class,'type_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }
    public function getIsAloneAttribute()
    {
        $id = $this->attributes['order_id'];
        $b = UserBalance::where('user_id', $this->attributes['user_id'])->where('order_id', $id)->count();

        return $b;
    }


}
