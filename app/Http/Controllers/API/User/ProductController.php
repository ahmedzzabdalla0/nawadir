<?php


namespace App\Http\Controllers\API\User;
 

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Resources\UserRateResource;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\UserFavorite;
use App\Models\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{


    private function getUserArray()
    {
        $arr = ['addresses'];
        return $arr;
    }

    private function getProductArray($appends='')
    {
        $arr = ['category','images','variants'];
        if($appends){
            foreach ($arr as $a){
                $new[]=$appends.'.'.$a;
            }
            $arr=$new;
        }
        return $arr;
    }

    /**
     * @OA\Get(
     *      path="/user/get_home",
     *      operationId="getHome",
     *      tags={"GetData"},
     *      summary="Get app home API",
     *      description="Get app home service",
     *      @OA\Parameter(
     *          name="user_id",
     *          description="user id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and offers,categories,recent arraies"
     *       ),
     * )
     */
    public function getHome(Request $request){
//->with(['products'=>function($q){
//            $q->with(['category','images','variants'])->orderBy('id','asc');
//        }])
        $categories = Category::query()->where('status',1)->orderBy('sorted','asc')->get();
        foreach ($categories as $category){
            $category['products']=Product::with(['category','images','variants'])->where('category_id',$category->id)->where('status',1)->orderBy('id','asc')->limit(4)->get();
        }

        return ControllersService::generateArraySuccessResponse(compact('categories'));
    }

    /**
     * @OA\Get(
     *      path="/user/get_products",
     *      operationId="getProducts",
     *      tags={"GetData"},
     *      summary="Get products API",
     *      description="Get products api *paginging 4 items in each page *to use for filter products send the data to filter",
     *     @OA\Parameter(
     *          name="page",
     *          description="page number, in case if use in home page start it 2 to get second page after the four shown products",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *        @OA\Parameter(
     *          name="category_id",
     *          description="category_id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *       @OA\Parameter(
     *          name="name",
     *          description="name string",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and products array"
     *       ),
     * )
     */
    public function getProducts(Request $request)
    {
        $page = 0;
        $per_page = 4;
        if ($request->page) {
            if ($request->page > 1) {
                $page = $request->page - 1;
            }
        }
        $pro=Product::with($this->getProductArray())->where('status',1)->orderBy('id','DESC');
        if($request->category_id){
            $pro->where('category_id',$request->category_id);
        }

        if($request->name){
            $name = '%'.$request->name.'%';
            $pro->where(function ($q)use($name){
                $q->where('name_ar','like',$name)
                    ->orWhere('name_en','like',$name);
            });
        }

        $produ=$pro->take($per_page+1)->offset(($per_page * $page))->get();

        $has_more = false;
        if(count($produ)>$per_page){
            $has_more=true;
            $products = $produ->forPage(1, $per_page);

        }else{
            $products=$produ;
        }
        return ControllersService::generateArraySuccessResponse(compact('products'),'default_message',$has_more);
    }


    /**
     * @OA\Get(
     *      path="/user/get_product_details",
     *      operationId="getProductDetails",
     *      tags={"GetData"},
     *      summary="Get product details API",
     *      description="Get product details api",
     *     @OA\Parameter(
     *          name="product_id",
     *          description="product_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and product object"
     *       ),
     * )
     */
    public function getProductDetails(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
        ]);
        $product=Product::with($this->getProductArray())->find($request->product_id);
        return ControllersService::generateArraySuccessResponse(compact('product'),'default_message');


    }


    /**
     * @OA\Post(
     *      path="/user/add_remove_fav",
     *      operationId="add_remove_fav",
     *      tags={"PostData"},
     *      summary="add the product to faverate in it not in and remove ite if it exist",
     *      description="add the product to faverate in it not in and remove ite if it exist",
     *     security={{ "default": {}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                required={"product_id","user_id"},
     *                     @OA\Property(
     *                     property="user_id",
     *                     description="user id",
     *                     type="number",
     *                 ), @OA\Property(
     *                     property="product_id",
     *                     description="product id",
     *                     type="number",
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="X-Authorization",
     *          description="Bearer Token",
     *          required=true,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true along with message"
     *       ),
     *      @OA\Response(response=422, description="product not found"),
     * )
     */
    public function add_remove_fav(Request $request)
    {

        $request->validate( [
            'product_id' => 'required',

        ]);
        if ($product = Product::where('id', $request->product_id)->first()) {
            if ($u = UserFavorite::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first()) {
                $u->delete();
//                $user_data=User::find($request->user_id);

                return ControllersService::generateArraySuccessResponse(null, 'deleted_from_fav');
            }
            $u = new UserFavorite();
            $u->user_id = $request->user_id;
            $u->product_id = $request->product_id;
            $u->save();

            return ControllersService::generateArraySuccessResponse(null, 'added_to_fav');

        }
        return ControllersService::generateGeneralResponse(false, 'product_not_found', null, 422);




    }
    
       public function delete_cart(Request $request)
    {

        $request->validate( [
            'user_id' => 'required',

        ]);
  Cart::where('user_id', $request->user_id)->delete();

            return ControllersService::generateArraySuccessResponse(null, 'added_to_cart');

     




    }
    
    public function add_remove_cart(Request $request)
    {

        $request->validate( [
            'product_id' => 'required',

        ]);
        //  `user_id`, `product_id`, `product_variant_id`, `quantity`, `cut_type_id`, `cover_type_id`, `is_slaughtered`,
        if ($product = Product::where('id', $request->product_id)->first()) {
           
            if ($u = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first()) {
                if($request->action == 'delete' || $request->quantity == 0){
                                                        $u->delete();
                 return ControllersService::generateArraySuccessResponse(null, 'deleted_from_cart');


                }
                if($request->quantity > 1){
                    $u->quantity = $request->quantity;
            $u->cut_type_id = $request->cut_type_id ;
            $u->cover_type_id = $request->cover_type_id ;
            $u->is_slaughtered = $request->is_slaughtered ;
            $u->product_variant_id = $request->product_variant_id;
                    $u->save();
                                    return ControllersService::generateArraySuccessResponse(null, 'added_to_cart');

                }
            }
            $u = new Cart();
            $u->user_id = $request->user_id;
            $u->product_id = $request->product_id;
            $u->quantity = $request->quantity ?? 1;
            $u->cut_type_id = $request->cut_type_id ;
            $u->cover_type_id = $request->cover_type_id ;
            $u->is_slaughtered = $request->is_slaughtered ;
            $u->product_variant_id = $request->product_variant_id;

            $u->save();

            return ControllersService::generateArraySuccessResponse(null, 'added_to_cart');

        }
        return ControllersService::generateGeneralResponse(false, 'product_not_found', null, 422);




    }
    /**
     * @OA\Get(
     *      path="/user/get_user_favorite",
     *      operationId="getUserFav",
     *      tags={"GetData"},
     *      summary="Get favorite products API",
     *      description="Get favorite products api",
     *        @OA\Parameter(
     *          name="user_id",
     *          description="user_id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="language",
     *          description="language ar|en",
     *          required=false,
     *          in="header",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation with status = true and products array"
     *       ),
     * )
     */
    public function getUserFav(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);
        $ids = UserFavorite::where('user_id', $request->user_id)->pluck('product_id')->toArray();

        $products = Product::with($this->getProductArray())
            ->whereIn('id', $ids)
            ->where('status',1)
            ->get();
        return ControllersService::generateArraySuccessResponse(compact('products'));

    }
    public function getUserCart(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);
        $ids = Cart::where('user_id', $request->user_id)->pluck('product_id')->toArray();

        // $products = Product::with($this->getProductArray())
        //     ->whereIn('id', $ids)
        //     ->where('status',1)
        $tax = Settings::where('name', 'tax')->first()->value or 0;
        $slaughter_cost = Settings::where('name', 'slaughter_cost')->first()->value or 0;
             $products =  DB::table('cart')
            ->join('products', 'products.id', '=', 'cart.product_id')
                        ->join('product_images', 'products.id', '=', 'product_images.product_id')
                        ->join('product_variants', 'cart.product_variant_id', '=', 'product_variants.id')
                        ->join('variants','cart.cut_type_id', '=', 'variants.id')
                      ->select('products.id','cart.product_id','cart.cut_type_id','cart.cover_type_id','cart.is_slaughtered','cart.product_variant_id', 'products.name_ar','cart.quantity' ,'products.price' ,'products.type', 'product_images.image','variants.name_ar as cut_name' ,
                      'product_variants.weight','product_variants.weight_to' ,'product_variants.price as vprice')->where('cart.user_id', $request->user_id)->groupby('cart.id')

            ->get();
            $price = 0;
            foreach($products as $p){
                $price += $p->vprice * $p->quantity;
            }
            
            
               $total_slaughter_cost = $slaughter_cost;
        $total_price = round(($price+$total_slaughter_cost) * (1 + ($tax / 100)), 2);
        $tax_price = round(($price+$total_slaughter_cost) * (($tax / 100)), 2);
            
            
            
        return ControllersService::generateArraySuccessResponse(compact('products','tax_price','total_price'));

    }



}
