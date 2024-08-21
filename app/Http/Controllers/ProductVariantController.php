<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAmountLog;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    //

    public function index(Request $request,$id)
    {
        $product= Product::find($id);
        if(!$product){
            flash('المنتج المطلوب غير موجود');
            return redirect()->route('system.products.index');
        }
        $has_colors = ProductVariant::query()->where('product_id',$id)->where('color_id','>',0)->pluck('color_id')->toArray();
        $has_sizes = ProductVariant::query()->where('product_id',$id)->where('size_id','>',0)->pluck('size_id')->toArray();
        $has_metrics = ProductVariant::query()->where('product_id',$id)->where('metric_id','>',0)->pluck('metric_id')->toArray();

        $colors = Variant::where('variant_type_id',3)->whereIn('id',explode(',',$product->color_ids))->get();
        $sizes = Variant::where('variant_type_id',1)->whereIn('id',explode(',',$product->size_ids))->get();
        $metrics = Variant::where('variant_type_id',2)->whereIn('id',explode(',',$product->metric_ids))->get();
        $o=ProductVariant::where('product_id',$id)->where('is_default',0)->orderBy('id','DESC');
        if($request->color_id > 0){
            $o->where("color_id",$request->color_id);
        }
        if($request->size_id > 0){
            $o->where("size_id",$request->size_id);
        }
        if($request->metric_id > 0){
            $o->where("metric_id",$request->metric_id);
        }
        if($request->status > -1){
            $o->where('status',$request->status);
        }
        if($request->price_from){
            $o->where('price','>=',$request->price_from);
        }
        if($request->price_to){
            $o->where('price','<=',$request->price_to);
        }
        $out = $o->paginate(15);
        $out->appends($request->all());
        return view('system_admin.product-variants.index', compact('out','colors','sizes','metrics','product','has_colors','has_metrics','has_sizes'));

    }



    public function showCreateView($id)
    {
        $product= Product::find($id);
        if(!$product){
            flash('المنتج المطلوب غير موجود');
            return redirect()->route('system.products.index');
        }
        $colors = Variant::where('variant_type_id',3)->whereIn('id',explode(',',$product->color_ids))->get();
        $sizes = Variant::where('variant_type_id',1)->whereIn('id',explode(',',$product->size_ids))->get();
        $metrics = Variant::where('variant_type_id',2)->whereIn('id',explode(',',$product->metric_ids))->get();

        return view('system_admin.product-variants.create', compact('colors','sizes','metrics','product'));


    }


    public function showUpdateView(Request $request,$id){
        $product = Product::find($id);
        if(!$product){
            flash('المنتج غير موجود');
            return redirect()->back();
        }
        $out = ProductVariant::where('product_id',$product->id)->where('is_default',0)->get();
        return view('system_admin.product-variants.product-variants-edit', compact('out','product'));

    }
    public function update(Request $request){
        $product_id = $request->product_id;

        if(count($request->ids)){
            $ids = $request->ids;
            $prices = $request->prices;
            $images = $request->images;

            $default_image = ProductImage::where('product_id',$request->product_id)->where('is_main',1)->first();
            for($i = 0;$i<count($ids);$i++){
                $variant = ProductVariant::find($ids[$i]);
                $variant->image_id=$images[$i]??($default_image?$default_image->id:null);
                $variant->price=$prices[$i];
                $variant->save();
                $variant->refresh();
            }
        }
        flash('تم تعديل المنتجات بنجاح');
        return redirect()->route('system.product_variants.index',['id'=>$product_id]);
    }



    public function create(Request $request)
    {

        $product_variant_old = ProductVariant::query()->where('product_id',$request->product_id);
        if($request->size_id){
            $product_variant_old->where('size_id',$request->size_id);
        }
        if($request->metric_id){
            $product_variant_old->where('metric_id',$request->metric_id);
        }
        if($request->color_id){
            $product_variant_old->where('color_id',$request->color_id);
        }
        $o = $product_variant_old->get();
        if(count($o)){
            flash('هذا المنتج مضاف مسبقا');
            return redirect()->back()->withInput();
        }
        $this->validate($request, [
            'product_id' => ['required',Rule::exists('products','id')],
            'price' => 'required|numeric|min:0.1|max:99999',
            'color_id' => 'nullable|exists:variants,id',
            'size_id' => 'nullable|exists:variants,id',
            'metric_id' => 'nullable|exists:variants,id',
            'image' => 'required|exists:product_images,id',
            'qty' => 'required|integer|min:1',
        ]);

        $object = new ProductVariant();
        $object->product_id = $request->product_id;
        $object->price = $request->price;
        $object->color_id = $request->color_id;
        $object->size_id = $request->size_id;
        $object->metric_id = $request->metric_id;
        $object->image_id = $request->image;
        $object->save();
        $object->refresh();
//        $product_variant_amount = new ProductAmountLog();
//        $product_variant_amount->product_id = $request->product_id;
//        $product_variant_amount->product_variant_id = $object->id;
//        $product_variant_amount->amount = $request->qty;
//        $product_variant_amount->price = $request->price;
//        $product_variant_amount->type = 'AddToStock';
//        $product_variant_amount->note = 'اضافة كمية للمخزن';
//        $product_variant_amount->is_approved = 1;
//        $product_variant_amount->save();

        flash('تمت الاضافة بنجاح');

        return redirect(route('system.product_variants.index',['id'=>$request->product_id]));
    }

    public function delete(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;
        }
        foreach ($ids as $id){
            $s=ProductVariant::find($id);
            $i=0;
            if($s->can_del){
                $s->delete();
                $i++;
            }

        }
        return ['done'=>$i];


    }


    public function showAddedVariants(Request $request,$id){
        $product = Product::find($id);
        if(!$product){
            flash('المنتج غير موجود');
            return redirect()->back();
        }
        $out = ProductVariant::where('product_id',$product->id)->where('is_default',0)->get();
        return view('system_admin.product-variants.product-variants-add', compact('out','product'));

    }
    public function editVariantsQty(Request $request){

        if(count($request->ids)){
            $ids = $request->ids;
            $prices = $request->prices;
            $qty = $request->qty;
            $images = $request->images;
            $product_id = 0;
            $default_image = ProductImage::where('product_id',$request->product_id)->where('is_main',1)->first();
            for($i = 0;$i<count($ids);$i++){
                $variant = ProductVariant::find($ids[$i]);
                $variant->image_id=$images[$i]??($default_image?$default_image->id:null);
                $variant->price=$prices[$i];
                $variant->save();
                $variant->refresh();
//                if(is_numeric($qty[$i]) && $qty[$i]>0){
//                    $product_variant_amount = new ProductAmountLog();
//                    $product_variant_amount->product_id = $variant->product_id;
//                    $product_variant_amount->product_variant_id = $variant->id;
//                    $product_variant_amount->amount = $qty[$i];
//                    $product_variant_amount->price = $prices[$i];
//                    $product_variant_amount->type = 'AddToStock';
//                    $product_variant_amount->note = 'اضافة كمية للمخزن';
//                    $product_variant_amount->is_approved = 1;
//                    $product_variant_amount->save();
//                    $product_id = $variant->product_id;
//                }
            }
            $product = Product::find($product_id);
            $product->set_qty =1;
            $product->save();
            $product->refresh();
//            $default_variant = ProductVariant::where('product_id',$product->id)->where('is_default',1)->first();
//            if($default_variant){
//                $product_variant_amount = ProductAmountLog::query()->where('product_id',$product->id)->where('product_variant_id',$default_variant->id)->first();
//                if($product_variant_amount){
//                    $product_variant_amount->is_approved = 0;
//                    $product_variant_amount->save();
//                }
//
//            }
        }
        flash('تم تعديل الكميات بنجاح');
        return redirect(route('system.products.index'));
    }

    public function uploadImageAjax(Request $request){

        $product_variant = ProductVariant::find($request->product_id_upload);
        if($request->has('multi_images')){
            $images = $request->multi_images;
          //  \HELPER::deleteUnUsedFile($images);
$product_image = new ProductImage();
$product_image->product_id=$request->product_id?$request->product_id:$product_variant->product_id;
$product_image->product_variant_id=$product_variant?$product_variant->id:null;
$product_image->image=$images;
$product_image->save();
$product_image->refresh();

        }
        return response()->json(['success' => $request->product_id_upload,'file'=>$product_image], 200);
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
            $o = ProductVariant::find($id);
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
            $o = ProductVariant::find($id);
            $o->status=2;
            $o->save();
        }
        return ['done' => 1];

    }

}
