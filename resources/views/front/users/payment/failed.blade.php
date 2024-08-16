@extends('front.layouts.master')
@section('title')
    حسابي  - فشل عملية الدفع
@endsection
@section('content')
    <div class="page_content">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="message-box _success _failed">
                        <i class="bi bi-x-circle" aria-hidden="true"></i>
                        <h2>  للاسف لم تتم عملية الدفع  </h2>
                        <p>  حاول في وقت اخر  </p>
                        <a href="{{url('user/transactions')}}" class="btn btn-danger"> الرجوع الي حسابي  </a>

                    </div>
                </div>
            </div>

        </div>


    </div>

    <style>
        ._failed {
            border-bottom: solid 4px red !important;
        }

        ._failed i {
            color: red !important;
        }

        ._success {
            box-shadow: 0 15px 25px #00000019;
            padding: 45px;
            width: 100%;
            text-align: center;
            margin: 40px auto;
            border-bottom: solid 4px #28a745;
        }

        ._success i {
            font-size: 55px;
            color: #28a745;
        }

        ._success h2 {
            margin-bottom: 12px;
            font-size: 40px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 10px;
        }

        ._success p {
            margin-bottom: 0px;
            font-size: 18px;
            color: #495057;
            font-weight: 500;
        }
    </style>

@endsection
