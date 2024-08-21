<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminRule[] $Rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
 * @mixin \Eloquent
 */
class Admin extends Model{
    protected $table = 'admin';


    public function Rules(){
        return $this->hasMany(AdminRule::class,'admin_id');
    }

}
