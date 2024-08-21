<?php

namespace App\Http\Controllers;

use App\Models\AdminRule;
use App\Models\Area;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use App\Models\WorkEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SystemAdminController extends Controller
{
    //
    private $isApiRequest;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware('auth:system_admin');
        $this->isApiRequest = ControllersService::isApiRoute($request);
    }

    public function home()
    {
        if (! Auth::guard('system_admin')->user()->hasRole('view','dashboard')) {
            $rm=AdminRule::where('admin_id', Auth::guard('system_admin')->user()->id)->where('rule_id',1)->orderBy('module_id','Asc')->first();

            if($rm){
                if(route('system.'.$rm->Module->name.'.index')){
                    return redirect()->route('system.'.$rm->Module->name.'.index');
                }
            }
            return view('system_admin.blank');

        }
        $c1=User::count();
        $c2=Order::paid()->count();
        $c3=Product::count();
        $c4=Contact::count();
        $c5=Order::paid()->count();
        $c6=Order::paid()->whereIn('case_id',[1,2])->count();
        $c7=Order::paid()->whereIn('case_id',[3,4])->count();
        $c8=Order::paid()->whereIn('case_id',[6])->count();

        $topProducts=Product::withCount('orders')->has('orders')->orderBy('orders_count','DESC')->take(2)->get();
        $topUsers=User::withCount('orders')->has('orders')->orderBy('orders_count','DESC')->take(5)->get();
        $ordercount=[];
        $MonthName=[];
        $labels=[
            "يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "اغسطس", "سبتمبر", "اكتوبر", "نوفمبر", "ديسمبر",

        ];
        $start=Carbon::now()->subMonths(6)->startOfMonth();
        for ($i=1;$i<9;$i++){
            $count=Order::paid()->whereBetween('created_at',[$start->startOfMonth()->toDateTimeString(),$start->endOfMonth()->toDateTimeString()])->count();
            $ordercount[]=$count;
            $MonthName[]=$labels[$start->month - 1];
            $start->startOfMonth()->addMonth();
        }
        $now=Carbon::now();
        $neworders=Order::paid()->where('created_at','>=',$now->subDays(20)->toDateTimeString())->orderBy('id','DESC')->take(6)->get();

        $or1=Order::paid()->whereIn('case_id',[1,2,3,4])->count();
        $or2=Order::paid()->whereIn('case_id',[5])->count();
        $or3=Order::paid()->whereIn('case_id',[6])->count();

        $ototal=$or1+$or2+$or3;
        if($ototal == 0){
            $ototal=1;
        }
        $newProducts=Product::where('created_at','>=',$now->subDays(20)->toDateTimeString())->orderBy('id','DESC')->take(6)->get();
        $showCalender=false;///for calender
        $orders=[];///for calender

        return view('system_admin.dashboard',compact('showCalender','newProducts','orders','ototal','c1','c2','c3','c4','c5','c6','c7','c8','topProducts','ordercount','MonthName','topUsers','neworders','or1','or2','or3'));

    }
    public function generalProperties(Request $request){
        $categories = Category::query()->count();
        $areas = Area::query()->count();
        $sizes = Variant::query()->where('variant_type_id',1)->count();
        $cut_types= Variant::query()->where('variant_type_id',2)->count();
        return view('system_admin.general_properties',compact('categories','areas','sizes','cut_types'));
    }

}
