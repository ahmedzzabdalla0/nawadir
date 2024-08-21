<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GovDivision
 */
class GovDivision extends Model
{
    protected $table='gov_divisions';
    protected $hidden=['created_at','updated_at'];
    use MultiLanguage;
    protected $multi_lang = ['name'];
    protected $with=['areas'];

    public function gov(){
        return $this->belongsTo(Gov::class,'gov_id');
    }
    public function areas()
    {
        return $this->hasMany(Area::class,'gov_division_id');
    }

    public function getCanDelAttribute()
    {
        $b2=$this->areas()->count();
        return $b2 == 0 ? true:false;
    }


}
