<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    use  Message_Trait;

    public function index(Request $request)
    {
        $terms = Term::first();
        if ($request->isMethod('post')){
            $data = $request->all();
           $terms->update([
               'terms'=>$data['terms']
           ]);
           return $this->success_message(' تم تعديل الشروط بنجاح  ');
        }


        return view('admin.terms.index',compact('terms'));
    }
}
