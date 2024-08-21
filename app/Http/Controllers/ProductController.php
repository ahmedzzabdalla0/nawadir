<?php

namespace App\Http\Controllers;

use App\Events\SendUsersNotification;
use App\Helpers\UUID;
use App\Models\Category;
use App\Models\GlobalNotification;
use App\Models\ImageType;
use App\Models\Product;
use App\Models\ProductAmountLog;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Settings;
use App\Models\Variant;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    //

    public function index(Request $request)
    {

        $o=Product::orderBy('id','DESC');
        if($request->name){
            $name = $request->name;
            $o->where(function ($q)use($name){
                $q->where('name_ar','like','%'.$name."%")
                    ->orWhere('name_en','like','%'.$name."%");
            });

        }
        if($request->category_id > 0){
            $o->where("category_id",$request->category_id);
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

        if($request->size_id>0){
           $product_ids = ProductVariant::where('size_id',$request->size_id)->pluck('product_id')->toArray();
           $o->whereIn('id',$product_ids);
        }
        if($request->min_weight>0){
           $product_ids = ProductVariant::where('weight','>=',$request->min_weight)->pluck('product_id')->toArray();
           $o->whereIn('id',$product_ids);
        }
        if($request->max_weight>0){
           $product_ids = ProductVariant::where('weight_to','<',$request->max_weight)->pluck('product_id')->toArray();
           $o->whereIn('id',$product_ids);
        }

        $out = $o->paginate(15);
        $out->appends($request->all());
        $categories = Category::query()->get();
        $sizes = Variant::query()->where('variant_type_id',1)->get();
        return view('system_admin.products.index', compact('out','categories','sizes'));

    }



    public function showCreateView()
    {
        $categories = Category::all();
        $delivery_price_type = Settings::where('name', 'delivery_price_type')->first()->value;
        $sizes = Variant::query()->where('variant_type_id',1)->get();
        return view('system_admin.products.create2', compact('categories','delivery_price_type','sizes'));


    }


    public function create(Request $request)
    {
        $delivery_price_type = Settings::where('name', 'delivery_price_type')->first()->value;

        $roles = [
            'name_ar' => ['required',new ValidStringArabic(),'max:30',Rule::unique('products')],
            'name_en' => ['required','max:30',Rule::unique('products')],
            'ratio' => 'required|numeric|min:0|max:100',
            'price' => 'required|numeric|min:1|max:99999',
            'category_id' => 'required|exists:categories,id',
            'details_ar' => 'required',
            'details_en' => 'required',
        ];
        if($request->category_id == 1){
            $roles['size_id.*']=['required','integer'];
            $roles['size_unit_price.*']=['required','integer','min:1'];
        }
        if($request->category_id != 1){
            $roles['weight_from.*']=['required','integer'];
            $roles['weight_to.*']=['required','integer'];
            $roles['weight_unit_price.*']=['required','integer','min:1'];
        }
        if($delivery_price_type == 3){$roles['delivery_price']='required|numeric';}

        $this->validate($request, $roles);

        $imageTypes=ImageType::all();
        foreach ($imageTypes as $t){

            if($t->is_required && !$request->has($t->name.'_image')){
                return back()->withInput($request->all())->withErrors(['images'=>'الرجاء اضافة جميع الصور المطلوبة']);
            }

        }

        $object = new Product();
        $object->name_en = $request->name_en;
        $object->name_ar = $request->name_ar;
        $object->details_ar = $request->details_ar;
        $object->details_en = $request->details_en;
        $object->discount_ratio = $request->ratio;
        $object->price = $request->price;
        $object->delivery_price = $request->delivery_price??null;
        $object->p_code = UUID::generate(6, Product::class, 'p_code', 'R');
        $object->category_id = $request->category_id;
        $object->is_slider = $request->has('slider_check')?1:0;
        $object->status = 1;
                $object->type = $request->has('type')?1:0;

        $object->save();
        $object->refresh();
        $default_image_id = 0;


        $imageTypes=ImageType::all();
        $imagesToSave=[];
        foreach ($imageTypes as $t){

            if($request->has($t->name.'_image') &&$request->get($t->name.'_image')){
                $pImage=new ProductImage();
                $pImage->product_id=$object->id;
                $pImage->image=$request->get($t->name.'_image');
                $pImage->type=$t->id;
                $pImage->save();
                if($t->name=='logo'){
                    $default_image_id=$pImage->id;
                }
                $imagesToSave[]=$request->get($t->name.'_image');

            }
        }
        \HELPER::deleteUnUsedFile($imagesToSave);
        if($request->det_images){
            $p_images=json_decode(trim($request->det_images));
            \HELPER::deleteUnUsedFiles($p_images);
            foreach ($p_images as $m){
                    $pImage=new ProductImage();
                    $pImage->product_id=$object->id;
                    $pImage->image=$m;
                    $pImage->is_main=0;
                    $pImage->save();
            }
        }
        if($request->category_id == 1){
            $sizes = $request->size_id;
            $unit_prices = $request->size_unit_price;
            for($i = 0;$i<count($sizes);$i++){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('size_id',$sizes[$i])->where('is_deleted',0)->first();
                if(!$product_variant){
                    $product_variant = new ProductVariant();
                    $product_variant->product_id = $object->id;
                    $product_variant->size_id = $sizes[$i];
                    $product_variant->price = $unit_prices[$i];
                    $product_variant->status = 1;
                    $product_variant->save();
                }

            }
            if(count($sizes) == 1){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('is_deleted',0)->first();
                if($product_variant){
                    $product_variant->price = $request->price;
                    $product_variant->save();
                }
            }
        }else{
            $weights_from = $request->weight_from;
            $weights_to = $request->weight_to;
            $unit_prices = $request->weight_unit_price;
            for($i = 0;$i<count($weights_from);$i++){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('weight',$weights_from[$i])->where('is_deleted',0)->first();
                if(!$product_variant){
                    $product_variant = new ProductVariant();
                    $product_variant->product_id = $object->id;
                    $product_variant->weight = $weights_from[$i];
                    $product_variant->weight_to = $weights_to[$i];
                    $product_variant->price = $unit_prices[$i];
                    $product_variant->status = 1;
                    $product_variant->save();
                }

            }
            if(count($weights_from) == 1){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('is_deleted',0)->first();
                if($product_variant){
                    $product_variant->price = $request->price;
                    $product_variant->save();
                }
            }
        }


        if($request->has('notification_check')){
            $notification = new GlobalNotification();
            $notification->title = 'تم اضافة منتج جديد '.$object->name;
            $notification->message = 'تم اضافة منتج جديد '.$object->name;
            $notification->system_admin_id = Auth::guard('system_admin')->user()->id;
            $notification->save();
            $notification->fresh();
            $user=User::all();
            event(new SendUsersNotification($user,  'AdminNotification',  ['global_notification'=>$notification->id,'image'=>$object->notification_image?$object->notification_image:$object->image_url],1,1,$object->notification_image?$object->notification_image:$object->image_url));
        }
        flash('تمت الاضافة بنجاح');
//        if(count($sizes)+count($metrics)+count($colors)==0 && count($object->variants)==1){
            return redirect(route('system.products.index'));
//        }else{
//            return redirect(route('system.product_variants.showAddedVariants',['id'=>$object->id]));
//        }

    }
    public function showUpdateView($id)
    {
        $categories = Category::all();
        $delivery_price_type = Settings::where('name', 'delivery_price_type')->first()->value;
        $sizes = Variant::query()->where('variant_type_id',1)->get();

        $out=Product::find($id);
        return view('system_admin.products.update2', compact('out','categories','delivery_price_type','sizes'));
    }


    public function update(Request $request,$id)
    {
        $delivery_price_type = Settings::where('name', 'delivery_price_type')->first()->value;

        $roles = [
            'name_ar' => ['required',new ValidStringArabic(),'max:30',Rule::unique('products')->whereNot('id',$id)],
            'name_en' => ['required','max:30',Rule::unique('products')->whereNot('id',$id)],
            'ratio' => 'required|numeric|min:0|max:100',
            'price' => 'required|numeric|min:1|max:99999',
            'category_id' => 'required|exists:categories,id',
            'details_ar' => 'required',
            'details_en' => 'required',
        ];
        if($request->category_id == 1){
            $roles['size_id.*']=['required','integer'];
            $roles['size_unit_price.*']=['required','integer','min:1'];
        }
        if($request->category_id != 1){
            $roles['weight_from.*']=['required','integer'];
            $roles['weight_to.*']=['required','integer'];
            $roles['weight_unit_price.*']=['required','integer','min:1'];
        }
        if($delivery_price_type == 3){$roles[ 'delivery_price']='required|numeric';}


        $this->validate($request,$roles );
        $object = Product::find($id);
        $old_category_id = $object->category_id;
        $object->name_en = $request->name_en;
        $object->name_ar = $request->name_ar;
        $object->details_ar = $request->details_ar;
        $object->details_en = $request->details_en;
        $object->discount_ratio = $request->ratio;
        $object->price = $request->price;
        $object->delivery_price = $request->delivery_price??null;
        $object->category_id = $request->category_id;
        $object->is_slider = $request->has('slider_check')?1:0;
                        $object->type = $request->has('type')?1:0;

        $object->save();
        $object->refresh();
        $default_image_id = 0;
        $imageTypes=ImageType::all();
        $imagesToSave=[];
        foreach ($imageTypes as $t){

            if($request->has($t->name.'_image') &&$request->get($t->name.'_image')){
                if($pImage=ProductImage::where('product_id',$object->id)->where('type',$t->id)->first()){
                    $pImage->image=$request->get($t->name.'_image');
                    $pImage->save();
                }else{
                    $pImage=new ProductImage();
                    $pImage->product_id=$object->id;
                    $pImage->image=$request->get($t->name.'_image');
                    $pImage->type=$t->id;
                    $pImage->save();
                }
                $imagesToSave[]=$request->get($t->name.'_image');

                if($t->name=='logo'){
                    $default_image_id=$pImage->id;
                }

            }
        }
        \HELPER::deleteUnUsedFile($imagesToSave);
        $sizes = $request->size_id;
        $weights_from = $request->weight_from;
        $weights_to = $request->weight_to;
        if($old_category_id != $request->category_id){
            $old_vars = ProductVariant::where('product_id',$object->id)->get();
            foreach ($old_vars as $dp){
                if($dp->can_del){
                    $dp->delete();
                }else{
                    $dp->is_deleted =1;
                    $dp->save();
                }
            }
        }
        if($request->category_id == 1){

            $unit_prices = $request->size_unit_price;
            for($i = 0;$i<count($sizes);$i++){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('size_id',$sizes[$i])->where('is_deleted',0)->first();
                if(!$product_variant){
                    $product_variant = new ProductVariant();
                    $product_variant->product_id = $object->id;
                    $product_variant->size_id = $sizes[$i];
                    $product_variant->price = $unit_prices[$i];
                    $product_variant->status = 1;
                    $product_variant->save();
                }else{
                    $product_variant->price = $unit_prices[$i];
                    $product_variant->status = 1;
                    $product_variant->save();
                }
            }
            $deletable_product_variants = ProductVariant::where('product_id',$object->id)->whereNotIn('size_id',$sizes)->get();
            foreach ($deletable_product_variants as $dp){
                if($dp->can_del){
                    $dp->delete();
                }else{
                    $dp->is_deleted =1;
                    $dp->save();
                }
            }
            if(count($sizes) == 1){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('is_deleted',0)->first();
                if($product_variant){
                    $product_variant->price = $request->price;
                    $product_variant->save();
                }
            }
        }else{
$exist =[];
            $unit_prices = $request->weight_unit_price;
            for($i = 0;$i<count($weights_from);$i++){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('weight',$weights_from[$i])->where('weight_to',$weights_to[$i])->where('is_deleted',0)->first();
                $product_variant_null = ProductVariant::where('product_id',$object->id)->where('weight',$weights_from[$i])->whereNull('weight_to')->where('is_deleted',0)->first();
                if(!$product_variant && !$product_variant_null){
                    $product_variant = new ProductVariant();
                    $product_variant->product_id = $object->id;
                    $product_variant->weight = $weights_from[$i];
                    $product_variant->weight_to = $weights_to[$i];
                    $product_variant->price = $unit_prices[$i];
                    $product_variant->status = 1;
                    $product_variant->save();
                    $exist[]=$product_variant->id;
                }else{
                    if($product_variant_null){
                        $product_variant_null->weight_to = $weights_to[$i];
                        $product_variant_null->price = $unit_prices[$i];
                        $product_variant_null->status = 1;
                        $product_variant_null->save();
                        $exist[]=$product_variant_null->id;
                    }
                    if($product_variant){
                        $product_variant->price = $unit_prices[$i];
                        $product_variant->status = 1;
                        $product_variant->save();
                        $exist[]=$product_variant->id;
                    }

                }
            }
            $deletable_product_variants = ProductVariant::where('product_id',$object->id)->whereNotIn('id',$exist)->get();
            foreach ($deletable_product_variants as $dp){
                if($dp->can_del){
                    $dp->delete();
                }else{
                    $dp->is_deleted =1;
                    $dp->save();
                }
            }
            if(count($weights_from) == 1){
                $product_variant = ProductVariant::where('product_id',$object->id)->where('is_deleted',0)->first();
                if($product_variant){
                    $product_variant->price = $request->price;
                    $product_variant->save();
                }
            }
        }


        flash('تم التعديل بنجاح');

        return redirect(route('system.products.index'));
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
            $o = Product::find($id);
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
            $o = Product::find($id);
            $o->status=2;
            $o->save();
        }
        return ['done' => 1];

    }

    public function change_offer_status(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Product::find($id);
            $o->is_offer=$o->is_offer==1?0:1;
            $o->save();
        }
        return ['done' => 1];

    }
    public function change_slider_status(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Product::find($id);
            $o->is_slider=$o->is_slider==1?0:1;
            $o->save();
        }
        return ['done' => 1];

    }
    public function change_recent_status(Request $request)
    {
        $ids=[];
        if (is_array($request->id)) {
            $ids=$request->id;
        } else {
            $ids[]=$request->id;

        }
        foreach ($ids as $id) {
            $o = Product::find($id);
            $o->in_recent=$o->in_recent==1?0:1;
            $o->save();
        }
        return ['done' => 1];

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
            $s=Product::find($id);
            $i=0;
            if($s->can_del){

                foreach ($s->images as $i){

                    try{
                        unlink("./uploads/".$i->image);

                    }catch (\Exception $e){}
                    $i->delete();
                }
                $s->variants()->delete();
                $s->forceDelete();
                $i++;
            }

        }
        return ['done'=>$i];


    }


    public function delete_image(Request $request)
    {
        $image=ProductImage::find($request->image);
        if(is_null($image->type)){
            $place=$image->product_id;
            try{
                unlink("./uploads/".$image->image);

            }catch (\Exception $e){}
            $image->delete();
            $out=Product::find($place);
            $view = \View::make('system_admin.products.images', compact('out'));
            $output=$view->render();
            return ['out'=>$output,'status'=>1];
        }
        return ['out'=>null,'status'=>0,'msg'=>'لا يمكن حذف الصورة لأنها مضافة لأحد المنتجات'];
    }
    public function delete_image1(Request $request)
    {
        $image=ProductImage::find($request->image);
        if(is_null($image->type)){
            $place=$image->product_id;
            try{
                unlink("./uploads/".$image->image);

            }catch (\Exception $e){}
            $image->delete();
            $out=Product::find($place);
            $view = \View::make('system_admin.products.images1', compact('out'));
            $output=$view->render();
            return ['out'=>$output,'status'=>1];
        }
        return ['out'=>null,'status'=>0,'msg'=>'لا يمكن حذف الصورة لأنها مضافة لأحد المنتجات'];
    }

    public function saveMultiFileJson(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);
        $place=$request->place;
        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $file){
                if($name=MediaController::SaveFileM($file)){

                        $pImage=new ProductImage();
                        $pImage->product_id=$place;
                        $pImage->image=$name;
                        $pImage->is_main=0;
                        $pImage->save();

                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            $out=Product::find($place);
            $view = \View::make('system_admin.products.images', compact('out'));
            $output=$view->render();
            return ['out'=>$output,'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }
    public function saveMultiFileJson1(Request $request)
    {
        $this->validate($request,['uploaded_files.*'=>'image']);
        $place=$request->place;
        if(is_array($request->uploaded_files)){
            foreach ($request->uploaded_files as $file){
                if($name=MediaController::SaveFile($file)){

                        $pImage=new ProductImage();
                        $pImage->product_id=$place;
                        $pImage->image=$name;
                        $pImage->is_main=0;
                        $pImage->save();

                }else{
                    return ['status'=>0,'errors'=>'ERROR'];
                }
            }

            $out=Product::find($place);
            $view = \View::make('system_admin.products.images1', compact('out'));
            $output=$view->render();
            return ['out'=>$output,'status'=>1];
        }

        return ['status'=>0,'errors'=>'ERROR'];

    }

    public function defaultIMG(Request $request)
    {
        $image = ProductImage::find($request->image);
        $place = $image->product_id;
        $oldDef = ProductImage::where('product_id', $place)->where('is_main', 1)->get();
        foreach ($oldDef as $o) {
            $o->is_main = 0;
            $o->save();
        }

        $image->is_main = 1;
        $image->save();


        $out = Product::find($place);
        $view = \View::make('system_admin.products.images', compact('out'));
        $output = $view->render();
        return ['out' => $output, 'status' => 1, 'default' => url('uploads/' . $image->image)];

    }

    public function getProductImages(Request $request){
        $id = request('id');
        $product = Product::find($id);
        $images =ProductImage::where('product_id',$product->id)->get();
        return ControllersService::generateArraySuccessResponse(compact('images'), 'default_message');

    }
    public function productLogs(Request $request,$id){
        $product = Product::find($id);
        if(!$product){
            flash('المنتج المطلوب غير موجود');
            return redirect()->back();
        }
        $logs_query = $product->productLogs()->where('is_approved',1);
        if($request->product_variant_id>0){
            $logs_query->where('product_variant_id',$request->product_variant_id);
        }
        $out = $logs_query->paginate(15);
        $product_variants = $product->variants()->where('is_default',0)->get();

        return view('system_admin.products.product_logs', compact('out','product','product_variants'));


    }
    public function showCreateLogView(Request $request,$id){
        $product = Product::find($id);
        $product_variants = $product->variants;
        if(!$product){
            flash('المنتج المطلوب غير موجود');
            return redirect()->back();
        }
        return view('system_admin.products.add_product_log', compact('product','product_variants'));
    }

    public function createProductLog(Request $request){

        $date = Carbon::now()->toDateString();
        $request->validate([
            'product_id'=>'integer|exists:products,id',
            'product_variant_id'=>'integer|exists:product_variants,id',
            'qty'=>'integer|min:1',
            'price'=>'numeric|min:0.5',
            'type'=>'string',
            'note'=>'nullable|string',
        ]);

        $product = Product::find($request->product_id);
        $product_variant_id = $product->variants()->where('is_default',1)->first()?$product->variants()->where('is_default',1)->first()->id:0;
if($request->product_variant_id>0){
    $product_variant_id=$request->product_variant_id;
}
        $product->productLogs()->create([
            'product_id'=>$product->id,
            'product_variant_id'=>$product_variant_id,
            'amount'=>$request->qty,
            'price'=>$request->price,
            'type'=>$request->type,
            'is_approved'=>1,
            'note'=>$request->note??'حركة على المخزون'
        ]);
        return redirect()->route('system.products.productLogs',$product->id);
    }

}
