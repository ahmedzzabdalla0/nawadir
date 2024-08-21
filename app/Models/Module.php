<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\Module
 *
 * @property int $id
 * @property string $name
 * @property string|null $nameAr
 * @property int $can1
 * @property int $can2
 * @property int $can3
 * @property int $can4
 * @property int $can5
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminRule[] $AdminModule
 * @property-read int|null $admin_module_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereCan1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereCan2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereCan3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereCan4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereCan5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Module whereNameAr($value)
 * @mixin \Eloquent
 */
class Module extends Model
{
    protected $table='modules';
    public $timestamps=false;
    public function AdminModule(){
        return $this->hasMany(AdminRule::class,'module_id');
    }
}
