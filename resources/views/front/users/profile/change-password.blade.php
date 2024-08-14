@extends('front.layouts.master')
@section('title')
   حسابي - تعديل رمز الحماية
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
                                            <img src="{{asset('assets/uploads/user_images/'.auth()->user()->image)}}" alt="">
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
                                    <a href="{{url('user/transactions')}}" class="btn btn-warning global_button">  جميع المعاملات  <i class="bi bi-arrow-left"></i>  </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/add-transaction')}}" class="btn btn-primary global_button"> بدء معاملة جديد <i class="bi bi-plus-circle"></i>  </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/profile')}}" class="btn btn-success global_button"> بيانات حسابي  <i class="bi bi-pencil-square"></i>  </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/change-password')}}" class="btn btn-danger global_button">  تعديل رمز الحماية   <i class="bi bi-lock"></i> </a>
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
                                        <h4> تعديل رمز الحماية  </h4>
                                    </div>
                                </div>
                                <div class="add_order">
                                    <form action="{{url('user/change-password')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="box">
                                                <label for="password"> رمز الحماية الحالي  <span class="star"> * </span> </label>
                                                <div id="code-input">
                                                    <input type="password" maxlength="1" class="code-digit form-control" name="password[]" id="password1" autofocus>
                                                    <input type="password" maxlength="1" class="code-digit form-control" name="password[]" id="password2">
                                                    <input type="password" maxlength="1" class="code-digit form-control" name="password[]" id="password3">
                                                    <input type="password" maxlength="1" class="code-digit form-control" name="password[]" id="password4">
                                                    <input type="password" maxlength="1" class="code-digit form-control" name="password[]" id="password5">
                                                    <input type="password" maxlength="1" class="code-digit form-control" name="password[]" id="password6">
                                                </div>
                                            </div>
                                            <div class="box">
                                                <label for="new_password">  رمز الحماية  الجديد <span class="star"> * </span> </label>
                                                <div id="code-input2">
                                                    <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password1" autofocus>
                                                    <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password2">
                                                    <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password3">
                                                    <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password4">
                                                    <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password5">
                                                    <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password6">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                             تعديل رمز الحماية  <i class="bi bi-lock"></i>  </button>
                                    </form>
                                    <script>
                                        const inputs = document.querySelectorAll('.code-digit');

                                        // التنقل للأمام عند إدخال رقم
                                        inputs.forEach((input, index) => {
                                            input.addEventListener('input', () => {
                                                if (input.value.length === 1 && index < inputs.length - 1) {
                                                    inputs[index + 1].focus();
                                                }
                                            });
                                        });

                                        // التنقل للخلف عند الضغط على Backspace
                                        inputs.forEach((input, index) => {
                                            input.addEventListener('keydown', (event) => {
                                                if (event.key === 'Backspace' && input.value.length === 0 && index > 0) {
                                                    inputs[index - 1].focus();
                                                }
                                            });
                                        });

                                    </script>
                                    <script>
                                        const inputs2 = document.querySelectorAll('.code-digit2');

                                        // التنقل للأمام عند إدخال رقم
                                        inputs2.forEach((input, index) => {
                                            input.addEventListener('input', () => {
                                                if (input.value.length === 1 && index < inputs2.length - 1) {
                                                    inputs2[index + 1].focus();
                                                }
                                            });
                                        });

                                        // التنقل للخلف عند الضغط على Backspace
                                        inputs2.forEach((input, index) => {
                                            input.addEventListener('keydown', (event) => {
                                                if (event.key === 'Backspace' && input.value.length === 0 && index > 0) {
                                                    inputs2[index - 1].focus();
                                                }
                                            });
                                        });

                                    </script>

                                    <style>
                                        #code-input,
                                        #code-input2{
                                            display: flex;
                                            justify-content: space-between;
                                            max-width: 50%;
                                            direction: ltr; /* يجعل اتجاه الإدخال من اليسار إلى اليمين */
                                        }
                                        .code-digit2,
                                        .code-digit{
                                            width: 50px;
                                            height: 50px !important;
                                            text-align: center;
                                            margin-right: 5px;
                                            font-size: 20px;
                                            direction: ltr; /* يضمن أن الإدخال يبدأ من اليسار */

                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
