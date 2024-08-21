<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsReplay;
use App\Models\Contact;
use App\Models\GlobalNotification;
use App\Models\UserAddress;
use App\Models\UserNotification;
use App\SystemAdmin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{


    public function index()
    {

        $out=Contact::orderBy('id','DESC')->paginate(15);
        return view('system_admin.contacts.index', compact('out'));

    }


    public function contactReplay(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'mess' => 'required',

        ]);
        $email=$request->email;
        $mess=$request->mess;

        Mail::to($email)->send(new ContactUsReplay($mess));
        $contact=Contact::find($request->id);
        if($user = User::find($contact->user_id)){
            ControllersService::NotificationToUser($user->id,'رد على استفسار','تم الرد على استفساركم',0);
        }

        flash('تم الارسال بنجاح');
        return back();
    }




    public function delete(Request $request)
    {
        if(is_array($request->id)){
            foreach ($request->id as $id) {
                $o=Contact::find($id);
                $o->delete();

            }
            return ['done'=>1];

        }else{
//            $this->validate($request, Order::$getRoles);
            $o=Contact::find($request->id);
            $o->delete();
            return ['done'=>1];
        }
    }









}
