<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;

class CutTypeController extends Controller
{
    //

    public function index(Request $request){

        $o=Variant::query()->where('variant_type_id',2)->orderBy('id','DESC');
//        if($request->name_en){
//            $o->where('name_en', 'like' ,'%'.$request->name_en.'%');
//        }
        if($request->name){
            $o->where('name_ar', 'like' ,'%'.$request->name.'%');
        }
        if($request->has('status') && $request->status != -1){
            $o->where('status' ,$request->status);
        }

        $out=$o->paginate(15);
        $out->appends($request->all());
        return view('system_admin.cut_types.index',compact('out'));
    }


    public function showCreateView(){

        return view('system_admin.cut_types.create');

    }


    public function create(Request $request){

        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'image' => 'required',

        ]);

        $out=new Variant();
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->variant_type_id=2;
        $out->image=$request->image;
        $out->save();
        \HELPER::deleteUnUsedFile([$request->image]);

        flash('تم  الاضافة بنجاح');

        return redirect()->route('system.cut_types.index');

    }



    public function showUpdateView(Request $request){
        $out=Variant::query()->where('variant_type_id',2)->find($request->id);
        if(!$out){
            flash('نوع التقطيع المطلوب غير موجود');
            return redirect()->back();
        }
        return view('system_admin.cut_types.update',compact('out'));

    }

    public function Update(Request $request,$id){

        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'image' => 'required',

        ]);

        $out=Variant::find($id);
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->image=$request->image;
        $out->save();
        \HELPER::deleteUnUsedFile([$request->image]);

        flash('تم التعديل بنجاح');

        return redirect()->route('system.cut_types.index');

    }



    public function delete(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }
        foreach ($ids as $id){
            $c=Variant::find($id);
            if($c->can_del && $id != 14){
                $c->delete();
            }
        }
        return ['done'=>1];

    }
    public function activate(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }
        foreach ($ids as $id){
            $c=Variant::find($id);
            if($id != 14){
                $c->status = 1;
                $c->save();
            }
        }
        return ['done'=>1];

    }
    public function deactivate(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }
        foreach ($ids as $id){
            $c=Variant::find($id);
            if($id != 14){
                $c->status = 0;
                $c->save();
            }
        }
        return ['done'=>1];

    }


}
