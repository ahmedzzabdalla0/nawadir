<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 1/9/2017
 * Time: 03:21 م
 */

namespace App\Http\Controllers;

use App\Models\AdminRule;
use App\Models\Module;
use App\Models\Rule;
use App\SystemAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{


    public function index(Request $request)
    {
        if (\Auth::user()->id != 1) {
            flash('لا تستطيع الوصول لهذا المكان','error');
            return redirect()->route('system_admin.dashboard');
        }

        $out = SystemAdmin::orderBy('id','DESC')->paginate(15);

        return view('system_admin.admins.index', compact('out'));
    }

    public function showCreateView()
    {
        return view('system_admin.admins.create');

    }
    public function showUpdateView($id)
    {
        $out=SystemAdmin::findOrFail($id);
        return view('system_admin.admins.update',compact('out'));

    }
    public function showProfileView()
    {
        $out=\Auth::guard('system_admin')->user();
        return view('system_admin.admins.profile',compact('out'));

    }

    public function showPasswordView($id)
    {
        $out=SystemAdmin::findOrFail($id);
        return view('system_admin.admins.password',compact('out'));

    }


    public function showProfilePasswordView()
    {
        return view('system_admin.admins.profile_password');

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|unique:system_admins,mobile|numeric',
           // 'image' => 'required',
            'username' => 'required|max:255|unique:system_admins,email',
//            'password' => ['required',new PasswordPolicy()],
            'password' => ['required'],
        ]);

        $n= new SystemAdmin();
        $n->name=$request->name;
        $n->email=$request->username;
        $n->mobile=$request->mobile;
        $n->avatar=$request->image;
        $n->password=bcrypt($request->password);
        $n->save();
        \HELPER::deleteUnUsedFile([$request->image]);

        flash('تم اضافة المدير بنجاح');

        return redirect()->route('system.admin.index');
    }
    public function Update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|unique:system_admins,mobile,'.$id,
           // 'image' => 'required',
            'username' => 'required|max:255|unique:system_admins,email,'.$id,
        ]);

        $n= SystemAdmin::findOrFail($id);
        $n->name=$request->name;
        $n->email=$request->username;
        $n->mobile=$request->mobile;
        if($request->image){
            $n->avatar=$request->image;
            \HELPER::deleteUnUsedFile([$request->image]);
        }

        $n->save();


        flash('تم تعديل المدير بنجاح');

        return redirect()->route('system.admin.index');
    }

    public function profile(Request $request)
    {
        $n= \Auth::guard('system_admin')->user();;

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|unique:system_admins,mobile,'.$n->id,
           // 'image' => 'required',
            'username' => 'required|max:255|unique:system_admins,email,'.$n->id,
        ]);

        $n->name=$request->name;
        $n->email=$request->username;
        $n->mobile=$request->mobile;
        if($request->image){
            $n->avatar=$request->image;
            \HELPER::deleteUnUsedFile([$request->image]);
        }
        $n->save();


        flash('تم تعديل بياناتي بنجاح');

        return redirect()->route('system_admin.dashboard');
    }

    public function password(Request $request,$id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        $n= SystemAdmin::findOrFail($id);
        $n->password=bcrypt($request->password);

        $n->save();

        flash('تم تغيير كلمة المرور بنجاح ');

        return redirect()->route('system.admin.index');
    }
    public function profilePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $n= \Auth::guard('system_admin')->user();

        if (Hash::check($request->old_password, $n->password)) {
            $n->password = bcrypt($request->password);
            $n->save();
            flash('تم تغيير كلمة المررو بنجاح ');

            return redirect()->route('system.admin.profile');
        }else{
            return redirect()->back()->withErrors(['old_password'=>'كلمة المرور القديمة خاطئة']);
        }


    }
    public function showPermissionView($id){
        $user=SystemAdmin::where('id','<>',1)->find($id);
        $rules=Rule::all();
        $modules=Module::all();
        return view('system_admin.admins.permissions',['user'=>$user,'rules'=>$rules,'modules'=>$modules]);
    }
    public function changePermission(Request $request){
        $User=$request->User;
        $Rule=$request->Rule;
        $Module=$request->Module;
        $IsCheck=$request->IsCheck;

        if($IsCheck == 'true'){
            $aa=new AdminRule();
            $aa->admin_id=$User;
            $aa->rule_id=$Rule;
            $aa->module_id=$Module;
            $aa->save();
            return ['done'=>'true','id'=>$aa->id];
        }else{
            $b=AdminRule::where('id',$request->ruleID)->first();
            $b->delete();
            return ['done'=>'true','id'=>0];

        }

    }

    public function delete(Request $request)
    {
        if(is_array($request->id)){
            foreach ($request->id as $id){
                SystemAdmin::destroy($id);
            }
            return ['done'=>1];
        }else{
            $isDeleted = SystemAdmin::destroy($request->id);
            return ['done'=>$isDeleted];
        }

    }




}
