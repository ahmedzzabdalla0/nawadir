<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Rules\MinDate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ClosureController extends Controller
{

    public function migrate()
    {
        Artisan::call('migrate');
    }
    public function generate_models()
    {
        print `php /home/nugjzyiw/public_html/baseProject/artisan ide-helper:models -R -W`;

//        Artisan::call('ide-helper:models -R -W');
//        Artisan::call('ide-helper:meta');
    }

    public function clearView()
    {

//        print `php /home/nugjzyiw/public_html/baseProject/artisan config:clear  -n -q`;
        $base=base_path();


        print `php $base/artisan clear-compiled`;
        echo "<br>";
        print `php $base/artisan view:clear`;
        echo "<br>";
        print `php $base/artisan route:clear`;
        echo "<br>";
        print `php $base/artisan config:clear`;
        print `php $base/artisan cache:clear`;
        echo "<br>";
        print `php $base/artisan config:cache`;
    }
    public function changeKey()
    {
        $base=base_path();
        print `php $base/artisan key:generate -n -q`;
        print `php $base/artisan config:cache  -n -q`;

    }
    public function PrepareProductionO()
    {


        $exitCode = Artisan::call('route:cache');
        echo "<h1>Cache Route value Setted ($exitCode)</h1>";
        $exitCode = Artisan::call('view:cache');
        echo "<h1>Cache View value Setted ($exitCode)</h1>";
        $exitCode = Artisan::call('config:cache');
        echo "<h1>Cache Config value Setted ($exitCode)</h1>";
    }

    public function ChangeToProduction()
    {
        $base=base_path();
        print `php $base/artisan clear-compiled `;
        echo "<br>";
        print `php $base/artisan env:set APP_ENV=production `;
        echo "<br>";
        print `php $base/artisan env:set APP_DEBUG=false`;
        echo "<br>";
        print `php $base/artisan optimize`;
        echo "<br>";
        print `php $base/artisan view:cache`;
        echo "<br>";
        print `php $base/artisan event:cache`;
        echo "<br>";

//        print `php /home/nugjzyiw/public_html/baseProject/artisan config:cache  -n -q`;
//        print `php /home/nugjzyiw/public_html/baseProject/artisan route:cache  -n -q`;
    }
    public function ChangeToDevelopment()
    {
        $base=base_path();

        print `php $base/artisan clear-compiled `;
        echo "<br>";
        print `php $base/artisan env:set APP_ENV=local`;
        echo "<br>";
        print `php $base/artisan env:set APP_DEBUG=true`;
        echo "<br>";
        print `php $base/artisan optimize:clear`;
        echo "<br>";
        print `php $base/artisan event:clear`;
        echo "<br>";
        print `php $base/artisan config:cache`;
        echo "<br>";
//        print `php /home/nugjzyiw/public_html/baseProject/artisan config:clear  -n -q`;
//        print `php /home/nugjzyiw/public_html/baseProject/artisan view:clear  -n -q`;
//        print `php /home/nugjzyiw/public_html/baseProject/artisan route:clear  -n -q`;




    }
    public function KillPrcc()
    {
        //    print `ps -A`;
//    print `kill -9 28625`;
    }


    public function down()
    {
        echo 'API DOWN';
        die();
    }


}
