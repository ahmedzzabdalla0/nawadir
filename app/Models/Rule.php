<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Rule
 *
 * @property int $id
 * @property string $nameAr
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminRule[] $AdminRule
 * @property-read int|null $admin_rule_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rule whereNameAr($value)
 * @mixin \Eloquent
 */
class Rule extends Model
{
    protected $table ='rules';
    public $timestamps=false;

    public function AdminRule(){
        return $this->hasMany(AdminRule::class,'rule_id');
    }
}
