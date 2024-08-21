<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\Gov;
use App\Models\Area;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CountriesController extends Controller
{
    public function index()
    {
        $out=Country::orderBy('id','DESC')->paginate(20);
        return view('system_admin.countries.index', compact('out'));
    }
    public function showCreateView()
    {
        return view('system_admin.countries.create');
    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'uploaded_image_name' => 'required',
            'prefix' => 'required|numeric|unique:countries,prefix,Null,id',
            'mobile_digits' => 'required|numeric',
            'tax'=>'numeric|min:0|max:99',
            //'transport'=>'numeric|min:0',
            'currency_ar' => 'required|max:255',
            'currency_en' => 'required|max:255',
        ]);

            $n= new Country();
            $n->name_ar=$request->name_ar;
            $n->name_en=$request->name_en;
            $n->flag=$request->uploaded_image_name;
            $n->prefix=$request->prefix;
            $n->mobile_digits=$request->mobile_digits;
            $n->currency_ar = $request->currency_ar;
            $n->currency_en = $request->currency_en;
            $n->tax = $request->tax;
            $n->save();
            \HELPER::deleteUnUsedFile([$request->uploaded_image_name]);
            flash('تم اضافة الدولة بنجاح');
            return redirect()->route('system.countries.index');

    }
    /*****************************************/
    public function showUpdateView($id)
    {
        $out=Country::findOrFail($id);
        return view('system_admin.countries.update',compact('out'));
    }
    /****************************************/
    public function Update(Request $request,$id)
    {
        $this->validate($request, [
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'uploaded_image_name' => 'required',
            'prefix' => 'required|numeric|unique:countries,prefix,'.$id.',id',
            'mobile_digits' => 'required|numeric',
            'tax'=>'numeric|min:0|max:99',
           // 'transport'=>'numeric|min:0',
            'currency_ar' => 'required|max:255',
            'currency_en' => 'required|max:255',
        ]);

            $n = Country::findOrFail($id);
            $n->name_ar = $request->name_ar;
            $n->name_en = $request->name_en;
            $n->flag =  $request->uploaded_image_name;
            $n->prefix = $request->prefix;
            $n->mobile_digits = $request->mobile_digits;
            $n->currency_ar = $request->currency_ar;
            $n->currency_en = $request->currency_en;
            $n->tax = $request->tax;
            $n->save();
            \HELPER::deleteUnUsedFile([$request->uploaded_image_name]);
            flash('تم تعديل الدولة بنجاح');
            return redirect()->route('system.countries.index');

    }
    public function delete(Request $request)
    {
        if(is_array($request->id)){
            $done=1;
            foreach ($request->id as $id) {
                $o=Country::find($id);
                if($o->can_del){
                    $done=$done*0;
                }else{
                    $done=$done*1;
                }
            }
            if($done){
                foreach ($request->id as $id) {
                    $o=Country::find($id);
                    $o->delete();
                }
            }
            return ['done'=>$done];
        }else{
            $o=Country::find($request->id);
            if($o->can_del){
                return ['done'=>0];
            }else{
                $o->delete();
                return ['done'=>1];
            }
        }
    }

    public function activate(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Country::find($id);
            $o->status=1;
            $o->save();
        }
        return ['done' => 1];

    }
    public function deactivate(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Country::find($id);
            $o->status=0;
            $o->save();
        }
        return ['done' => 1];

    }
}
