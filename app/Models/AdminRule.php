<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdminRule
 *
 * @property int $id
 * @property int $admin_id
 * @property int $rule_id
 * @property int $module_id
 * @property-read \App\Models\Admin $Admin
 * @property-read \App\Models\Module $Module
 * @property-read \App\Models\Rule $Rule
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminRule whereRuleId($value)
 * @mixin \Eloquent
 */
class AdminRule extends Model
{
    protected $table ='admin_rules';
    public $timestamps=false;
    public function Admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function Rule(){
        return $this->belongsTo(Rule::class,'rule_id');
    }
    public function Module(){
        return $this->belongsTo(Module::class,'module_id');
    }
}
