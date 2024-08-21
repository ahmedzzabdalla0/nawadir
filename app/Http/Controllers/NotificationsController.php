<?php

namespace App\Http\Controllers;

use App\Events\SendDriversNotification;
use App\Events\SendUserNotification;
use App\Events\SendUsersNotification;
use App\Models\Driver;
use App\Models\GlobalNotification;
use App\Models\Order;
use App\Models\Product;

use App\Models\UserNotification;
use App\SystemAdmin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NotificationsController extends Controller
{
    //


    public function notifications(Request $request)
    {

        $o=GlobalNotification::query()->whereNull('user_id')->orderBy('id','DESC');

        if($request->date_from){
            $o->where('created_at','>=',$request->date_from);
        }
        if($request->date_to){
            $o->where('created_at','<=',$request->date_to);
        }
        $out=$o->paginate(15);

        return view('system_admin.notifications.index', compact('out'));

    }

    /***********************************/
    public function showCreateView()
    {

      return view('system_admin.notifications.create');


    }


    /*************************/

    public function create(Request $request)
    {
 

    $this->validate($request, [
          'title' => 'required|max:255',
          'message' => 'required',
      ]);
        $title=$request->get('title');
        $message=$request->get('message');
        $notification = new GlobalNotification();
        $notification->title = $title;
        $notification->message = $message;
        $notification->system_admin_id = Auth::guard('system_admin')->user()->id;
        $notification->save();
        $notification->fresh();
        if($request->user_query > 0 && $request->user_query!=3){
            $user_query=User::query()->whereIn('status',[1,0]);
            if($request->user_type != 0){
                $user_query->where('user_type_id',$request->user_type);
            }
                if($request->user_query == 1){
                    $user_query->where('status',0);
                }elseif($request->user_query == 2){
                    $users_ids = Order::query()->distinct('user_id')->pluck('user_id')->toArray();
                    $user_query->whereNotIn('id',$users_ids);
                }
            $user=$user_query->get();
//      foreach($user as $usr){
            event(new SendUsersNotification($user,  'AdminNotification',  ['global_notification'=>$notification->id],1,0));
//      }
        }elseif($request->user_query == 3){
            $drivers = Driver::all();
            event(new SendDriversNotification($drivers,  'AdminNotification',  ['global_notification'=>$notification->id],1,0));

        }else{
            event(new SendUsersNotification(null,  'AdminNotification',  ['global_notification'=>$notification->id],1,1));
        }

        flash('تم الارسال بنجاح');

    return redirect()->route('system.notifications.index');
    }

    public function delete(Request $request)
    {
        if(is_array($request->id)){
            foreach ($request->id as $id) {
                $o=GlobalNotification::find($id);

                $this->deleteNotifications($id);
                $o->delete();

            }
            return ['done'=>1];

        }else{
            $o=GlobalNotification::find($request->id);
            $this->deleteNotifications($request->id);
            $o->delete();
            return ['done'=>1];
        }
    }

    public function deleteNotifications($id){
                 UserNotification::query()
                ->where('global_id',$id)
                ->delete();
                 return true;
    }



    public function showCreateUserView($id)
    {

        $user = User::find($id);
        if(!$user){
            flash('المستخدم المطلوب غير موجود');
            return redirect()->back();
        }
        $redirect = 'system.users.details';

        return view('system_admin.notifications.create-user',compact('id','redirect'));


    }


    /*************************/

    public function createPerUser(Request $request)
    {


        $this->validate($request, [
            'title' => 'required|max:255',
            'message' => 'required',
            'user_id' => 'required|integer',
        ]);
        $title=$request->get('title');
        $message=$request->get('message');
        $notification = new GlobalNotification();
        $notification->title = $title;
        $notification->message = $message;
        $notification->system_admin_id = Auth::guard('system_admin')->user()->id;
        $notification->user_id = $request->user_id;
        $notification->save();
        $notification->fresh();
        event(new SendUserNotification($request->user_id,  'AdminNotification',  ['global_notification'=>$notification->id],1));
        flash('تم الارسال بنجاح');
        return redirect()->route($request->redirect_to,['id'=>$request->user_id]);
    }




    public function showCreateDriverView($id)
    {

        $user = Driver::find($id);
        if(!$user){
            flash('المستخدم المطلوب غير موجود');
            return redirect()->back();
        }
        $redirect = 'system.drivers.details';

        return view('system_admin.notifications.create-driver',compact('id','redirect'));


    }


    /*************************/

    public function createPerDriver(Request $request)
    {


        $this->validate($request, [
            'title' => 'required|max:255',
            'message' => 'required',
            'user_id' => 'required|integer',
        ]);
        $title=$request->get('title');
        $message=$request->get('message');
        $notification = new GlobalNotification();
        $notification->title = $title;
        $notification->message = $message;
        $notification->system_admin_id = Auth::guard('system_admin')->user()->id;
        $notification->user_id = $request->user_id;
        $notification->save();
        $notification->fresh();
        event(new SendUserNotification($request->user_id,  'AdminNotification',  ['global_notification'=>$notification->id],1,'driver'));
        flash('تم الارسال بنجاح');
        return redirect()->route($request->redirect_to,['id'=>$request->user_id]);
    }
}
