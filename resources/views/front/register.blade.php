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
                                        <input type="text" class="form-control" name="phone" id="phone">
                                    </div>
                                    <div class="box">
                                        <label for="password"> رمز الحماية <span class="star"> * </span> </label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <div class="box">
                                        <button type="submit" class=" btn btn-primary global_button"> تسجيل دخول
                                        </button>
                                    </div>
                                </form>
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
                                    <div class="box">
                                        <label for="password"> رمز الحماية <span class="star"> * </span> </label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <div class="box">
                                        <button type="submit" class=" btn btn-primary global_button"> حساب جديد
                                        </button>
                                    </div>
                                </form>
                            </div>

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
