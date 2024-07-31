<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faqs.index', compact('faqs'));
    }
    public function store(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'title' => 'required|min:10',
                    'desc' => 'required|min:10',
                ];
                $messages = [
                    'title.required' => ' من فضلك ادخل العنوان  ',
                    'title.min' => ' العنوان يجب ان يكون اكثر من 10 احرف  ',
                    'desc.required' => ' من فضلك ادخل اجابة السوال  ',
                    'desc.min' => ' يجب ان يكون اجابة السوال اكبر من 10 احرف  ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $faq = new Faq();
                $faq->create([
                    'title' => $data['title'],
                    'desc' => $data['desc'],
                ]);
                return $this->success_message('  تم اضافة السوال بنجاح   ');
            }
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
        return view('admin.faqs.store');
    }
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'title' => 'required|min:10',
                    'desc' => 'required|min:10',
                ];
                $messages = [
                    'title.required' => ' من فضلك ادخل العنوان  ',
                    'title.min' => ' العنوان يجب ان يكون اكثر من 10 احرف  ',
                    'desc.required' => ' من فضلك ادخل اجابة السوال  ',
                    'desc.min' => ' يجب ان يكون اجابة السوال اكبر من 10 احرف  ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                $faq->update([
                    'title' => $data['title'],
                    'desc' => $data['desc'],
                ]);
                return $this->success_message('  تم تعديل السوال بنجاح   ');
            }
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }

        return view('admin.faqs.update', compact('faq'));
    }
    public function delete($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return $this->success_message(' تم حذف السوال بنجاح   ');
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }

    }
}
