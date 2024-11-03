@extends('front.layouts.master')
@section('title')
    تحديد مركز الصيانة وتمام الدفع   - {{ $transaction['title'] }}
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
                                        <h4> تحديد مركز  الصيانة ونوع الفحص  </h4>
                                    </div>
                                </div>
                                <div class="add_order">
                                    <form
                                        action="{{url('transaction/selectcenter/'.$transaction['id'])}}"
                                        method="post" autocomplete="off">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="box">
                                                <label for="center">حدد مركز
                                                    الصيانة</label>
                                                <select required name="center"
                                                        class="form-control"
                                                        id="center_{{$transaction['id']}}"
                                                        onchange="loadInspectionTypes({{$transaction['id']}})">
                                                    <option value="">-- حدد --
                                                    </option>
                                                    @foreach($centers as $center)
                                                        <option
                                                            value="{{$center['id']}}">{{$center['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="box">
                                                <label for="type">حدد نوع
                                                    الفحص</label>
                                                <select required
                                                        name="inspection_type"
                                                        class="form-control"
                                                        id="type_{{$transaction['id']}}"
                                                        onchange="loadInspectionPrice({{$transaction['id']}})">
                                                    <option value="">-- حدد --
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="box">
                                                <label for="type_price"> سعر
                                                    الفحص <span
                                                        class="badge badge-danger bg-danger"> ريال  </span>
                                                </label>
                                                <input name="price" required
                                                       class="form-control"
                                                       id="type_price_{{$transaction['id']}}"
                                                       type="number" readonly
                                                       value="">
                                            </div>
                                            <div class="box">
                                                <label for="tax"> قيمة العربون   <span
                                                        class="badge badge-danger bg-danger"> ريال  </span>
                                                </label>
                                                <input style="text-align: right" name="tax" required
                                                       class="form-control"
                                                       id=""
                                                       type="number" readonly disabled
                                                       value="{{$buyer_tax}}">
                                            </div>
                                            <div class="row">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                           id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        الموافقة علي <a href="{{url('terms')}}" target="_blank"> الشروط
                                                            والاحكام </a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                            <button type="submit"
                                                    class="btn btn-primary">
                                                الدفع وتاكيد الحجز        <i class="bi bi-credit-card"></i>
                                            </button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------------- Start Faq Us --------------------->
        <div class="faq" id="faq">
            <div class="container">
                <div class="data">
                    <h4> الأسئلة الشائعة </h4>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne">
                                    كيف يمكنني بدء عملية بيع سيارة على الموقع؟
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    ابدأ بإنشاء حساب وتسجيل الدخول، ثم قم بإدخال تفاصيل سيارتك مع الصور والمعلومات
                                    المطلوبة. بعد ذلك، يمكنك مشاركة رابط العملية مع المشتري لإتمام الصفقة.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseTwo">
                                    . هل يمكنني اختيار مركز الفحص؟
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    نعم، يمكنك اختيار مركز فحص معتمد من ضمن المراكز المتاحة على الموقع. يتيح لك ذلك ضمان
                                    جودة الفحص وشفافية النتائج.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseThree">
                                    كيف تتم حماية مدفوعاتي كمشتري؟
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    مدفوعاتك تبقى محمية بالكامل حتى يتم الفحص وتتأكد من مطابقة السيارة للمواصفات. بعد
                                    ذلك، تكتمل عملية الدفع للبائع بأمان.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseFour">
                                    هل يمكنني التفاوض على السعر؟
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    بالتأكيد، بعد الاطلاع على تقرير الفحص وتقييم السيارة، يمكنك التفاوض مع البائع حتى
                                    الوصول إلى اتفاق يناسب الطرفين.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseFive">
                                    ما هي طرق الدفع المتاحة؟
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    نوفر طرق دفع آمنة ومتعددة على المنصة لضمان راحة وأمان جميع الأطراف أثناء إتمام
                                    الصفقات.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------- End Faq US ----------------------->
    </div>

@endsection

@section('js')

<script>
    function loadInspectionTypes(transactionId) {
        let centerId = document.getElementById('center_' + transactionId).value;
        let typeSelect = document.getElementById('type_' + transactionId);

        // إعادة تعيين القائمة المنسدلة لأنواع الفحص
        typeSelect.innerHTML = '<option value="">-- حدد --</option>';

        if (centerId) {
            fetch(`/get-inspection-types/${centerId}`)
                .then(response => response.json())
                .then(data => {
                    data.types.forEach(type => {
                        let option = document.createElement('option');
                        option.value = type.id;
                        option.text = type.name;
                        typeSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function loadInspectionPrice(transactionId) {
        let typeId = document.getElementById('type_' + transactionId).value;
        let priceInput = document.getElementById('type_price_' + transactionId);

        if (typeId) {
            fetch(`/get-inspection-price/${typeId}`)
                .then(response => response.json())
                .then(data => {
                    priceInput.value = data.price;
                })
                .catch(error => console.error('Error:', error));
        }
    }

</script>

@endsection
