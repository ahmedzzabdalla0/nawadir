<?php

namespace App\Http\Controllers;


use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{



    public function index()
    {
        $pages = Page::query()->where('id','<',3)->get();
        return view('system_admin.pages.pageSelect', compact('pages'));

    }

    public function showCreateView()
    {
        dd('no create');

        return null;
    }


    public function showUpdateView($id)
    {
        $page = Page::findOrFail($id);
        return view('system_admin.pages.page', compact('page'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'title_ar'=>'required',
            'text_ar'=>'required',
//            'text_en'=>'required',
        ]);

        if ($page = Page::where('id', $id)->first()) {

            $page->title_ar =$request->title_ar;
            $page->title_en =$request->title_ar;
            $page->text_ar =$request->text_ar;
            $page->text_en =$request->text_ar;
            $page->save();
        } else {
            flash('هناك مشكلة ما');
            return back();
        }
        flash('تم التعديل بنجاح');

        return redirect(route('system.pages.index'));
    }


}
