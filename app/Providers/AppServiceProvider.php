<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use App\Models\Settings;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
        Carbon::setLocale('ar');

        Schema::defaultStringLength(191);


        Blade::directive('old', function ($name,$def='') {
            return '<?php

                  echo old('.$name.' ,"'.$def.'");


                 ?>';
        });
        Blade::directive('cando',function($text){
            return '<?php

                  if(\Auth::guard("system_admin")->user()->hasRole('.$text.')):

                 ?>';
        });
        Blade::directive('elsecando', function () {
            return '<?php else: ?>';
        });
        Blade::directive('endcando', function () {
            return '<?php endif ?>';
        });
        Blade::directive('show_error', function ($name='',$bag='') {

            if($bag){
                return '
            <?php


                if ($errors->'.$bag.'->has('.$name.')){
                    echo \'<span class="help-block has-error"> <strong>\'.$errors->'.$bag.'->first('.$name.').\'</strong></span>\'  ;
                }


            ?>';

            }else{
                return '
            <?php


                if ($errors->has('.$name.')){
                    echo \'<span class="help-block has-error"> <strong>\'.$errors->first('.$name.').\'</strong></span>\'  ;
                }


            ?>';
            }


        });
        Blade::directive('has_error', function ($name='',$bag='') {
            if($bag){
                return '
            <?php

                if ($errors->'.$bag.'->has('.$name.')){
                   echo "has_error"  ;
                }
            ?>';

            }else{

                return '
            <?php


                if ($errors->has('.$name.')){
                    echo "has_error"  ;
                }


            ?>';
            }

        });


        Blade::include('components.input', 'input');
        Blade::include('components.area', 'area');
        Blade::include('components.area_editor', 'area_editor');
        Blade::include('components.multiupload_create', 'multiupload_create');
        Blade::include('components.multiupload_update', 'multiupload_update');
        Blade::include('components.select', 'select');
        Blade::include('components.selectArr', 'selectArr');
        Blade::include('components.switch', 'switch');
        Blade::include('components.upload_image', 'upload');

        $conf=Settings::all();
        $config=[];
        foreach ($conf as $c){
            $config[$c->name]=$c->value;
        }
        View::share('config', $config);

    }

}
