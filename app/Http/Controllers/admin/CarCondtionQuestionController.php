<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\CarConditionOption;
use App\Models\admin\CarConditionQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CarCondtionQuestionController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $questions = CarConditionQuestion::with('options')->get();
        //dd($questions);
        return view('admin.questions.index',compact('questions'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')){
            $data = $request->all();
           $rules = [
               'question'=>'required',
               'options'=>'required',
           ];
           $messages = [];
           $validator = Validator::make($data,$rules,$messages);
           if ($validator->fails()){
               return Redirect::back()->withInput()->withErrors($validator);
           }
           $question = new CarConditionQuestion();
           $question->question = $data['question'];
           $question->save();
            $questionOptions = explode('-', $data['options']);
           foreach ($questionOptions as $option){
               CarConditionOption::create([
                   'question_id'=>$question->id,
                   'option'=>trim($option),
               ]);
           }
           return $this->success_message(' تم اضافة السوال بنجاح  ');
        }
        return view('admin.questions.store');
    }
    public function update(Request $request,$id)
    {
       // $question = CarConditionQuestion::findOrFail($id);
        $question = CarConditionQuestion::with('options')->where('id',$id)->first();
        if ($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'question'=>'required',
                'options'=>'required',
            ];
            $messages = [];
            $validator = Validator::make($data,$rules,$messages);
            if ($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $question->update([
                'question'=>$data['question'],
            ]);
            /// Delete Old Options
            CarConditionOption::where('question_id', $question->id)->delete();
            $questionOptions = explode('-', $data['options']);
            foreach ($questionOptions as $option){
                CarConditionOption::create([
                    'question_id'=>$question->id,
                    'option'=>trim($option),
                ]);
            }
            return $this->success_message(' تم اضافة السوال بنجاح  ');
        }
        return view('admin.questions.update',compact('question'));
    }
    public function delete($id)
    {
        $question = CarConditionQuestion::findOrFail($id);
        $question->delete();
        return $this->success_message(' تم حذف السوال بنجاح  ');
    }
}
