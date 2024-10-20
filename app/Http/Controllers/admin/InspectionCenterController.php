<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\InsepctionCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InspectionCenterController extends Controller
{
    use Message_Trait;

    public function login(Request $request)
    {
        if ($request->isMethod('post')){
            $data_lgoin = $request->all();
            try {
                $rules = [
                    'phone' => 'required',
                    'password' => 'required',
                ];
                $customMessage = [
                    'phone.required' => 'من فضلك ادخل رقم الهاتف',
                    'password.required' => 'من فضلك ادخل كلمة المرور',
                ];
                $this->validate($request, $rules, $customMessage);
                $phone = $data_lgoin['phone'];
                $password = $data_lgoin['password'];
                if (Auth::guard('center')->attempt(['phone' => $phone, 'password' => $password])) {
                    $user = Auth::guard('center')->user();
                   //  dd($user);
                    if (Auth::guard('center')->user()->status == 1) {
                        return redirect('center/dashboard');
                    } else {
                        return $this->Error_message('غير مصرح لك بالدخول كمركز صيانة ');
                    }
                } else {
                    return $this->Error_message('لا يوجد سجل بهذة البيانات ');
                }

            } catch (\Exception $e) {
                return $this->exception_message($e);
            }
        }
        return view('admin.center');
    }
    public function center_dashboard()
    {
        return view('admin.center.dashboard');
    }
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
                'password'=>'required',
                'confirm_password'=>'required|same:password',
                'phone'=>'required|unique:insepction_centers,phone',
            ];
            $messages = [
                'name.required'=>' من فضلك ادخل اسم مركز الصيانة  ',
                'status.required'=>' من فضلك حدد الحالة  ',
                'password.required'=>' من فضلك ادخل كلمة المرور',
                'confirm_password.required'=>'  من فضلك اكد كلمة المرور   ',
                'confirm_password.same'=>' من فضلك اكد كلمة المرور بشكل صحيح  ',
                'phone.required'=>' من فضلك ادخل رقم الهاتف  ',
                'phone.unique'=>' رقم الهاتف متواجد بالفعل من فضلك ادخل رقم هاتف جديد  '


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
                'password'=>Hash::make($data['password']),
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
                'phone'=>'required|unique:insepction_centers,phone,'.$center['id'],
            ];
            if (isset($data['password']) && $data['password'] != '') {
                $rules['password'] = 'required';
                $rules['confirm_password'] = 'required|same:password';
            }
            $messages = [
                'name.required'=>' من فضلك ادخل اسم مركز الصيانة  ',
                'status.required'=>' من فضلك حدد الحالة  ',
                'phone.required' => 'من فضلك ادخل رقم الهاتف',
                'phone.unique' => 'رقم الهاتف مسجل بالفعل',
                'password.required' => 'من فضلك ادخل كلمة المرور',
                'confirm_password.required' => 'من فضلك اكد كلمة المرور',
                'confirm_password.same' => 'من فضلك اكد كلمة المرور بشكل صحيح',
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
            if (isset($data['password']) && $data['password'] !=''){
                $center->update([
                    'password'=> Hash::make($data['password']),
                ]);
            }
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
