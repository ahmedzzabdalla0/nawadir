<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BankController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => ['required','string',
                Rule::unique('banks','name'),
                new ValidStringArabic()
            ],
            'iban' => ['required','string',
                Rule::unique('banks','iban'),
                new ValidString()
            ]
        ]);
        $n_bank= new Bank();
        $n_bank->name=$request->name;
        $n_bank->iban=$request->iban;
        $n_bank->status=1;
        $n_bank->save();
        flash('تم اضافة بيانات البنك بنجاح');
        return redirect()->route('system.settings.index',['type'=>'banks']);
    }
    public function Update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'name' => ['required','string',
                Rule::unique('banks','name')->ignore($id),
                new ValidStringArabic()
            ],
            'iban' => ['required','string',
                Rule::unique('banks','iban')->ignore($id),
                new ValidString()
            ]
        ]);

        $n_bank= Bank::findOrFail($id);
        $n_bank->name=$request->name;
        $n_bank->iban=$request->iban;
        $n_bank->save();
        flash('تم تعديل بيانات البنك بنجاح');

        return redirect()->route('system.settings.index',['type'=>'banks']);
    }
    public function delete(Request $request)
    {
        if(is_array($request->id)){
            foreach ($request->id as $id) {
                $bank= Bank::find($id);
                $bank->delete();
                // AdminPrice::destroy($id);
            }
            return ['done'=>1];
        }else{
            $bank= Bank::find($request->id);
            $bank->delete();
            //  $isDeleted = AdminPrice::destroy($request->id);
            return ['done'=>1];
        }

    }
}
