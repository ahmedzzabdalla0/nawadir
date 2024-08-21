<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;

class MYHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function send_sms($mobile, $text)
    {
//        $mobile=str_replace_first('05','9725',$mobile);
//        $mobile=str_replace_first('05','9665',$mobile);
        $messgmobile = urlencode($text);
//        $url = "http://www.hotsms.ps/sendbulksms.php?user_name=selsela&user_pass=2506023&text=".$messgmobile."&mobile=".$mobile."&sender=selsela&type=2" ;

           $url = "https://REST.GATEWAY.SA/api/SendSMS?api_id=API69985827457&api_password=dCMw54YWy1&template_id=1193&sms_type=O&encoding=T&sender_id=nwader.sa&phonenumber=".$mobile."&textmessage=".$messgmobile."&uid=SAU69940827576&callback_url=https://nwader.sa/&V1=".$messgmobile;
        // if(substr($mobile,0,3) == '965'){
        //     $url = "https://rest.nexmo.com/sms/json?api_key=dc1122b2&api_secret=bhdA74hPc0gGP3hR&text=".$messgmobile."&to=".$mobile."&from=Nexmo&type=unicode" ;

        // }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        return curl_exec($ch);
    }
    public static function set_active($path)
    {
//        if (request()->is("admin/system/$path*")) {
//            return '  m-menu__item--active ';
//        }else{
//            return '';
//        }
        $currentRoute=\Illuminate\Support\Facades\Route::current()->getPrefix();
        $name=route($path);
        if(url($currentRoute) == $name){
            return '  m-menu__item--active ';
        }
        return '';
    }
    public static function set_if(&$var, $ret = '', $prefix = '')
    {
        if (isset($var)) {
            return $prefix . $var;
        } else {
            return $ret;
        }
    }
    public static function deleteTEMP(){
//        echo 'runned';
        $currentRoute=\Illuminate\Support\Facades\Route::current();
        dd($currentRoute);
        if($_SERVER['REQUEST_URI']){
            $currentMode=$_SERVER['REQUEST_URI'];

            $function_name =$_SERVER['REQUEST_URI'];
            echo $function_name;
            if(str_contains($currentMode,'admin')){
                if(str_contains($function_name,'index')){
                    $temp=session('tempImage');
                    if(is_array($temp))
                        foreach ($temp as $t){
                            try {
                                unlink("./public/uploads/".$t);
                                unlink("./public/uploads/thumbnail/".$t);
                            }catch (\Exception $e){}

                        }
                    session(['tempImage'=>[]]);

                    $temp=session('tempMultiImage');
                    if(is_array($temp))
                        foreach ($temp as $t){
                            try {
                                unlink("./public/uploads/".$t);
                                unlink("./public/uploads/thumbnail/".$t);
                            }catch (\Exception $e){}
                        }
                    session(['tempMultiImage'=>[]]);
                    return true;
                }
            }}


        return true;
    }

    public static function deleteUnUsedFile($image){
        $temp=session('tempImage');
        if(is_array($image)){
            if(is_array($temp))
                foreach ($temp as $t){
                    if(array_search($t,$image) === false){
                        try {
                            unlink("./public/uploads/".$t);
                            unlink("./public/uploads/thumbnail/".$t);
                        }catch (\Exception $e){}
                    }

                }
            session(['tempImage'=>[]]);
            return true;
        }else{
            if(is_array($temp))
                foreach ($temp as $t){
                    if($t != $image){
                        try {
                            unlink("./public/uploads/".$t);
                            unlink("./public/uploads/thumbnail/".$t);
                        }catch (\Exception $e){}
                    }

                }
            session(['tempImage'=>[]]);
            return true;
        }

    }


    public static function deleteUnUsedFiles($images){
        $temp=session('tempMultiImage');
        if(is_array($temp))
            foreach ($temp as $t){
                if(! in_array($t,$images)){
                    try {
                        unlink("./public/uploads/".$t);
                        unlink("./public/uploads/thumbnail/".$t);
                    }catch (\Exception $e){}
                }

            }
        session(['tempMultiImage'=>[]]);
        return true;
    }


    public static function endWith($str, $lastString)
    {
        $count = strlen($lastString);
        if ($count == 0) {
            return true;
        }
        return (substr($str, -$count) === $lastString);
   }

   public static function getImageWidth($url){

       $width = 0;
       try {
           list($width, $height, $type, $attr) = getimagesize(realpath('uploads').'/'.$url);
       }catch (\Exception $e) {
       }
       return $width;
   }
   public static function getImageHeight($url){
       $height = 0;
       try {
           list($width, $height, $type, $attr) = getimagesize(realpath('uploads').'/'.$url);
       }catch (\Exception $e) {
       }

       return $height;
   }

    public static  function float2rat($n, $tolerance = 1.e-6) {
        $h1=1; $h2=0;
        $k1=0; $k2=1;
        $b = 1/$n;
        do {
            $b = 1/$b;
            $a = floor($b);
            $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
            $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
            $b = $b-$a;
        } while (abs($n-$h1/$k1) > $n*$tolerance);

        return "$h1/$k1";
    }



}
