<?php

namespace App\Http\Controllers;


use App\Models\Variant;
use \Illuminate\Validation\Rule;

use Illuminate\Http\Request;


class SizeController extends Controller
{


    public function index(Request $request)
    {
        $o=Variant::query()->where('variant_type_id',1)->orderBy('id','asc');

        $out=$o->paginate(15);
        return view('system_admin.sizes.index', compact('out'));

    }
    public function delete(Request $request)
    {
        if(is_array($request->id)){
            foreach ($request->id as $id) {
                $o=Variant::find($id);
                if($o->can_del){
                    $o->delete();
                }
            }
            return ['done'=>1];

        }else{
            $o=Variant::find($request->id);
            if($o->can_del){
                $o->delete();
            }
            return ['done'=>1];
        }
    }

    public function createJson(Request $request){

        $this->validate($request, [
            'name_ar' => ['required','max:255',Rule::unique('variants','name_ar')->where('variant_type_id',1)],
            'name_en' => ['required','max:255',Rule::unique('variants','name_en')->where('variant_type_id',1)],

        ]);

        $out=new Variant();
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->variant_type_id=1;
        $out->save();

        $output = '';

        $output.='<label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">';
        $output.='<input type="checkbox" value="'.$out->id.'" name="sizes[]" class="CheckedItem" id="che_{{$out->id}}">';
        $output.=''.$out->name.'';
           $output.='<span></span>';
        $output.=' </label>';
        //}
        return ['done'=>1,'out'=>$output];

    }

    public function getInfo(Request $request)
    {
        if($out = Variant::find($request->id)){
            return ['done'=>1 , 'name_ar'=>$out->name_ar,'name_en'=>$out->name_en,'id'=>$out->id,];
        }else{
            return ['done'=>0 , ];

        }


    }

    public function createj(Request $request)
    {
        $validator = \Validator::make(request()->all(), [
            'name_ar' => ['required','max:255',Rule::unique('variants','name_ar')->where('variant_type_id',1)],
            'name_en' => ['required','max:255',Rule::unique('variants','name_en')->where('variant_type_id',1)],
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->toArray()], 200);
        }

        $out=new Variant();
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->variant_type_id=1;
        $out->save();
        $html  ="<tr id='TR_".$out->id."'>";
        $html .="<td class='LOOPIDS'>1</td>";
        $html .="<td style='text-align: center;vertical-align: middle;'>";
        $html .="<label class='m-checkbox m-checkbox--solid m-checkbox--success m-size-table'>";
        $html .="<input type='checkbox' value='".$out->id."' name='Item[]' class='CheckedItem' id='che_".$out->id."'>";
        $html .="<span></span></label></td>";
        $html .="<td class='text-right'>".$out->name."</td>";
        // $html .="<td class='text-center'> ".$out->created_at->toDateString()."</td>";
        $html .="<td class='text-center'>";
        $html .="<ul class='list-inline'><li><button id='".$out->id."' class=' editCat btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom' data-skin='dark' data-tooltip='m-tooltip' data-placement='top' title='تعديل البيانات'><i class='fa fa-edit'></i>  </button> </li>";
        $html .="   <li><button type='button' data-id='".$out->id."' data-url='".route('system.sizes.delete')."'data-token='".csrf_token()."'";
        $html .="   data-skin='dark' data-tooltip='m-tooltip'  data-placement='top' title='حذف' class='btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del'>  <i class='fa fa-trash '></i>  </button>  </li>";


        $html .="</ul> </td></tr>";

        return ['done'=>1,'html'=>$html];
    }

    public function updatej(Request $request)
    {

        $validator = \Validator::make(request()->all(), [
            'name_ar' => ['required','max:255',Rule::unique('variants','name_ar')->where('variant_type_id',1)->whereNot('id',$request->id)],
            'name_en' => ['required','max:255',Rule::unique('variants','name_en')->where('variant_type_id',1)->whereNot('id',$request->id)],
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()->toArray()], 200);
        }

        $out = Variant::find($request->id);
        $out->name_ar=$request->name_ar;
        $out->name_en=$request->name_en;
        $out->save();

        return ['done'=>1,'html'=>''];
    }

    public function getSizes(Request $request){
        $sizes = Variant::query()->where('variant_type_id',1)->get();

        $view = \View::make('system_admin.sizes.sizes', compact('sizes'));
        $output=$view->render();
        return ['out' => $output, 'done' => 1] ;
    }

}
