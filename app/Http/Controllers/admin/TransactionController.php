<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\front\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    use Upload_Images;
    use Message_Trait;

    public function index()
    {
        $transactions = Order::with('seller', 'buyer')->orderBy('id', 'desc')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Order::with('seller', 'buyer', 'question')->where('id', $id)->first();
        return view('admin.transactions.show', compact('transaction'));
    }

    public function steps()
    {
        return 'steps';
    }

    ////////////////////////////////////////////////// Center Transactions /////////////////////////////////
    ///
    public function center_transaction()
    {
        $transactions = Order::with('seller', 'buyer', 'question', 'inspectiontype')->where('inspection_center', Auth::guard('center')->id())->orderBy('id', 'desc')->get();
        // dd($transactions);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function results($id, Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'files.*' => 'required|mimes:jpeg,png,jpg,doc,docx,pdf|max:5120', // الحجم الأقصى 5 ميجا = 5120 كيلوبايت
            ];

            $messages = [
                'files.*.required' => 'يجب رفع ملف واحد على الأقل',
                'files.*.mimes' => 'يجب أن تكون الملفات من الأنواع: jpeg, png, jpg, doc, docx, pdf',
                'files.*.max' => 'حجم الملف لا يجب أن يتجاوز 5 ميجا',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = $this->saveImage($file, public_path('assets/uploads/results/'));
                    // حفظ الملف في قاعدة البيانات
                    \App\Models\admin\TransactionResult::create([
                        'transaction_id' => $data['transaction_id'],
                        'file' => $filename
                    ]);
                }
            }
            return $this->success_message(' تم نتائج الفحص بنجاح  ');
        }
        $transaction = Order::with('TransactionResult')->findOrFail($id);
       // dd($transaction);
        return view('admin.transactions.upload_results', compact('transaction'));
    }

    public function delete_result($id)
    {
        $result = \App\Models\admin\TransactionResult::findOrFail($id);
        // تحديد المسار الكامل للملف
        $filePath = public_path('assets/uploads/results/' . $result->file);

        // التحقق مما إذا كان الملف موجودًا
        if (file_exists($filePath)) {
            unlink($filePath);  // حذف الملف من المسار
        }
        $result->delete();
        return $this->success_message(' تم حذف الملف بنجاح  ');
    }
}
