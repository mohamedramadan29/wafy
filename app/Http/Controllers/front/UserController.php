<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\InsepctionCenter;
use App\Models\admin\InspectionType;
use App\Models\admin\Term;
use App\Models\front\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Spatie\Backtrace\Arguments\ReducedArgument\ReducedArgument;

class UserController extends Controller
{
    use Message_Trait;
    use Upload_Images;

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $password = implode('', $data['password']);
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
            $user->password = Hash::make($password);
            $user->save();
            return $this->success_message(' تم عمل حساب جديد بنجاح  ');

        }
        return view('front.register');
    }

    public function login(Request $request)
    {
        try {
            $data = $request->all();

            // جمع القيم المدخلة في الحقول الستة في متغير واحد
            $password = implode('', $data['password']);

            $rules = [
                'phone' => 'required',
                'password' => ['required', 'regex:/^\d{6}$/'] // التحقق من أن الكلمة السرية مكونة من 6 أرقام فقط
            ];
            $messages = [
                'phone.required' => 'من فضلك ادخل رقم الهاتف',
                'password.required' => 'من فضلك ادخل رمز الحماية',
                'password.regex' => 'رمز الحماية يجب أن يكون مكون من 6 أرقام'
            ];
            $validator = Validator::make(['phone' => $data['phone'], 'password' => $password], $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if (Auth::attempt(['phone' => $data['phone'], 'password' => $password])) {
                if (Auth::user()->phone_confirm == 0) {
                    Auth::logout();
                    return Redirect::back()->withInput()->withErrors('من فضلك يجب تاكيد رقم الهاتف الخاص بك اولا');
                }
                return redirect('user/dashboard');
            } else {
                return Redirect::back()->withInput()->withErrors('لا يوجد حساب بهذه البيانات');
            }

        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
    }


    public function account(Request $request)
    {
        $user = User::where('id', Auth::id())->first();

        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'name' => 'required',
                    'phone' => 'required|unique:users,phone,' . $user['id'],
                    'email' => 'nullable|unique:users,email,' . $user['id'],
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
                ];
                $messages = [
                    'name.required' => ' من فضلك ادخل الاسم  ',
                    'phone.required' => ' من فضلك ادخل رقم الهاتف  ',
                    'phone.unique' => ' رقم الهاتف مستخدم بالفعل  ',
                    'email.unique' => ' البريد الالكتروني مستخدم بالفعل  ',
                    'image.image' => ' يجب ان تكون الصورة من نوع صورة ',
                    'image.mimes' => ' الصورة يجب ان تكون من نوع jpeg, png, jpg, gif,webp, svg ',
                    'image.max' => ' الصورة يجب ان لا تتجاوز 2 ميجابايت ',
                ];
                $validator = Validator::make($data, $rules, $messages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }
                if ($request->hasFile('image')) {
                    // حذف الصورة القديمة إن وجدت
                    if ($user->image != '') {
                        $oldImage = public_path('assets/uploads/user_images/' . $user->image);
                        if (file_exists($oldImage)) {
                            unlink($oldImage);
                        }
                    }
                    // حفظ الصورة الجديدة
                    $filename = $this->saveImage($request->image, public_path('assets/uploads/user_images/'));
                    $user->image = $filename;
                }

                $user->update([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                ]);
                return $this->success_message(' تم تعديل المعلومات بنجاح  ');

            }
        } catch (\Exception $e) {
            return $this->exception_message($e);
        }
        return view('front.users.profile.index', compact('user'));
    }

    public function change_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $password = implode('', $data['password']);
            $new_password = implode('', $data['new_password']);

            // Check if the current password matches
            if (Hash::check($password, Auth::user()->password)) {
                // Update the user's password
                $user = Auth::user();
                $user->password = Hash::make($new_password);
                $user->save();
                return $this->success_message(' تم تغيير رمز الحماية بنجاح ');
            } else {
                return redirect()->back()->withErrors('رمز الحماية الحالي غير صحيح');
            }
        }
        return view('front.users.profile.change-password');
    }


    public function forget_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $phone = $data['phone'];
            $count_user = User::where('phone', $phone)->count();

            if ($count_user > 0) {
                $user = User::where('phone', $phone)->first();
                $user->update([
                    'code' => rand(1000, 9999),
                    'timeout_code' => now()->addMinutes(10),
                ]);

                // إرسال كود التحقق إلى واتساب العميل هنا

                return view('front.forget-password')->with([
                    'phone' => $phone,
                    'step' => 2
                ]);
            } else {
                return redirect()->back()->withErrors('لا يوجد حساب بهذا الرقم!!!');
            }
        }

        return view('front.forget-password');
    }

    public function forget_password_step2(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $phone = $data['phone'];
            $user = User::where('phone', $phone)->first();

            $confirm_code = implode('', $data['confirm_code']);
            if ($user && $user->code == $confirm_code) {
                if (now()->lessThan($user->timeout_code)) {
                    return view('front.forget-password')->with([
                        'phone' => $phone,
                        'step' => 3,
                    ]);
                } else {
                    return redirect()->back()->withErrors('كود التحقق منتهي الصلاحية!');
                }
            } else {
                return redirect()->back()->withErrors('كود التحقق غير صحيح!');
            }
        }

        return view('front.forget-password');
    }

    public function reset_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $phone = $data['phone'];
            $user = User::where('phone', $phone)->first();
            $new_password = implode('',$data['new_password']);
            $confirm_password = implode('',$data['confirm_password']);
            if ($new_password != $confirm_password){
                return redirect()->back()->withErrors(' يجب تاكيد رمز الحماية بشكل صحيح  ');
            }
            if ($user) {
                $user->update([
                    'password' => Hash::make($new_password),
                    'code' => null,  // مسح الكود بعد الاستخدام
                    'timeout_code' => null, // مسح الـ timeout بعد الاستخدام
                ]);

                return redirect()->route('register')->with('Success_message', 'تم تغيير كلمة المرور بنجاح!');
            } else {
                return redirect()->back()->withErrors('حدث خطأ، الرجاء المحاولة مرة أخرى.');
            }
        }
        return view('front.forget-password');
    }


    public function dashboard()
    {
        $centers = InsepctionCenter::where('status', 1)->get();

        $types = InspectionType::where('status', 1)->get();
        $transactions = Order::with('seller','buyer')->where('seller_id', Auth::id())->orwhere('buyer_id', Auth::id())->orderby('id', 'DESC')->limit(5)->get();
        return view('front.users.dashboard', compact('transactions','centers','types'));
    }
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    public function terms()
    {
        $terms = Term::first();
        return view('front.terms',compact('terms'));
    }
}
