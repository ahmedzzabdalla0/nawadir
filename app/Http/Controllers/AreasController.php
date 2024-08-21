<?php



namespace App\Http\Controllers;





use App\Models\Country;
use App\Models\Gov;
use App\Models\Area;
use App\Models\GovDivision;
use App\Models\Settings;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class AreasController extends Controller

{





    public function index(Request $request , $id = 2)

    {


$delivery_price_type = Settings::where('name','delivery_price_type')->first()->value;
        $out=Gov::orderBy('id','DESC')->where('country_id',$id)->paginate(15);

        return view('system_admin.areas.index', compact('out','delivery_price_type'));



    }
    public function add_country(Request $request)
    {

        $object=new Gov();
        $object->name=$request->name;
        $object->name_en=$request->name;
        $object->save();
        $view = View::make('system_admin.areas.citem', ['a' => $object]);
        $out = $view->render();
        return ['done'=>'true','out'=>$out];
    }
    public function add_city(Request $request)
    {
        $object=new Area();
        $object->name=$request->name;
        $object->name_en=$request->name;
        $object->gov_id=$request->country;
        $object->save();

        $view = View::make('system_admin.areas.item', ['b' => $object]);
        $out = $view->render();
        return ['done'=>'true','out'=>$out];


    }
    public function edit_country(Request $request)
    {

        $object= Gov::find($request->id);
        $object->name=$request->name;
        $object->name_en=$request->name;
        $object->save();

        $view = View::make('system_admin.areas.citem', ['a' => $object]);
        $out = $view->render();
        return ['done'=>'true','out'=>$out];

    }
    public function edit_city(Request $request)
    {
        $object= Area::find($request->id);
        $object->name=$request->name;
        $object->name_en=$request->name;
        $object->gov_id=$request->gov_id;
        $object->save();

        $view = View::make('system_admin.areas.item', ['b' => $object]);
        $out = $view->render();
        return ['done'=>'true','out'=>$out];

    }

    public function delete_country(Request $request)
    {
        $coun=Gov::find($request->id);
        if($coun->can_del){
            $coun->delete();
            return ['done'=>'true'];
        }else{
            return ['done'=>'false','mess'=>'لا يمكن الحذف الدولة تحتوي على مدن'];

        }


    }

    public function delete_city(Request $request)
    {
        $coun=Area::find($request->id);
        if($coun->can_del) {
            $coun->delete();
            return ['done' => 'true'];
        }

    }
    public function delete_division(Request $request)
    {
        $coun=GovDivision::find($request->id);
        if($coun->can_del) {
            $coun->delete();
            return ['done' => 'true'];
        }

    }

    public function get_cities(Request $request)
    {
        $cities=Area::where('gov_id',$request->id)->get();
        $out = '<option value="">اختر المدينة</option>';
        foreach ($cities as $m) {
            $out .= "<option value='$m->id'>$m->name </option> ";
        }
        return ['done'=>1,'out'=>$out];
    }
    public function get_divisions(Request $request)
    {
        $cities=GovDivision::where('gov_id',$request->id)->get();
        $out = '<option value="">هذا قسم</option>';
        foreach ($cities as $m) {
            $out .= "<option value='$m->id'>$m->name </option> ";
        }
        return ['done'=>1,'out'=>$out];
    }

    public function showCreateView(){
        $govs=Gov::query()->get();
        return view('system_admin.areas.create',compact('govs'));

    }


    public function create(Request $request){

        $this->validate($request, [
            'name_ar' => ['required',new ValidStringArabic(),'max:50'],
            'name_en' => ['required',new ValidString(),'max:50'],
        ]);

        if($request->gov_id && $request->gov_division_id){
            $object= new Area();
            $object->name_ar=$request->name_ar;
            $object->name_en=$request->name_en;
            $object->gov_id=$request->gov_id;
            $object->gov_division_id=$request->gov_division_id;
            $object->delivery_price=0;
            $object->save();
        }else if($request->gov_id && !$request->gov_division_id){
            $object= new GovDivision();
            $object->name_ar=$request->name_ar;
            $object->name_en=$request->name_en;
            $object->gov_id=$request->gov_id;
            $object->save();
        }else{
            $object= new Gov();
            $object->name_ar=$request->name_ar;
            $object->name_en=$request->name_en;
            $object->save();

        }

        flash('تم  الاضافة بنجاح');

        return redirect()->route('system.areas.index');

    }


    public function showUpdateView(Request $request,$id,$type){
        if($type == 1){
            $out=Gov::find($id);
            return view('system_admin.areas.update',compact('out','type'));
        }else if($type == 2){
            $out=GovDivision::find($id);
            $govs=Gov::all();
            return view('system_admin.areas.update2',compact('out','govs','type'));
        }else{
            $out=Area::find($id);
            $govs=Gov::all();
            $type=3;
            $gov_divsions = GovDivision::where('gov_id',$out->gov_id)->get();
            return view('system_admin.areas.update2',compact('out','govs','gov_divsions','type'));
        }

    }

    public function Update(Request $request,$id){

        $this->validate($request, [
            'name_ar' => ['required',new ValidStringArabic(),'max:50'],
            'name_en' => ['required',new ValidString(),'max:50'],

        ]);

        if($request->gov_id ){
            if($request->type==2){
                $object=GovDivision::findOrFail($id);
                $object->name_ar=$request->name_ar;
                $object->name_en=$request->name_en;
                $object->gov_id=$request->gov_id;
                $object->save();

            }else{
                $object=Area::findOrFail($id);
                $object->name_ar=$request->name_ar;
                $object->name_en=$request->name_en;
                $object->gov_id=$request->gov_id;
                $object->save();
            }

        }else{
            $object= Gov::findOrFail($id);
            $object->name_ar=$request->name_ar;
            $object->name_en=$request->name_en;
            $object->save();
        }

        flash('تم التعديل بنجاح');

        return redirect()->route('system.areas.index');

    }

    public function showPricesView(Request $request,$id){

        $out=Gov::find($id);
        return view('system_admin.areas.edit-prices',compact('out'));
    }

    public function UpdatePrices(Request $request){


        $roles['area_id.*'] = ['required','integer'];
        $roles['delivery_price.*'] = ['required','numeric'];

        $this->validate($request, $roles);
        $area_ids = $request->area_id;
        $delivery_price = $request->delivery_price;
        for($i = 0 ;$i<count($area_ids);$i++){
            $area = Area::find($area_ids[$i]);
            if($area){
                $area->delivery_price=$delivery_price[$i];
                $area->save();
            }

        }
        flash('تم تعديل أسعار التوصيل بنجاح');

        return redirect()->route('system.areas.index');

    }


}

