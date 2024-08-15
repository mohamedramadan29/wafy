@extends('front.layouts.master')
@section('title')
    تفاصيل المعاملة  - {{ $transaction['title'] }}
@endsection
@section('content')
    <div class="page_content">
        <div class="main_dashboard">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="main_dashboard_sidebar">
                                @if(auth()->user())
                                    <div class="user_data">
                                        <div class="image">
                                            @if(auth()->user()->image !='')
                                                <img
                                                    src="{{asset('assets/uploads/user_images/'.auth()->user()->image)}}"
                                                    alt="">
                                            @else
                                                <img src="{{asset('assets/uploads/user_images/user_avatar.png')}}"
                                                     alt="">
                                            @endif
                                        </div>
                                        <div class="info">
                                            <p> مرحبا ، {{ auth()->user()->name }} </p>
                                            <span>  <i class="bi bi-phone"></i>  {{auth()->user()->phone}} </span>
                                            <br>
                                            <a href="{{url('user/logout')}}"> تسجيل خروج </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="start_order">
                                        <a href="{{url('user/transactions')}}" class="btn btn-warning global_button">
                                            جميع المعاملات <i class="bi bi-arrow-left"></i> </a>
                                        <br>
                                        <br>
                                        <a href="{{url('user/add-transaction')}}" class="btn btn-primary global_button">
                                            بدء معاملة جديد <i class="bi bi-plus-circle"></i> </a>
                                        <br>
                                        <br>
                                        <a href="{{url('user/profile')}}" class="btn btn-success global_button"> بيانات
                                            حسابي <i class="bi bi-pencil-square"></i> </a>
                                        <br>
                                        <br>
                                        <a href="{{url('user/change-password')}}" class="btn btn-danger global_button">
                                            تعديل رمز الحماية <i class="bi bi-lock"></i> </a>
                                    </div>
                                @else
                                    <a href="{{url('register')}}" class="btn btn-primary btn-lg"> سجل دخولك الان لبداية
                                        معاملة جديدة<i class="bi bi-arrow-left"></i> </a>
                                @endif

                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="last_order">
                                @if (Session::has('Success_message'))
                                    <div class="alert alert-success"> {{Session::get('Success_message')}} </div>
                                    @php
                                        //emotify('success', \Illuminate\Support\Facades\Session::get('Success_message'));

                                    @endphp
                                @endif
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger"> {{$error}} </div>
                                        @php
                                            //  emotify('error', $error);
                                        @endphp
                                    @endforeach
                                @endif
                                <div class="head_section">
                                    <div>
                                        <h4> تفاصيل المعاملة </h4>
                                    </div>
                                </div>

                                <div class="add_order">
                                    <form id="multiStepForm"
                                          action="{{url('user/transaction/buyer_start/'.$transaction['seller_id'].'-'.$transaction['slug'])}}"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="step" id="step1">
                                            <h5> المعلومات العامة </h5>
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="title"> عنوان المعاملة <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="title" id="title"
                                                               class="form-control"
                                                               value="{{$transaction['title']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="price"> السعر <span class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="number" name="price" id="price"
                                                               class="form-control"
                                                               value="{{$transaction['price']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="box">
                                                    <label for="description"> الوصف <span class="star"> *  </span>
                                                    </label>
                                                    <textarea readonly disabled rows="8" name="description"
                                                              id="description"
                                                              class="form-control">{{$transaction['description']}}</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <div class="car_images">
                                                            @php $car_images = explode(',',$transaction['images']);
                                                            @endphp
                                                            @foreach($car_images as $image)
                                                                <div>
                                                                    <img
                                                                        src="{{asset('assets/uploads/car_images/'.$image)}}"
                                                                        alt="">
                                                                </div>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- الخطوة 2 -->
                                        <div class="step" id="step2">
                                            <h5> معلومات السيارة </h5>
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_mark"> الماركة <span class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="car_mark"
                                                               id="car_mark"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_mark']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_model"> الموديل <span class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="car_model"
                                                               id="car_model"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_model']}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_mark"> سنة الصنع <span class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="number" name="car_year"
                                                               id="car_year"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_year']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="body_type"> نوع الجسم <span class="star"> *  </span>
                                                        </label>
                                                        <select readonly disabled name="body_type" id="body_type"
                                                                class="form-control select2">
                                                            <option value="" selected readonly=""> -- حدد --</option>
                                                            <option
                                                                @if($transaction['question']['body_type'] == 'سيدان') selected
                                                                @endif value="سيدان">سيدان
                                                            </option>
                                                            <option
                                                                @if($transaction['question']['body_type'] == 'SUV') selected
                                                                @endif value="SUV">SUV
                                                            </option>
                                                            <option
                                                                @if($transaction['question']['body_type'] == 'كوبيه') selected
                                                                @endif value="كوبيه">كوبيه
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="door_number"> عدد الابواب <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="number" name="door_number"
                                                               id="door_number"
                                                               class="form-control"
                                                               value="{{$transaction['question']['door_number']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_color"> لون السيارة <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="car_color"
                                                               id="car_color"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_color']}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_distance"> المسافة المقطوعة <span
                                                                class="badge badge-danger bg-danger"> الكيلومترات  </span>
                                                            <span class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="number" name="car_distance"
                                                               id="car_distance"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_distance']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="solar_type"> نوع الوقود <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="solar_type"
                                                               id="solar_type"
                                                               class="form-control"
                                                               value="{{$transaction['question']['solar_type']}}">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="engine_capacity"> سعة المحرك <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="engine_capacity"
                                                               id="engine_capacity"
                                                               class="form-control"
                                                               value="{{$transaction['question']['engine_capacity']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_transmission"> ناقل الحركة <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="car_transmission"
                                                               id="car_transmission"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_transmission']}}">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_accedant"> الحوادث ان وجدت <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="car_accedant"
                                                               id="car_accedant"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_accedant']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_any_damage"> وجود أي أضرار أو خدوش <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="car_any_damage"
                                                               id="car_any_damage"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_any_damage']}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="tire_condition"> حالة الإطارات <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input readonly disabled type="text" name="tire_condition"
                                                               id="tire_condition"
                                                               class="form-control"
                                                               value="{{$transaction['question']['tire_condition']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            @if(auth()->user())
                                                @if(auth()->user()->id != $transaction['seller_id'])
                                                    @if($transaction['buyer_id'] == null)
                                                        <button type="submit" class="btn btn-primary"> بداية معاملة شراء
                                                            <i
                                                                class="bi bi-floppy-fill"></i></button>
                                                    @endif

                                                @endif
                                            @else
                                                <a href="{{url('register')}}" class="btn btn-primary"> سجل دخولك الان
                                                    لبداية معاملة جديدة </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
