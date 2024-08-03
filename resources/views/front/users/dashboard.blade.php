@extends('front.layouts.master')
@section('title')
   حسابي  - المعاملات الاخيرة
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
                                        <img src="{{asset('assets/website/uploads/seller.webp')}}" alt="">
                                    </div>
                                    <div class="info">
                                        <p> مرحبا ، {{ auth()->user()->name }} </p>
                                        <span>  <i class="bi bi-phone"></i>  {{auth()->user()->phone}} </span>
                                    </div>
                                </div>
                                <br>
                                <div class="start_order">
                                    <a href="{{url('user/start_order')}}" class="btn btn-primary global_button"> بدء معاملة جديد <i class="bi bi-plus-circle"></i>  </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="last_order">
                              <div class="head_section">
                                  <div>
                                  <h4> المعاملات الاخيرة </h4>
                                  </div>
                                  <div><a href="{{url('user/orders')}}" class="btn btn-primary"> جميع المعاملات <i class="bi bi-arrow-left"></i>  </a> </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
