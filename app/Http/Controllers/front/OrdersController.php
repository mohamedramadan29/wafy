<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Slug_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\front\Order;
use App\Models\front\OrderQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    use Message_Trait;
    use Slug_Trait;
    use Upload_Images;

    public function index()
    {
        $transactions = Order::where('seller_id', Auth::id())->orwhere('buyer_id', Auth::id())->orderby('id','DESC')->get();
        return view('front.users.transactions', compact('transactions'));
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

            $CountOldSlug = Order::where('slug', $this->CustomeSlug($data['title']))->where('id','!=',$transaction_question['id'])->count();
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

    public function show($seller_id,$slug)
    {
        $transaction_count = Order::with('question')->where('seller_id', $seller_id)->where('slug', $slug)->count();
        if ($transaction_count > 0) {
            $transaction = Order::with('question')->where('seller_id', Auth::id())->where('slug', $slug)->first();
            $transaction_question = OrderQuestion::findOrFail($transaction['id']);
        } else {
            abort('404');
        }
        return view('front.show-transaction',compact('transaction'));
    }
    public function delete($id)
    {
        $transaction = Order::findOrFail($id);
        $transaction->delete();
        return $this->success_message(' تم حذف المعاملة بنجاح  ');
    }
}
