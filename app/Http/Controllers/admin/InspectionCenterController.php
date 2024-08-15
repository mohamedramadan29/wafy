<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\InsepctionCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InspectionCenterController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $centers = InsepctionCenter::all();
        return view('admin.inspectioncenter.index',compact('centers'));
    }
    public function store(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'name'=>'required',
                'status'=>'required',
            ];
            $messages = [
                'name.required'=>' من فضلك ادخل اسم مركز الصيانة  ',
                'status.required'=>' من فضلك حدد الحالة  '
            ];
            $validator = Validator::make($data,$rules,$messages);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $center = new InsepctionCenter();
            $center->create([
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'address'=>$data['address'],
                'status'=>$data['status'],
            ]);
            return $this->success_message(' تم اضافة مركز الصيانة بنجاح  ');
        }
        return view('admin.inspectioncenter.store');
    }
    public function update(Request $request,$id)
    {
        $center = InsepctionCenter::findOrFail($id);
        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'name'=>'required',
                'status'=>'required',
            ];
            $messages = [
                'name.required'=>' من فضلك ادخل اسم مركز الصيانة  ',
                'status.required'=>' من فضلك حدد الحالة  '
            ];
            $validator = Validator::make($data,$rules,$messages);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $center->update([
                'name'=>$data['name'],
                'phone'=>$data['phone'],
                'address'=>$data['address'],
                'status'=>$data['status'],
            ]);
            return $this->success_message(' تم تعديل مركز الصيانة بنجاح  ');
        }
        return view('admin.inspectioncenter.update',compact('center'));
    }
    public function delete($id)
    {
        $center = InsepctionCenter::findOrFail($id);
        $center->delete();
        return $this->success_message(' تم الحذف بنجاح  ');
    }
}
