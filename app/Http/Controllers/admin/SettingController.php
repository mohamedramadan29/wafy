<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Http\Traits\Upload_Images;
use App\Models\admin\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    use Message_Trait;
    use Upload_Images;
    public function index()
    {
        $setting = Settings::first();
        return view('admin.website_settings.index',compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        try {
            $rules =[ ];
            $messages = [];
            $validator = Validator::make($data,$rules,$messages);
            if ($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $setting = Settings::first();
            if ($request->hasFile('logo')){
                ///////Delete Old Image
                $oldimage = public_path('assets/uploads/settings/'.$setting['logo']);
                if (file_exists($oldimage)){
                    unlink($oldimage);
                }
                $filename = $this->saveImage($request->file('logo'),public_path('assets/uploads/settings'));

                $setting->update([
                    'logo'=>$filename
                ]);
            }
            $setting->update([
                'name'=>$data['name'],
                'description'=>$data['description'],
                'buyer_tax'=>$data['buyer_tax'],
            ]);

            return $this->success_message(' تم التعديل بنجاح  ');

        }catch (\Exception $e){
         return   $this->exception_message($e);
        }
    }
}
