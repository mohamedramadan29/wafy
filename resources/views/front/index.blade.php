@extends('front.layouts.master')
@section('title')
    وفي - الرئيسية
@endsection
@section('content')
    <div class="page_content">
        <div class="hero" style="background-image:url({{asset('assets/website/uploads/hero.jpg')}})">
            <div class="container">
                <div class="data">
                    <h3> نحمي المعاملات ونحفظ </br>
                        الحقوق بين الأفراد </h3>
                    <div class="user_type">
                        <div class="type seller active" data-target="seller">
                            بائع
                        </div>
                        <div class="type buyer" data-target="buyer">
                            مشتري
                        </div>
                    </div>
                    <script>
                        document.querySelectorAll('.type').forEach(function(element) {
                            element.addEventListener('click', function() {
                                // Remove active class from all type elements
                                document.querySelectorAll('.type').forEach(function(el) {
                                    el.classList.remove('active');
                                });

                                // Add active class to clicked element
                                element.classList.add('active');

                                // Hide all about_seller_buyer sections
                                document.querySelectorAll('.about_seller_buyer').forEach(function(section) {
                                    section.classList.remove('active');
                                });

                                // Show the targeted about_seller_buyer section
                                var target = element.getAttribute('data-target');
                                document.getElementById(target).classList.add('active');
                            });
                        });
                    </script>
                </div>

            </div>
        </div>

        <!-------------------------------- Start Content About Seller And Buyer -------------->
        <div class="about_seller_buyer active" id="seller">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info">
                                <h4> أموال محفوظة .. جودة مضمونة </h4>
                                <p> مدفوعاتك محفوظة، حتى تستلم المنتج أو الخدمة </p>
                                <a href="{{url('register')}}" class="btn btn-primary global_button" > بيع الان  <i class="bi bi-arrow-left"></i> </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="image">
                                <img src="{{asset('assets/website/uploads/seller.webp')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about_seller_buyer" id="buyer">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info">
                                <h4> أنت موثوق، مبيعاتك متزايدة </h4>
                                <p> مدفوعاتك محفوظة، حتى تستلم المنتج أو الخدمة </p>
                                <a href="{{url('register')}}" class="btn btn-primary global_button" > اشتري الان  <i class="bi bi-arrow-left"></i> </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="image">
                                <img src="{{asset('assets/website/uploads/buyer.webp')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
