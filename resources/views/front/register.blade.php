@extends('front.layouts.master')
@section('title')
    تسجيل دخول
@endsection
@section('content')
    <div class="page_content">

        <div class="register_page">
            <div class="container">
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
                <div class="data">
                    <div class="row">
                        <div class="col-lg-6 col-12">

                            <div class="account_type">
                                <div class="type seller active" data-target="login">
                                    تسجيل دخول
                                </div>
                                <div class="type buyer" data-target="register">
                                    حساب جديد
                                </div>
                            </div>
                            <script>
                                document.querySelectorAll('.type').forEach(function (element) {
                                    element.addEventListener('click', function () {
                                        // Remove active class from all type elements
                                        document.querySelectorAll('.type').forEach(function (el) {
                                            el.classList.remove('active');
                                        });

                                        // Add active class to clicked element
                                        element.classList.add('active');

                                        // Hide all about_seller_buyer sections
                                        document.querySelectorAll('.login').forEach(function (section) {
                                            section.classList.remove('active');
                                        });

                                        // Show the targeted about_seller_buyer section
                                        var target = element.getAttribute('data-target');
                                        document.getElementById(target).classList.add('active');
                                    });
                                });
                            </script>
                            <div class="login active" id="login">
                                <form method="post" action="{{url('login')}}">
                                    @csrf
                                    <div class="box">
                                        <label for="phone"> رقم الهاتف <span class="star"> * </span> </label>
                                        <input type="text" class="form-control" value="{{old('phone')}}" name="phone" id="phone">
                                    </div>
                                    <div class="box">
                                        <label for="password"> رمز الحماية <span class="star"> * </span> <a href="{{url('forget-password')}}"> نسيت رمز الحماية ؟ </a> </label>
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
                                        <button type="submit" class=" btn btn-primary global_button"> تسجيل دخول
                                        </button>
                                    </div>
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
                            </div>

                            <div class="login" id="register">
                                <form method="post" action="">
                                    @csrf
                                    <div class="box">
                                        <label for="name"> الاسم <span class="star"> * </span> </label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                    <div class="box">
                                        <label for="phone"> رقم الهاتف <span class="star"> * </span> </label>
                                        <input type="text" class="form-control" name="phone" id="phone">
                                    </div>
{{--                                    <div class="box">--}}
{{--                                        <label for="password"> رمز الحماية <span class="star"> * </span> </label>--}}
{{--                                        <input type="password" class="form-control" name="password" id="password">--}}
{{--                                    </div>--}}
                                    <div class="box">
                                        <label for="password"> رمز الحماية <span class="star"> * </span> </label>
                                        <div id="code-input2">
                                            <input type="password" maxlength="1" class="code-digit2 form-control" name="password[]" id="password1" autofocus>
                                            <input type="password" maxlength="1" class="code-digit2 form-control" name="password[]" id="password2">
                                            <input type="password" maxlength="1" class="code-digit2 form-control" name="password[]" id="password3">
                                            <input type="password" maxlength="1" class="code-digit2 form-control" name="password[]" id="password4">
                                            <input type="password" maxlength="1" class="code-digit2 form-control" name="password[]" id="password5">
                                            <input type="password" maxlength="1" class="code-digit2 form-control" name="password[]" id="password6">
                                        </div>
                                    </div>
                                    <div class="box">
                                        <button type="submit" class=" btn btn-primary global_button"> حساب جديد
                                        </button>
                                    </div>
                                </form>
                            </div>

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

                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info">
                                <img src="{{asset('assets/website/uploads/seller.webp')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </>
        </div>

    </div>
@endsection
