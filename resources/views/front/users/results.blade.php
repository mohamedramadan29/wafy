@extends('front.layouts.master')
@section('title')
    نتائج فحص المعاملة
@endsection
@section('content')
    <div class="page_content">
        <div class="main_dashboard">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="main_dashboard_sidebar">
                                <div class="user_data">
                                    <div class="image">
                                        @if(auth()->user()->image !='')
                                            <img src="{{asset('assets/uploads/user_images/'.auth()->user()->image)}}"
                                                 alt="">
                                        @else
                                            <img src="{{asset('assets/uploads/user_images/user_avatar.png')}}" alt="">
                                        @endif
                                    </div>
                                    <div class="info">
                                        <p> مرحبا ، {{ auth()->user()->name }} </p>
                                        <span>  <i class="bi bi-phone"></i>  {{auth()->user()->phone}} </span>
                                    </div>
                                </div>
                                <br>
                                <div class="start_order">
                                    <a href="{{url('user/transactions')}}" class="btn btn-warning global_button"> جميع
                                        المعاملات <i class="bi bi-arrow-left"></i> </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/add-transaction')}}" class="btn btn-primary global_button"> بدء
                                        معاملة جديد <i class="bi bi-plus-circle"></i> </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/profile')}}" class="btn btn-success global_button"> بيانات
                                        حسابي <i class="bi bi-pencil-square"></i> </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/change-password')}}" class="btn btn-danger global_button">
                                        تعديل رمز الحماية <i class="bi bi-lock"></i> </a>
                                </div>
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
                                        <h4> نتائة فحص السيارة </h4>
                                    </div>
                                </div>

                                <div class="add_order">
                                    <form id="CompanyRegister" action="" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <!-- الخطوة 1 -->
                                        <div class="step" id="step1">
                                            <h5> المعلومات العامة </h5>
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="title">رقم المعاملة : <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input disabled readonly type="text" name="title" id="title"
                                                               class="form-control"
                                                               value="{{$transaction['id']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="title"> عنوان الاعلان : <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input disabled readonly type="text" name="title" id="title"
                                                               class="form-control"
                                                               value="{{$transaction['title']}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step" id="step1">
                                            <h5> نتائج الفحص </h5>
                                            @csrf
                                            <div class="row">

                                                @if($transaction['TransactionResult']->count() > 0 )
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th> الملف</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($transaction['TransactionResult'] as $result)
                                                                <tr>
                                                                    <td><a target="_blank"
                                                                           class="btn btn-primary btn-sm"
                                                                           href="{{asset('assets/uploads/results/'.$result['file'])}}">
                                                                            مشاهدة
                                                                            الملف </a></td>

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="alert alert-info"> لم يتم رفع النتائج الي الان  </div>
                                                @endif
                                            </div>
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
