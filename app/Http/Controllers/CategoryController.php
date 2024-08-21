<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //

    public function index(Request $request){
        $count = Category::query()->pluck('sorted')->toArray();

        $o=Category::query()->orderBy('sorted','asc');
        if($request->name_en){
            $o->where('name_en', 'like' ,'%'.$request->name_en.'%');
        }
        if($request->name_ar){
            $o->where('name_ar', 'like' ,'%'.$request->name_ar.'%');
        }
        if($request->has('status') && $request->status != -1){
            $o->where('status' ,$request->status);
        }

        $out=$o->paginate(15);
        $out->appends($request->all());
        return view('system_admin.categories.index',compact('out','count'));
    }


    public function showCreateView(){

        return view('system_admin.categories.create');

    }


    public function create(Request $request){

        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'image' => 'required',

        ]);
        $count = 0;
        $category = Category::orderBy('sorted','desc')->first();
        if($category &&  $category->sorted > 0){
            $count =  $category->sorted ;
        }
        $out=new Category();
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->logo=$request->image;
        $out->sorted = $count+1;
        $out->save();
        \HELPER::deleteUnUsedFile([$request->image]);

        flash('تم  الاضافة بنجاح');

        return redirect()->route('system.categories.index');

    }



    public function showUpdateView(Request $request){
        $out=Category::find($request->id);
        return view('system_admin.categories.update',compact('out'));

    }

    public function Update(Request $request,$id){

        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'image' => 'required',

        ]);
        $out=Category::find($id);
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
                $out->status=$request->status == null ? 1 : 0;

        $out->logo=$request->image;
        $out->save();
        \HELPER::deleteUnUsedFile([$request->image]);

        flash('تم التعديل بنجاح');

        return redirect()->route('system.categories.index');

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
            $c=Category::find($id);
            if($c->can_del){
                $c->delete();
            }
        }
        return ['done'=>1];

    }

    public function getSubs(Request $request)
    {
        $cities=SubCategory::where('category_id',$request->id)->get();
        $out = '<option value="">اختر التصنيف الفرعي</option>';
        foreach ($cities as $m) {
            $out .= "<option value='$m->id'>$m->name </option> ";
        }
        return ['done'=>1,'out'=>$out];
    }
    public function createJson(Request $request){

        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',

        ]);
        $count = 0;
        $category = Category::orderBy('sorted','desc')->first();
        if($category &&  $category->sorted > 0){
            $count =  $category->sorted ;
        }
        $out=new Category();
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->logo='';
        $out->sorted = $count+1;
        $out->save();
        $cats=Category::all();
        $out = '<option value="">اختر التصنيف </option>';
        $out.='<option value="9911Add_NeW_tO_The_LiST9911" > اضافة عنصر جديد</option>';

        foreach ($cats as $m) {
            $out .= "<option value='$m->id'>$m->name </option> ";
        }
        return ['done'=>1,'out'=>$out];

    }
    public function sortCategory(Request $request)
    {
        $roles = [
            'id' => ['required','exists:categories,id'],
            'sort' => ['required','integer'],
        ];
        $id = $request->id;
        $sort = $request->sort;
        $category = Category::find($id);
        $old_sort = $category->sorted;
        $category->sorted = $sort;
        $category->save();
        $category_d = Category::query()->whereNotIn('id',[$id])->where('sorted',$sort)->first();
        if($category_d){
            $category_d->sorted = $old_sort;
            $category_d->save();
        }

        return response()->json(['done'=>1], 200);
    }

}
