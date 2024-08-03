<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\front\Order;
use App\Models\front\OrderQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    use Message_Trait;

    public function start_order(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [];
            $messages = [];
            $validator = Validator::make($data,$rules,$messages);
            if ($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            DB::beginTransaction();
            $new_order = new Order();
            $new_order->seller_id = auth()->id();
            $new_order->title = $data['title'];
            $new_order->price = $data['price'];
            $new_order->description = $data['description'];
            $new_order->images = "Files";
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
            return  $this->success_message(' تم اضافة المعاملة بنجاح  ');
        }

        return view('front.users.start_order');
    }
}
