<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $transaction_id
 * @property string $type
 * @property int $payment_type
 * @property int $user_id
 * @property float $amount
 * @property string $image
 * @property int $status
 * @property string|null $cancel_reson
 * @property string $bank_id
 * @property string $bank_response
 * @property string $bank_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $redirect_url
 * @property-read \App\Models\Order $order
 * @property-read \App\User $user
 * @property-read \App\Models\UserBalance $user_balance
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereBankResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCancelReson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Transaction whereUserId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $table='transactions';
    protected $hidden=['created_at','updated_at','deleted_at','is_balance','is_admin','status'];

    protected $appends=['redirect_url'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class,'transaction_id');
    }
    public function user_balance()
    {
        return $this->hasOne(UserBalance::class,'transaction_id');
    }


//    public function getRedirectUrlAttribute()
//    {
//        if($this->payment_type == 3 || $this->payment_type == 2){
//            return route('hyper.start_transaction',['TID'=>$this->transaction_id]);
//        }
//        return '';
//
//    }
    public function getRedirectUrlAttribute()
    {
        if($this->payment_type == 3 || $this->payment_type == 2){
            return route('payment',['TID'=>$this->transaction_id]);
        }
        return '';
//        if($this->is_knet){
//            return route('payment',['TID'=>$this->transaction_id]);
//        }
//        if($this->is_visa){
//            return route('payment',['TID'=>$this->transaction_id]);
//        }
    }

}
