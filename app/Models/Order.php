<?php
namespace App\Models;

use App\User;
use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $mobile
 * @property float $total_price
 * @property int $case_id
 * @property string|null $cancel_reson
 * @property int $address_id
 * @property int $tax_ratio
 * @property float $tax_price
 * @property int $payment_type
 * @property int $transaction_id
 * @property int $is_paid
 * @property float $products_price
 * @property float $delivery_price
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\UserAddress $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserBalance[] $balances
 * @property-read int|null $balances_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderCase[] $cases
 * @property-read int|null $cases_count
 * @property-read mixed $created_text
 * @property-read mixed $nameid
 * @property-read \App\Models\PaymentType $paymentType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderProduct[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\CaseGeneral $status
 * @property-read \App\Models\Transaction $transaction
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order accepted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order canceled()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order done()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order new()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order notPaid()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order onDelivery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCancelReson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereProductsPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTaxRatio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Eloquent{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'orders';
    protected $dates = ['deleted_at'];
    protected $appends=['created_text','order_number'];
    protected $hidden=['updated_at','deleted_at'];

    public function scopePaid($query)
    {
        return $query->where(function($q){
            $q->where('is_paid', 1)
                ->orWhereIn('payment_type', [1,5,4,6]);
        });
    }
    public function scopeNotPaid($query)
    {
        return $query->where('status_id',1);
    }
    public function scopeNew($query)
    {
        return $query->where('status_id',2);
    }
    public function scopeAccepted($query)
    {
        return $query->where('case_id',3);
    }
    public function scopeOnDelivery($query)
    {
        return $query->where('case_id',4);
    }
    public function scopeDone($query)
    {
        return $query->where('case_id',5);
    }

    public function scopeCanceled($query)
    {
        return $query->where('case_id',6);
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }





    public function status()
    {
        return $this->belongsTo(CaseGeneral::class,'case_id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }
    public function cases()
    {
        return $this->hasMany(OrderCase::class,'order_id');
    }
    public function address()
    {
        return $this->belongsTo(UserAddress::class,'address_id');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class,'payment_type');
    }




    public function products(){
        return $this->hasMany(OrderProduct::class,'order_id');
    }
    public function balances(){
        return $this->hasMany(UserBalance::class,'order_id');
    }

    public function getCreatedTextAttribute()
    {
        $old=$this->attributes['created_at'];
        return Carbon::parse($old)->locale('ar')->diffForHumans();
    }

    public function getNameidAttribute()
    {

        return "طلب رقم #".$this->id;
    }
    public function getOrderNumberAttribute()
    {
        $id = $this->attributes['id'];
        $formated_number = sprintf("#%06d", $id);
        return $formated_number;
    }



}
