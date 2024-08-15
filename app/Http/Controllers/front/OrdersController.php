<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Slug_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\InsepctionCenter;
use App\Models\admin\InspectionType;
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
                'description' => 'required|min:20',
                'car_mark' => 'required',
                'car_model' => 'required',
                'car_year' => 'required',
                'body_type' => 'required',
                'door_number' => 'required',
                'car_color' => 'required',
                'car_distance' => 'required',
                'solar_type' => 'required',
                'engine_capacity' => 'required',
                'car_transmission' => 'required',
                'car_accedant' => 'required',
                'car_any_damage' => 'required',
                'tire_condition' => 'required',
            ];
            $messages = [
                'title.required' => '  من فضلك ادخل عنوان العرض  ',
                'price.required' => ' من فضلك ادخل سعر السيارة  ',
                'description.required' => ' من فضلك ادخل الوصف بشكل تفصيلي  ',
                'car_mark.required' => ' من فضلك ادخل حدد الماركة ',
                'car_model.required' => '  من فضلك حدد الموديل  ',
                'car_year.required' => ' من فضلك حدد سنة الصنع  ',
                'body_type.required' => ' من فضلك حدد نوع الجسم  ',
                'door_number.required' => ' من فضلك ادخل عدد الابواب  ',
                'car_color.required' => ' من فضلك ادخل لون السيارة  ',
                'car_distance.required' => '',
                'solar_type.required' => ' من فضلك حدد نوع الوقود ',
                'engine_capacity.required' => ' من فضلك حدد سعة الماتور  ',
                'car_transmission.required' => '',
                'car_accedant.required' => '',
                'car_any_damage.required' => '',
                'tire_condition.required' => '',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $CountOldSlug = Order::where('slug', $this->CustomeSlug($data['title']))->count();
            if ($CountOldSlug > 0) {
                return Redirect::back()->withInput()->withErrors(' اسم المعاملة متواجد من قبل من فضلك عدل الاسم الحالي  ');
            }
            $fileimages = [];
            if ($request->hasFile('images')) {
                foreach ($request->images as $image) {
                    $fileimages[] = $this->saveImage($image, public_path('assets/uploads/car_images/'));
                }
                $lastfileimages = implode(',', $fileimages);
            }
            DB::beginTransaction();
            $new_order = new Order();
            $new_order->seller_id = auth()->id();
            $new_order->title = $data['title'];
            $new_order->slug = $this->CustomeSlug($data['title']);
            $new_order->price = $data['price'];
            $new_order->description = $data['description'];
            $new_order->images = $lastfileimages;
            $new_order->link = url('transaction/' . Auth::id() . '-' . $this->CustomeSlug($data['title']));
            $new_order->save();
            //////// Insert Car Details Questions
            ///
            $order_question = new OrderQuestion();
            $order_question->order_id = $new_order->id;
            $order_question->car_mark = $data['car_mark'];
            $order_question->car_model = $data['car_model'];
            $order_question->car_year = $data['car_year'];
            $order_question->body_type = $data['body_type'];
            $order_question->door_number = $data['door_number'];
            $order_question->car_color = $data['car_color'];
            $order_question->car_distance = $data['car_distance'];
            $order_question->solar_type = $data['solar_type'];
            $order_question->engine_capacity = $data['engine_capacity'];
            $order_question->car_transmission = $data['car_transmission'];
            $order_question->car_accedant = $data['car_accedant'];
            $order_question->car_any_damage = $data['car_any_damage'];
            $order_question->tire_condition = $data['tire_condition'];
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
        return view('front.users.start_order');
    }

    public function update(Request $request, $seller_id, $slug)
    {

        $transaction_count = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->count();
        if ($transaction_count > 0) {
            $transaction = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->first();
            $transaction_question = OrderQuestion::findOrFail($transaction['id']);
        } else {
            abort('404');
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            //dd($data);
            $rules = [
                'title' => 'required',
                'price' => 'required|numeric',
                'description' => 'required|min:20',
                'car_mark' => 'required',
                'car_model' => 'required',
                'car_year' => 'required',
                'body_type' => 'required',
                'door_number' => 'required',
                'car_color' => 'required',
                'car_distance' => 'required',
                'solar_type' => 'required',
                'engine_capacity' => 'required',
                'car_transmission' => 'required',
                'car_accedant' => 'required',
                'car_any_damage' => 'required',
                'tire_condition' => 'required',
            ];
            $messages = [
                'title.required' => '  من فضلك ادخل عنوان العرض  ',
                'price.required' => ' من فضلك ادخل سعر السيارة  ',
                'description.required' => ' من فضلك ادخل الوصف بشكل تفصيلي  ',
                'car_mark.required' => ' من فضلك ادخل حدد الماركة ',
                'car_model.required' => '  من فضلك حدد الموديل  ',
                'car_year.required' => ' من فضلك حدد سنة الصنع  ',
                'body_type.required' => ' من فضلك حدد نوع الجسم  ',
                'door_number.required' => ' من فضلك ادخل عدد الابواب  ',
                'car_color.required' => ' من فضلك ادخل لون السيارة  ',
                'car_distance.required' => '',
                'solar_type.required' => ' من فضلك حدد نوع الوقود ',
                'engine_capacity.required' => ' من فضلك حدد سعة الماتور  ',
                'car_transmission.required' => '',
                'car_accedant.required' => '',
                'car_any_damage.required' => '',
                'tire_condition.required' => '',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $CountOldSlug = Order::where('slug', $this->CustomeSlug($data['title']))->where('id', '!=', $transaction_question['id'])->count();
            if ($CountOldSlug > 0) {
                return Redirect::back()->withInput()->withErrors(' اسم المعاملة متواجد من قبل من فضلك عدل الاسم الحالي  ');
            }
            $fileimages = [];
            if ($request->hasFile('images')) {
                foreach ($request->images as $image) {
                    $fileimages[] = $this->saveImage($image, public_path('assets/uploads/car_images/'));
                }
                $lastfileimages = implode(',', $fileimages);
            }
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
            $transaction_question->update([
                "car_mark" => $data['car_mark'],
                "car_model" => $data['car_model'],
                "car_year" => $data['car_year'],
                "body_type" => $data['body_type'],
                "door_number" => $data['door_number'],
                "car_color" => $data['car_color'],
                "car_distance" => $data['car_distance'],
                "solar_type" => $data['solar_type'],
                "engine_capacity" => $data['engine_capacity'],
                "car_transmission" => $data['car_transmission'],
                "car_accedant" => $data['car_accedant'],
                "car_any_damage" => $data['car_any_damage'],
                "tire_condition" => $data['tire_condition'],
            ]);
            DB::commit();
            return $this->success_message(' تم تعديل المعاملة بنجاح  ');
        }
        return view('front.users.edit-transaction', compact('transaction'));
    }

    public function show($seller_id, $slug)
    {
        $transaction_count = Order::with('question')->where('seller_id', $seller_id)->where('slug', $slug)->count();
        if ($transaction_count > 0) {
            $transaction = Order::with('question')->where('seller_id', $seller_id)->where('slug', $slug)->first();
            $transaction_question = OrderQuestion::findOrFail($transaction['id']);
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

        return view('front.show-transaction', compact('transaction'));
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

    ///////////////////// Start Pay Invoice
    ///
    public function pay_invoice()
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post('https://api.tap.company/v2/charges', [
                'json' => [
                    "amount" => 100, // Total amount to charge (in SAR)
                    "currency" => "SAR",
                    "threeDSecure" => true,
                    "save_card" => false,
                    "description" => "Purchase of Products", // Description of the purchase
                    "receipt" => [
                        "email" => true,
                        "sms" => true
                    ],
                    "customer" => [
                        "first_name" => 'mohamedramadan',
                        "email" => 'mr@gmail.com',
                        "phone" => [
                            "number" => '000000'
                        ]
                    ],
                    "source" => [
                        "id" => "src_all"
                    ],
                    "post" => [
                        "url" => url('pay_invoice')
                    ],
                    "redirect" => [
                        "url" => url('pay_invoice/callback')
                    ],
                    "metadata" => [
                        "udf1" => "Metadata 1"
                    ]
                ],
                'headers' => [
                    "authorization" => "Bearer sk_test_nsgFzA1ulL5432S8YfeENq9U", // Sk Live
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            $output = json_decode($response->getBody());

            // تأكد من أن URL يحتوي على رابط صالح
            if (isset($output->transaction->url)) {
                // إعادة التوجيه باستخدام طريقة Laravel redirect
                return redirect()->away($output->transaction->url);
            } else {
                return back()->withErrors(['error' => 'URL غير موجود في الاستجابة من بوابة الدفع.']);
            }
        } catch (\Exception $e) {
            // في حال حدوث خطأ، يمكن إرجاع المستخدم إلى الصفحة السابقة مع رسالة خطأ
            return back()->withErrors(['error' => 'حدث خطأ أثناء معالجة الدفع: ' . $e->getMessage()]);
        }
    }

    public function callback(Request $request)
    {
        // الحصول على البيانات المستلمة من بوابة الدفع
        // الحصول على tap_id من الـ callback
        $tapId = $request->input('tap_id');

        if (!$tapId) {
            // التعامل مع حالة عدم وجود tap_id
           // return redirect()->route('payment.failed')->withErrors('لا يوجد tap_id في الاستجابة.');
            return "Failed Not Found TabId";
        }

        // استرجاع تفاصيل المعاملة باستخدام tap_id
        $client = new Client();
        $response = $client->request('GET', 'https://api.tap.company/v2/charges/' . $tapId, [
            'headers' => [
                'Authorization' => 'Bearer sk_test_nsgFzA1ulL5432S8YfeENq9U', // استبدل بالـ API Key الخاص بك
                'Accept' => 'application/json',
            ],
        ]);
        $details = json_decode($response->getBody(), true);

        // تحقق من حالة الدفع
        if ($details['status'] === 'CAPTURED') {
            // الدفع ناجح
            // تحديث حالة الطلب في قاعدة البيانات
//            $order = Order::where('transaction_id', $tapId)->first();
//            if ($order) {
//                $order->status = 'paid';
//                $order->save();
//            }

            return "Successsssss";
            // إعادة توجيه إلى صفحة النجاح
            //return redirect()->route('payment.success');
        } else {
            // الدفع فشل
            // إعادة توجيه إلى صفحة الفشل
          //  return redirect()->route('payment.failed')->withErrors('الدفع فشل.');
            return "Faileeed";
        }


    }


    public function delete($id)
    {
        $transaction = Order::findOrFail($id);
        $transaction->delete();
        return $this->success_message(' تم حذف المعاملة بنجاح  ');
    }
}
