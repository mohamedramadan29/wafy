<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Message_Trait;

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'phone' => 'required|unique:users,phone',
                'password' => 'required',
            ];
            $messages = [
                'name.required' => ' من فضلك ادخل الاسم ',
                'phone.required' => ' من فضلك ادخل رقم الهاتف  ',
                'phone.unique' => ' تم تسجيل رقم الهاتف من قبل  ',
                'password.required' => ' من فضلك ادخل رمز الحماية  '
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $user = new User();
            $user->name = $data['name'];
            $user->phone = $data['phone'];
            $user->password = Hash::make($data['password']);
            $user->save();
            return $this->success_message(' تم عمل حساب جديد بنجاح  ');

        }
        return view('front.register');
    }

    public function login(Request $request)
    {
        try {
            $data = $request->all();
            $rules = [
                'phone' => 'required',
                'password' => 'required'
            ];
            $messages = [
                'phone.required' => '  من فضلك ادخل رقم الهاتف   ',
                'password.required' => ' من فضلك ادخل رمز الحماية  ',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if (Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
                if (Auth::user()->phone_confirm == 0) {
                    Auth::logout();
                    return Redirect::back()->withInput()->withErrors('  من فضلك يجب تاكيد رقم الهاتف  الخاص بك اولا  ');
                }
                return \redirect('user/dashboard');
            } else {
                return Redirect::back()->withInput()->withErrors('لا يوجد حساب بهذه البيانات  ');
            }

        } catch (\Exception $e) {
            return $this->exception_message($e);
        }

    }

    public function dashboard()
    {
        return view('front.users.dashboard');
    }
}
