<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\InsepctionCenter;
use App\Models\admin\InspectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InspectionTypeController extends Controller
{

    use Message_Trait;

    public function index($centerid)
    {
        if (Auth::guard('center')->check()){

            $center = Auth::guard('center')->user();
            if (Auth::guard('center')->id() != $centerid){
                abort(404);
            }
        }elseif (Auth::check()){
            $center = InsepctionCenter::findOrFail($centerid);
        }

        $types = InspectionType::where('center_id',$centerid)->get();
        return view('admin.inspectiontype.index',compact('types','center'));
    }
    public function store(Request $request)
    {

        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'name'=>'required',
                'price'=>'required',
                'status'=>'required'
            ];
            $messages = [
                'name.required'=>' من فضلك ادخل اسم الفحص  ',
                'price.required'=>' من فضلك ادخل اسم السعر  ',
                'status.required'=>' من فضلك ادخل الحالة   ',
            ];
            $validator = Validator::make($data,$rules,$messages);
            if ($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $type =new InspectionType();
            $type->create([
                'name'=>$data['name'],
                'center_id'=>$data['center_id'],
                'price'=>$data['price'],
                'status'=>$data['status'],
            ]);
            return $this->success_message(' تم اضافة نوع الفحص بنجاح  ');
        }
    }
    public function update(Request $request,$id)
    {

        $type = InspectionType::findOrFail($id);
        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'name'=>'required',
                'price'=>'required',
                'status'=>'required'
            ];
            $messages = [
                'name.required'=>' من فضلك ادخل اسم الفحص  ',
                'price.required'=>' من فضلك ادخل اسم السعر  ',
                'status.required'=>' من فضلك ادخل الحالة   ',
            ];
            $validator = Validator::make($data,$rules,$messages);
            if ($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $type->update([
                'name'=>$data['name'],
                'price'=>$data['price'],
                'status'=>$data['status'],
            ]);
            return $this->success_message(' تم تعديل  نوع الفحص بنجاح  ');
        }
    }

    public function delete($id)
    {
        $type = InspectionType::findOrFail($id);

        $type->delete();
        return $this->success_message(' تم حذف  نوع الفحص بنجاح  ');
    }
}
