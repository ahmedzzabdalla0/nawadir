<?php
namespace App\Traits;

use Illuminate\Support\Facades\App;

trait DeleteImages
{

    public function __construct()
    {
        parent::__construct();
        self::deleting(function ($image) {
            try{
                unlink("./uploads/".$image->image);
                unlink("./uploads/original/".$image->image);
                unlink("./uploads/thumbnail/".$image->image);
            }catch (\Exception $e){}
            return true;
        });

    }

    /**
     * @param string $key
     * @return mixed
     */


}