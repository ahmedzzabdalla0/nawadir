<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserBalanceAdd
 *
 * @property int $id
 * @property int $user_id
 * @property int $transaction_id
 * @property int $payment_type
 * @property float $amount
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PaymentType $paymentType
 * @property-read \App\Models\Transaction $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBalanceAdd whereUserId($value)
 * @mixin \Eloquent
 */
class UserBalanceAdd extends Model
{
    protected $table = 'user_balance_add';
    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }
}
