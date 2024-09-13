<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\TraderMark;
use Illuminate\Http\Request;

class TradeMarkController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $tradermarks = \App\Models\admin\TraderMark::all();
        return view('admin.trademarks.index', compact('tradermarks'));
    }
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            // الحصول على البيانات من الطلب
            $data = $request->all();

            // استخدام create بشكل صحيح على النموذج
            TraderMark::create([
                'name' => $data['name'],
                'types' => $data['types'],
            ]);

            // إرسال رسالة النجاح
            return $this->success_message('تم إضافة العلامة بنجاح');
        }
        return view('admin.trademarks.store');
    }

    public function update(Request $request,$id)
    {
        $trademark = TraderMark::findOrFail($id);
        if ($request->isMethod('post')){
            $data = $request->all();
            $trademark->update([
                'name'=>$data['name'],
                'types'=>$data['types'],
            ]);
            return $this->success_message(' تم التعديل بنجاح  ');
        }
        return view('admin.trademarks.update',compact('trademark'));
    }

    public function delete($id)
    {
        $trademark = TraderMark::findOrFail($id);
        $trademark->delete();
        return $this->success_message(' تم حذف العلامة بنجاح  ');
    }
}
