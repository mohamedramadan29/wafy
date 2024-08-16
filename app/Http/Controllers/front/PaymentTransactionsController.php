<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\front\Order;
use App\Models\front\PaymentTransactions;
use App\Models\front\TransactionStep;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentTransactionsController extends Controller
{
    public function pay_invoice(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $transaction = Order::findOrFail($id);
            $type_price = $transaction['inspection_price'];
            $client = new \GuzzleHttp\Client();
            try {
                $response = $client->post('https://api.tap.company/v2/charges', [
                    'json' => [
                        "amount" => $type_price, // Total amount to charge (in SAR)
                        "currency" => "SAR",
                        "threeDSecure" => true,
                        "save_card" => false,
                        "description" => " دفع قيمة الفحص  ", // Description of the purchase
                        "receipt" => [
                            "email" => true,
                            "sms" => true
                        ],
                        "customer" => [
                            "first_name" => Auth::user()->name,
                            "email" => Auth::user()->email,
                            "phone" => [
                                "number" => Auth::user()->phone
                            ]
                        ],
                        "source" => [
                            "id" => "src_all"
                        ],
                        "post" => [
                            "url" => url('pay_invoice/' . $id)
                        ],
                        "redirect" => [
                            "url" => url('pay_invoice/callback/' . $id)
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

    }

    public function callback(Request $request, $id)
    {
        // الحصول على البيانات المستلمة من بوابة الدفع
        // الحصول على tap_id من الـ callback
        $tapId = $request->input('tap_id');
        $transaction = Order::findOrFail($id);
        if (Auth::id() == $transaction['seller_id']) {
            $user_type = 'بائع';
        }
        if (Auth::id() == $transaction['buyer_id']) {
            $user_type = 'مشتري';
        }

        $transaction_price = $transaction['inspection_price'];
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
            ////////// Insert Payment Transaction In Db
            ///
            DB::beginTransaction();
            $payment = new PaymentTransactions();
            $payment->user_id = Auth::id();
            $payment->user_type = $user_type;
            $payment->order_id = $id;
            $payment->price = $transaction_price;
            $payment->tap_id = $tapId;
            $payment->status = $details['status'];
            $payment->save();
            ////// Update Order Table
            ///
            if ($user_type == 'بائع') {
                $transaction->update([
                    'seller_buy' => 1,
                ]);
            }
            if ($user_type == 'مشتري') {
                $transaction->update([
                    'buyer_buy' => 1,
                ]);
            }
            //////// Start Add Step
            $transaction_step = new TransactionStep();
            $transaction_step->transaction_id = $id;
            $transaction_step->transaction_title = $transaction['title'];
            $transaction_step->transaction_slug = $transaction['slug'];
            $transaction_step->user_id = Auth::id();
            $transaction_step->user_name = Auth::user()->name;
            $transaction_step->title = '  تم دفع قيمة الفحص   ';
            $transaction_step->save();
            DB::commit();
            return redirect()->route('payment.success');
        } else {
            // الدفع فشل
            // إعادة توجيه إلى صفحة الفشل
              return redirect()->route('payment.failed')->withErrors(' لم تتم عملية الدفع بنجاح  ');

        }
    }

    public function payment_success()
    {
        return view('front.users.payment.success');
    }

    public function payment_failed()
    {
        return view('front.users.payment.failed');
    }

}
