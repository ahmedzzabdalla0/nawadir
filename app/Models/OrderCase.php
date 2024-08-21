<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderCase
 *
 * @property int $id
 * @property int $order_id
 * @property int $case_id
 * @property int $admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CaseGeneral $case
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase whereCaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderCase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderCase extends Model
{
    protected $table='order_cases';
    protected $with=['case'];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseGeneral::class,'case_id');
    }

}
