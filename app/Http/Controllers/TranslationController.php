<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\NotificationText;
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
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function index()
    {
       $out=NotificationText::orderBy('id','DESC')->get();
        return view('system_admin.translations.index',compact('out'));
    }
    public function saveText(Request $request)
    {
        $out=NotificationText::orderBy('id','DESC')->get();

        foreach ($out as $o){

            $o->title_ar=$request->get($o->notification_key.'_title_ar',$o->title_ar);
            $o->message_ar=$request->get($o->notification_key.'_message_ar',$o->message_ar);
            $o->title_en=$request->get($o->notification_key.'_title_en',$o->title_en);
            $o->message_en=$request->get($o->notification_key.'_message_en',$o->message_en);
            $o->save();
        }
        flash('تم التعديل بنجاح');
         return redirect(route('system.translations.index'));
    }

    public function apiNotifications()
    {
        $this->manager->importTranslations(false);
        $out=Translation::where('tr_group', 'api_texts')->whereNull('value')->orderBy('key', 'asc')->orderBy('locale', 'asc')->get();
        $out2=Translation::where('tr_group', 'api_texts')->whereNotNull('value')->orderBy('key', 'asc')->orderBy('locale', 'asc')->get();
        $translations = [];
        foreach($out as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }
        foreach($out2 as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }

        return view('system_admin.translations.api',compact('translations'));

    }

    public function saveApi(Request $request)
    {
        $out=Translation::where('tr_group', 'api_texts')->orderBy('key', 'asc')->orderBy('locale', 'asc')->get();

        foreach ($out as $o){
            $new_text=$request->get($o->key.'_'.$o->locale,$o->value);
            if($o->value !=$new_text){
                $o->value=$new_text;
                $o->save();
            }
        }
        $this->manager->exportTranslations('api_texts', false);
        flash('تم التعديل بنجاح');
        return redirect(route('system.translations.apiTexts'));
    }






}
