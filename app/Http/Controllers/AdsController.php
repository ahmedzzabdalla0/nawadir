<?php

namespace App\Http\Controllers;

use App\Events\SendDriversNotification;
use App\Events\SendUserNotification;
use App\Events\SendUsersNotification;
use App\Models\Driver;
use App\Models\Ads;
use App\Models\Order;
use App\Models\Product;

use App\Models\UserNotification;
use App\SystemAdmin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdsController extends Controller
{
    //


    public function ads(Request $request)
    {

        $o=Ads::query()->orderBy('id','DESC');

        if($request->date_from){
            $o->where('created_at','>=',$request->date_from);
        }
        if($request->date_to){
            $o->where('created_at','<=',$request->date_to);
        }
        $out=$o->paginate(15);

        return view('system_admin.ads.index', compact('out'));

    }

    /***********************************/
    public function showCreateView()
    {

      return view('system_admin.ads.create');


    }


    /*************************/

    public function create(Request $request)
    {

    $this->validate($request, [
          'title' => 'required|max:255',
          'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
      ]);
    //   INSERT INTO `ads`(`id`, `title`, `image`, `status`, `slider`, `body`, `created_at`, `updated_at`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
    $image = '';
       if (!empty($request->image)) {
    $file =$request->file('image');
    $extension = $file->getClientOriginalExtension(); 
    $filename = time().'.' . $extension;
    $file->move(public_path('uploads/'), $filename);
    $image='https://nwader.sa/uploads/'.$filename;
}

        $title=$request->get('title');
        $body=$request->get('body');
        $notification = new Ads();
        $notification->title = $title;
                $notification->status =1;

        $notification->body = $body;
                $notification->image = $image;

        $notification->slider = $request->get('slider') ?? 1;
        $notification->save();
        $notification->fresh();
   
   

        flash('تم الارسال بنجاح');

    return redirect()->route('system.ads.index');
    }

    public function delete(Request $request)
    {
        if(is_array($request->id)){
            foreach ($request->id as $id) {
                $o=Ads::find($id);

                $o->delete();

            }
            return ['done'=>1];

        }else{
            $o=Ads::find($request->id);
            $o->delete();
            return ['done'=>1];
        }
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




}
