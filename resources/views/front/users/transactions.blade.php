@extends('front.layouts.master')
@section('title')
    حسابي - جميع المعاملات
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
                                        <h4> جميع المعاملات </h4>
                                    </div>
                                </div>
                                <div class="all_transations">
                                    @if(count($transactions)> 0)

                                        @foreach($transactions as $transaction )
                                            <div class="transaction">
                                                @php
                                                    $car_images = explode(',',$transaction['images']);
                                                    $first_image = $car_images[0];
                                                @endphp
                                                <div class="car_image">
                                                    <img src="{{asset('assets/uploads/car_images/'.$first_image)}}"
                                                         alt="">
                                                </div>
                                                <div class="transaction_info">
                                                    <div class="transaction_status">
                                                        @if($transaction['seller_id'] == \Illuminate\Support\Facades\Auth::id())
                                                            <div><span class="badge badge-success bg-info"> بيع  </span>
                                                            </div>
                                                        @elseif($transaction['buyer_id'] == Auth::id())
                                                            <div><span
                                                                    class="badge badge-success bg-warning"> مشتري   </span>
                                                            </div>
                                                        @endif

                                                        <div><span class="badge badge-success bg-success">  تمت عملية البيع بنجاح   </span>
                                                        </div>
                                                    </div>
                                                    <h4>  {{ $transaction['title'] }}  </h4>
                                                    <p class="price"><strong> السعر المطلوب
                                                            :: </strong> {{  number_format($transaction['price'],2) }}
                                                        ريال
                                                    </p>
                                                    <p class="date"><strong> تاريخ المعاملة
                                                            :: </strong> {{$transaction->created_at->diffForHumans()}}
                                                    </p>
                                                    <p class="description">
                                                        {{Str::words($transaction['description'],20,'...')}} </p>
                                                    <p class="transaction_link">
                                                        <input type="text" id="transactionLink" value="{{ $transaction['link'] }}" hidden>
                                                        <button class="btn btn-outline-success btn-sm" onclick="copyTransactionLink()">نسخ رابط المعاملة <i class="bi bi-clipboard-fill"></i></button>
                                                    </p>

                                                    <script>
                                                        function copyTransactionLink() {
                                                            // الحصول على الرابط من الـ input المخفي
                                                            var copyText = document.getElementById("transactionLink");

                                                            // إنشاء عنصر textarea مؤقت لنسخ الرابط إلى الحافظة
                                                            var tempInput = document.createElement("textarea");
                                                            tempInput.value = copyText.value;
                                                            document.body.appendChild(tempInput);

                                                            // تحديد النص داخل textarea ونسخه
                                                            tempInput.select();
                                                            document.execCommand("copy");

                                                            // إزالة textarea المؤقتة
                                                            document.body.removeChild(tempInput);

                                                            // تأكيد النسخ للمستخدم
                                                            alert("تم نسخ رابط المعاملة: " + tempInput.value);
                                                        }
                                                    </script>


                                                @if($transaction['seller_id'] == Auth::id())
                                                        <div class="actions">
                                                            <a href="{{url('transaction/'.$transaction['seller_id'].'-'.$transaction['slug'])}}"
                                                               class="btn btn-warning btn-sm"> مشاهدة المعاملة  <i class="bi bi-eye"></i> </a>
                                                            <a href="{{url('user/transaction/edit/'.$transaction['seller_id'].'-'.$transaction['slug'])}}"
                                                               class="btn btn-primary btn-sm"> تعديل المعاملة <i
                                                                    class="bi bi-pencil-square"></i> </a>
                                                            <a onclick="return confirm(' هل انت متاكد من حذف المعاملة !! ')"
                                                               href="{{url('user/transaction/delete/'.$transaction['id'])}}"
                                                               class="btn btn-danger btn-sm"> حذف المعاملة <i
                                                                    class="bi bi-archive-fill"></i> </a>
                                                        </div>
                                                    @else
                                                        <div class="actions">
                                                            <a href="{{url('transaction/'.$transaction['seller_id'].'-'.$transaction['slug'])}}" class="btn btn-warning btn-sm"> كامل التفاصيل   <i
                                                                    class="bi bi-eye"></i> </a>

                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="other_person">
                                                    <h5> تفاصيل المشتري </h5>
                                                    <div class="user_data">
                                                        <div class="image">
                                                            <img src="{{asset('assets/website/uploads/seller.webp')}}"
                                                                 alt="">
                                                        </div>
                                                        <div class="info">
                                                            <p> {{ auth()->user()->name }} </p>
                                                            <span>  <i class="bi bi-phone"></i>  {{auth()->user()->phone}} </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info"> لا يوجد لديك معاملات في الوقت الحالي</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
