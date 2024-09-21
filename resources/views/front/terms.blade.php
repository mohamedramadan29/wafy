@extends('front.layouts.master')
@section('title')
   وفي - الشروط والاحكام
@endsection
@section('content')
    <div class="page_content">
        <div class="hero" style="min-height: 300px; background-image:url({{asset('assets/website/uploads/hero.jpg')}})">
            <div class="container">
                <div class="data">
                    <h3>  الشروط والاحكام  </h3>
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
                               {!! $terms['terms'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
