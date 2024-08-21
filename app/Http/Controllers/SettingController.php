<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Bank;
use App\Models\Settings;
use App\Rules\ValidAppleStore;
use App\Rules\ValidFaceBook;
use App\Rules\ValidGooglePlay;
use App\Rules\ValidInstagram;
use App\Rules\ValidMobile;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\Rules\ValidTwitter;
use App\Rules\ValidUrl;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{


    public function index($type='')
    {
        $page=[];
        $conf=Settings::all();
        foreach ($conf as $c){
            $page[$c->name]=$c->value;
        }

        return view('system_admin.settings',compact('page'));
    }
    public function add(Request $request)
    {
        if($request->has('mobile')){
            $this->validate($request,[
                'mobile'=>['required','numeric'],
                'email'=>'required|email',
                'address'=>'required',
//                'tax_number'=>'required',
//            'facebook'=>['required',new ValidUrl(),new ValidFaceBook()],
//            'twitter'=>['required',new ValidUrl(),new ValidTwitter()],
//                'ios'=>['required',new ValidUrl()],
//                'android'=>['required',new ValidUrl()],
            ]);
        }else{
            $this->validate($request,[
//                'mobile'=>['required',new ValidMobile()],
//                'email'=>'required|email',
//                'address'=>'required',
//                'tax_number'=>'required',
//            'facebook'=>['required',new ValidUrl(),new ValidFaceBook()],
//            'twitter'=>['required',new ValidUrl(),new ValidTwitter()],
                'ios'=>['required',new ValidUrl()],
                'android'=>['required',new ValidUrl()],
            ]);
        }

        foreach ($request->except(['_token','cut_types_activation']) as $name=>$value){
            Settings::updateOrCreate(
                ['name' => $name],
                ['value' => $value]
            );
        }

        if(isset($request->cut_types_activation)){

            $cut_types_activation = Settings::where('name','cut_types_activation')->first();
            $cut_types_activation->value=1;
            $cut_types_activation->save();
//            Settings::updateOrCreate(
//                ['name' => 'cut_types_activation'],
//                ['value' => 1]
//            );
        }else{
            $cut_types_activation = Settings::where('name','cut_types_activation')->first();
            $cut_types_activation->value=0;
            $cut_types_activation->save();
//            Settings::updateOrCreate(
//                ['name' => 'cut_types_activation'],
//                ['value' => 0]
//            );
        }
        flash('تم التعديل بنجاح');
        if(!$request->has('mobile')){
            return redirect(route('system.settings.index',['type'=>'contact_settings']));

        }else{

            return redirect(route('system.settings.index'));
        }
    }

    public function getNotifications(Request $request)
    {
        if($request->only_count == 1){
            $count=AdminNotification::where('seen',0)->count();

            return ['done'=>1,'count'=>$count,'items'=>""];
        }else{
            $all=AdminNotification::query()->whereNotNull('not_data')->orderBy('id','desc')->get();
            $items="";
            foreach($all as $a){
                $seen=$a->seen == 0?'new':'';
                $link="#";


                if($a->not_data){
                    $data = json_decode($a->not_data);;
                    $link=route('system.orders.details',$data->order_id);
                }
                $items.='<div class="m-list-timeline__item">
                        <span class="m-list-timeline__badge '.$seen.'"></span>
                        <span class="m-list-timeline__text"><a href="'.$link.'">'.$a->text.'</a></span>
                        <span class="m-list-timeline__time">'.$a->created_at->diffForHumans().'</span>
                    </div>';

            }

            AdminNotification::where('seen',0)->update(['seen'=>1]);
            return ['done'=>1,'count'=>0,'items'=>$items];
        }


    }


}
