<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Slug_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\InsepctionCenter;
use App\Models\admin\InspectionType;
use App\Models\admin\TraderMark;
use App\Models\front\Order;
use App\Models\front\OrderQuestion;
use App\Models\front\TransactionStep;
use App\Notifications\NewBuyer;
use App\Notifications\SelectCenter;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class OrdersController extends Controller
{
    use Message_Trait;
    use Slug_Trait;
    use Upload_Images;

    public function index()
    {
        $transactions = Order::where('seller_id', Auth::id())->orwhere('buyer_id', Auth::id())->orderby('id', 'DESC')->get();
        $centers = InsepctionCenter::where('status', 1)->get();

        $types = InspectionType::where('status', 1)->get();
        /////////// Make Notifiction Is Read
        ///
        if (auth()->check()) {
            $user = \App\Models\User::find(Auth::id());

            foreach ($user->unreadNotifications as $notification) {
                if ($notification['type'] == 'App\Notifications\SelectCenter') {
                    $notification->markAsRead();
                }
            }
        }

        return view('front.users.transactions', compact('transactions', 'centers', 'types'));
    }

    public function getInspectionTypes($centerId)
    {
        $types = InspectionType::where('center_id', $centerId)->where('status', 1)->get();
        return response()->json(['types' => $types]);
    }

    public function getInspectionPrice($typeId)
    {
        $type = InspectionType::find($typeId);
        return response()->json(['price' => $type->price]);
    }

    public function start_order(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            $rules = [
                'title' => 'required',
                'price' => 'required|numeric',
                'description' => 'required',
                'car_mark' => 'required',
                'car_mark_type' => 'required',
                'car_model' => 'required',
                'car_category' => 'required',
                'car_gear' => 'required',
                'car_color' => 'required',
                'car_distance' => 'required',
                'solar_type' => 'required',
                'car_board_letters' => 'required',
                'car_board_numbers' => 'required',
                'front_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'back_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'right_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'left_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',

            ];
            $messages = [
                'title.required' => '  من فضلك ادخل عنوان العرض  ',
                'price.required' => ' من فضلك ادخل سعر السيارة  ',
                'description.required' => ' من فضلك ادخل الوصف بشكل تفصيلي  ',
                'car_mark.required' => ' من فضلك ادخل حدد الماركة ',
                'car_model.required' => '  من فضلك حدد الموديل  ',
                'car_color.required' => ' من فضلك ادخل لون السيارة  ',
                'solar_type.required' => ' من فضلك حدد نوع الوقود ',
                //  'images.required' => 'من فضلك قم برفع صورة واحدة على الأقل للسيارة',
                'front_image.required' => ' من فضلك ادخل صورة للسيارة من الامام ',
                'front_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'front_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
                'back_image.required' => ' من فضلك ادخل صورة للسيارة من الخلف ',
                'back_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'back_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
                'right_image.required' => ' من فضلك ادخل صورة للسيارة من اليمين ',
                'right_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'right_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
                'left_image.required' => ' من فضلك ادخل صورة للسيارة من اليسار ',
                'left_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'left_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $CountOldSlug = Order::where('slug', $this->CustomeSlug($data['title']))->where('seller_id', Auth::id())->count();
            if ($CountOldSlug > 0) {
                return Redirect::back()->withInput()->withErrors(' اسم المعاملة متواجد من قبل من فضلك عدل الاسم الحالي  ');
            }
            if ($request->hasFile('front_image')) {
                // التحقق من أن الملف صورة قبل محاولة حفظه
                if ($request->file('front_image')->isValid()) {
                    $frontimage = $this->saveImage($request->file('front_image'), public_path('assets/uploads/car_images/'));
                }
            }
            if ($request->hasFile('back_image')) {
                // التحقق من أن الملف صورة قبل محاولة حفظه
                if ($request->file('back_image')->isValid()) {
                    $backimage = $this->saveImage($request->file('back_image'), public_path('assets/uploads/car_images/'));
                }
            }

            if ($request->hasFile('left_image')) {
                // التحقق من أن الملف صورة قبل محاولة حفظه
                if ($request->file('left_image')->isValid()) {
                    $leftimage = $this->saveImage($request->file('left_image'), public_path('assets/uploads/car_images/'));
                }
            }
            if ($request->hasFile('right_image')) {
                // التحقق من أن الملف صورة قبل محاولة حفظه
                if ($request->file('right_image')->isValid()) {
                    $rightimage = $this->saveImage($request->file('right_image'), public_path('assets/uploads/car_images/'));
                }
            }

            DB::beginTransaction();
            $new_order = new Order();
            $new_order->seller_id = auth()->id();
            $new_order->title = $data['title'];
            $new_order->slug = $this->CustomeSlug($data['title']);
            $new_order->price = $data['price'];
            $new_order->description = $data['description'];
            $new_order->front_image = $frontimage;
            $new_order->back_image = $backimage;
            $new_order->left_image = $leftimage;
            $new_order->right_image = $rightimage;
            $new_order->link = url('transaction/' . Auth::id() . '-' . $this->CustomeSlug($data['title']));
            $new_order->save();
            //////// Insert Car Details Questions
            ///
            $data['car_double'] = $request->has('car_double') ? '1' : '0';
            $order_question = new OrderQuestion();
            $order_question->order_id = $new_order->id;
            $order_question->car_mark = $data['car_mark'];
            $order_question->car_mark_type = $data['car_mark_type'];
            $order_question->car_model = $data['car_model'];
            $order_question->car_category = $data['car_category'];
            $order_question->car_gear = $data['car_gear'];
            $order_question->car_color = $data['car_color'];
            $order_question->car_distance = $data['car_distance'];
            $order_question->car_double = $data['car_double'];
            $order_question->solar_type = $data['solar_type'];
            $order_question->car_board_letters = $data['car_board_letters'];
            $order_question->car_board_numbers = $data['car_board_numbers'];
            $order_question->save();

            ////////////// Add Order Steps
            ///
            $transaction_step = new TransactionStep();
            $transaction_step->transaction_id = $new_order->id;
            $transaction_step->transaction_title = $data['title'];
            $transaction_step->transaction_slug = $this->CustomeSlug($data['title']);
            $transaction_step->user_id = Auth::id();
            $transaction_step->user_name = Auth::user()->name;
            $transaction_step->title = '  بداية انشاء العملية من المستخدم   ';
            $transaction_step->save();

            DB::commit();


            return $this->success_message(' تم اضافة المعاملة بنجاح  ');
        }

        $marks = TraderMark::all();
        return view('front.users.start_order', compact('marks'));
    }

//    public function getTypes($markid)
//    {
//        // جلب الماركة من خلال ID
//        $traderMark = TraderMark::find($markid);
//
//        // تحقق من وجود الماركة
//        if ($traderMark) {
//            $types = explode('-', $traderMark->types); // افتراض أن الأنواع موجودة كقائمة مفصولة بفواصل
//            $typeArray = [];
//            foreach ($types as $type) {
//                $typeArray[$type] = $type;
//            }
//
//            // إرجاع الأنواع في صيغة JSON
//            return response()->json($typeArray);
//        }
//        // في حالة عدم وجود الماركة
//        return response()->json([]);
//    }

    public function getTypes($markid)
    {
        // جلب الماركة من خلال ID
        $traderMark = TraderMark::find($markid);

        // تحقق من وجود الماركة
        if ($traderMark) {
            // افتراض أن الأنواع موجودة كقائمة مفصولة بعلامة "-"
            $types = explode('-', $traderMark->types);
            $typeArray = [];

            foreach ($types as $type) {
                // إزالة المسافات من بداية ونهاية السلسلة النصية
                $type = trim($type);
                if (!empty($type)) { // التأكد من أن النوع ليس فارغاً بعد التقطيع
                    $typeArray[$type] = $type;
                }
            }

            // إرجاع الأنواع في صيغة JSON
            return response()->json($typeArray);
        }

        // في حالة عدم وجود الماركة
        return response()->json([]);
    }


    public function update(Request $request, $seller_id, $slug)
    {
        $transactioncount = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->count();
       // dd($transactioncount);
        if ($transactioncount > 0) {
            $transaction = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->first();
           // $transaction_question = OrderQuestion::findOrFail($transaction['id']);
            $transaction_question = OrderQuestion::where('order_id',$transaction['id'])->first();
        } else {
            abort('404');
        }


        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            $rules = [
                'title' => 'required',
                'price' => 'required|numeric',
                'description' => 'required',
                'car_mark' => 'required',
                'car_mark_type' => 'required',
                'car_model' => 'required',
                'car_category' => 'required',
                'car_gear' => 'required',
                'car_color' => 'required',
                'car_distance' => 'required',
                'solar_type' => 'required',
                'car_board_letters' => 'required',
                'car_board_numbers' => 'required',
                'front_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                'back_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                'right_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                'left_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',

            ];
            $messages = [
                'title.required' => '  من فضلك ادخل عنوان العرض  ',
                'price.required' => ' من فضلك ادخل سعر السيارة  ',
                'description.required' => ' من فضلك ادخل الوصف بشكل تفصيلي  ',
                'car_mark.required' => ' من فضلك ادخل حدد الماركة ',
                'car_model.required' => '  من فضلك حدد الموديل  ',
                'car_color.required' => ' من فضلك ادخل لون السيارة  ',
                'solar_type.required' => ' من فضلك حدد نوع الوقود ',
                //  'images.required' => 'من فضلك قم برفع صورة واحدة على الأقل للسيارة',

                'front_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'front_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
                'back_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'back_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
                'right_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'right_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
                'left_image.image' => ' من فضلك ادخل صورة للسيارة بشكل صحيح  ',
                'left_image.mimes' => ' يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg ',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $CountOldSlug = Order::where('slug', $this->CustomeSlug($data['title']))->where('id', '!=', $transaction['id'])->count();
            if ($CountOldSlug > 0) {
                return Redirect::back()->withInput()->withErrors(' اسم المعاملة متواجد من قبل من فضلك عدل الاسم الحالي  ');
            }

            if ($request->hasFile('front_image')) {
                $oldFrontImage = public_path('assets/uploads/car_images/' . $transaction->front_image);
                if (file_exists($oldFrontImage)) {
                    unlink($oldFrontImage);
                }
                if ($request->file('front_image')->isValid()) {
                    $frontImagePath = $this->saveImage($request->file('front_image'), public_path('assets/uploads/car_images/'));
                    $transaction->front_image = $frontImagePath;
                    $transaction->save();
                }
            }
            if ($request->hasFile('back_image')) {
                $oldBackImage = public_path('assets/uploads/car_images/' . $transaction->back_image);
                if (file_exists($oldBackImage)) {
                    unlink($oldBackImage);
                }
                if ($request->file('back_image')->isValid()) {
                    $backImagePath = $this->saveImage($request->file('back_image'), public_path('assets/uploads/car_images/'));
                    $transaction->back_image = $backImagePath;
                    $transaction->save();
                }
            }

            if ($request->hasFile('right_image')) {
                $oldRightImage = public_path('assets/uploads/car_images/' . $transaction->right_image);
                if (file_exists($oldRightImage)) {
                    unlink($oldRightImage);
                }
                if ($request->file('right_image')->isValid()) {
                    $rightImagePath = $this->saveImage($request->file('right_image'), public_path('assets/uploads/car_images/'));
                    $transaction->right_image = $rightImagePath;
                    $transaction->save();
                }
            }

            if ($request->hasFile('left_image')) {
                $oldLeftImage = public_path('assets/uploads/car_images/' . $transaction->left_image);
                if (file_exists($oldLeftImage)) {
                    unlink($oldLeftImage);
                }
                if ($request->file('left_image')->isValid()) {
                    $lefttImagePath = $this->saveImage($request->file('left_image'), public_path('assets/uploads/car_images/'));
                    $transaction->left_image = $lefttImagePath;
                    $transaction->save();
                }
            }


//            $fileimages = [];
//            if ($request->hasFile('images')) {
//                foreach ($request->images as $image) {
//                    $fileimages[] = $this->saveImage($image, public_path('assets/uploads/car_images/'));
//                }
//                $lastfileimages = implode(',', $fileimages);
//            }
            DB::beginTransaction();
            $transaction->update([
                'title' => $data['title'],
                'slug' => $this->CustomeSlug($data['title']),
                'price' => $data['price'],
                'description' => $data['description'],
                //images = $lastfileimages;
                'link' => url('transaction/' . Auth::id() . '-' . $this->CustomeSlug($data['title'])),
            ]);
            //////// Insert Car Details Questions
            ///
            $data['car_double'] = $request->has('car_double') ? '1' : '0';
            $transaction_question->update([
                "car_mark" => $data['car_mark'],
                "car_mark_type" => $data['car_mark_type'],
                "car_model" => $data['car_model'],
                "car_category" => $data['car_category'],
                "car_gear" => $data['car_gear'],
                "car_color" => $data['car_color'],
                "car_distance" => $data['car_distance'],
                "car_double" => $data['car_double'],
                "solar_type" => $data['solar_type'],
                "car_board_letters" => $data['car_board_letters'],
                "car_board_numbers" => $data['car_board_numbers'],
            ]);
            DB::commit();
            // إعادة التوجيه إلى الرابط الجديد باستخدام الـ seller_id والـ transaction_slug الجديد
            return redirect()->to('user/transaction/edit/' . $seller_id . '-' . $transaction->slug)
                ->with('Success_message', 'تم تعديل المعاملة بنجاح');
          //  return $this->success_message(' تم تعديل المعاملة بنجاح  ');
        }
        $marks = TraderMark::all();

        return view('front.users.edit-transaction', compact('transaction', 'marks'));
    }

    public function show($seller_id, $slug)
    {
        $marks = TraderMark::all();
        $transactioncount = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->count();
        // dd($transactioncount);
        if ($transactioncount > 0) {
            $transaction = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->first();
            // $transaction_question = OrderQuestion::findOrFail($transaction['id']);
            $transaction_question = OrderQuestion::where('order_id',$transaction['id'])->first();
        } else {
            abort('404');
        }
        /////////// Make Notifiction Is Read
        ///
        if (auth()->check()) {
            $user = \App\Models\User::find(Auth::id());

            foreach ($user->unreadNotifications as $notification) {
                if ($notification['type'] == 'App\Notifications\NewBuyer') {
                    $notification->markAsRead();
                }
            }
        }

        return view('front.show-transaction', compact('transaction','marks'));
    }

    public function buyer_start_transaction($seller_id, $slug)
    {
        $transaction_count = Order::with('question')->where('seller_id', $seller_id)->where('slug', $slug)->count();
        if ($transaction_count > 0) {
            $transaction = Order::with('question')->where('seller_id', $seller_id)->where('slug', $slug)->first();
            $seller = \App\Models\User::where('id', $seller_id)->first();
            $seller_name = $seller['name'];
            $transaction->update([
                'buyer_id' => Auth::id(),
                'status' => ' بداية عملية الشراء '
            ]);
            ///////////////// Send Notification To Seller IN DB
            Notification::send($seller, new NewBuyer($seller_id, $seller_name, Auth::id(), Auth::user()->name, $transaction['id'], $transaction['title'], $transaction['slug']));
            ////////////// Send Notification To Whatsapp To Buyer
            //

            //////// Add Step To Db
            ///
            $transaction_step = new TransactionStep();
            $transaction_step->transaction_id = $transaction['id'];
            $transaction_step->transaction_title = $transaction['title'];
            $transaction_step->transaction_slug = $transaction['slug'];
            $transaction_step->user_id = Auth::id();
            $transaction_step->user_name = Auth::user()->name;
            $transaction_step->title = '  بدء عملية الشراء من جانب المستخدم  ';
            $transaction_step->save();

            return $this->success_message(' تم بدء المعاملة بنجاح  ');
        } else {
            abort('404');
        }
    }


    /////////// User Select Center
    ///
    public function select_center(Request $request, $transaction_id)
    {
        $transaction = Order::findOrFail($transaction_id);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'center' => 'required',
                'inspection_type' => 'required',
                'price' => 'required'
            ];
            $messages = [
                'center.required' => '  ',
                'inspection_type.required' => ' من فضلك حدد نوع الصيانة  ',
                'price.required' => ' من فضلك ادخل السعر  ',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $transaction->update([
                'inspection_center' => $data['center'],
                'inspection_type' => $data['inspection_type'],
                'inspection_price' => $data['price'],
                'status' => 'تم تحديد مركز الصيانة ونوع الفحص',
            ]);

            ///////// start Create Invoice
            ///
            ///

            ////////// Send Notification To seller
            ///

            $seller_id = $transaction['seller_id'];
            $seller = \App\Models\User::where('id', $seller_id)->first();
            $seller_name = $seller['name'];
            Notification::send($seller, new SelectCenter($seller_id, $seller_name, Auth::id(), Auth::user()->name, $transaction['id'], $transaction['title'], $transaction['slug']));
            //////////
            /// Send Notification To Whatsapp
            ///

            ////// Add Transaction Steps
            ///
            $transaction_step = new TransactionStep();
            $transaction_step->transaction_id = $transaction_id;
            $transaction_step->transaction_title = $transaction['title'];
            $transaction_step->transaction_slug = $transaction['slug'];
            $transaction_step->user_id = Auth::id();
            $transaction_step->user_name = Auth::user()->name;
            $transaction_step->title = ' تم تحديد مركز الصيانة والنوع والسعر  ';
            $transaction_step->save();
            return $this->success_message(' تم تحديد مركز الصيانة وانشاء فاتورة الدفع بنجاح  ');
        }
    }

    ////////////// Start show Transaction Invoice
    ///
    public function transaction_invoice($seller_id, $slug)
    {
        $transaction_count = Order::with('question')->where('seller_id', $seller_id)->where('slug', $slug)->count();
        if ($transaction_count > 0) {
            $transaction = Order::with('center', 'inspectiontype')->where('seller_id', $seller_id)->where('slug', $slug)->first();
        } else {
            abort('404');
        }
        return view('front.users.transaction_invoice', compact('transaction'));
    }

    public function delete($id)
    {
        $transaction = Order::findOrFail($id);
        $transaction->delete();
        return $this->success_message(' تم حذف المعاملة بنجاح  ');
    }
}
