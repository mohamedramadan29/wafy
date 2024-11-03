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
                                        <h4> جميع المعاملات </h4>
                                    </div>
                                </div>
                                <div class="all_transations">
                                    @if(count($transactions)> 0)
                                        @foreach($transactions as $index => $transaction  )
                                            <div class="transaction">
                                                @php
                                                    $car_images = explode(',',$transaction['images']);
                                                    $first_image = $car_images[0];
                                                @endphp
                                                <div class="car_image">
                                                    <img src="{{ asset('assets/uploads/car_images/'.$transaction['front_image']) }}"
                                                         alt="">
                                                </div>
                                                <div class="transaction_info">
                                                    <div class="transaction_status">
                                                        @if($transaction['seller_id'] == \Illuminate\Support\Facades\Auth::id())
                                                            <div><span class="badge badge-success bg-info"> بيع  </span>
                                                            </div>
                                                        @elseif($transaction['buyer_id'] == Auth::id())
                                                            <div><span
                                                                    class="badge badge-success bg-warning"> شراء </span>
                                                            </div>
                                                        @endif

                                                        <div><span
                                                                class="badge badge-success bg-danger">  {{$transaction['status']}}   </span>
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
                                                        <input type="text" id="transactionLink{{ $index }}"
                                                               value="{{ $transaction['link'] }}" hidden>
                                                        <button class="btn btn-outline-success btn-sm"
                                                                onclick="copyTransactionLink('{{ $index }}')">نسخ رابط
                                                            المعاملة <i class="bi bi-clipboard-fill"></i></button>
                                                    </p>
                                                    <script>
                                                        function copyTransactionLink(index) {
                                                            // الحصول على الرابط من الـ input المخفي
                                                            var copyText = document.getElementById("transactionLink" + index);

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
                                                               class="btn btn-warning btn-sm"> كامل التفاصيل <i
                                                                    class="bi bi-eye"></i> </a>
                                                            @if($transaction['status'] =='بداية المعاملة ')
                                                                <a href="{{url('user/transaction/edit/'.$transaction['seller_id'].'-'.$transaction['slug'])}}"
                                                                   class="btn btn-primary btn-sm"> تعديل المعاملة <i
                                                                        class="bi bi-pencil-square"></i> </a>
                                                                <a onclick="return confirm(' هل انت متاكد من حذف المعاملة !! ')"
                                                                   href="{{url('user/transaction/delete/'.$transaction['id'])}}"
                                                                   class="btn btn-danger btn-sm"> حذف المعاملة <i
                                                                        class="bi bi-archive-fill"></i> </a>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="actions">
                                                            <a href="{{url('transaction/'.$transaction['seller_id'].'-'.$transaction['slug'])}}"
                                                               class="btn btn-warning btn-sm"> كامل التفاصيل <i
                                                                    class="bi bi-eye"></i> </a>
                                                            @if($transaction['status'] == ' بداية عملية الشراء ')
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#selectcenter_{{$transaction['id']}}">
                                                                    تحديد مركز الصيانة
                                                                    ونوع الفحص <i
                                                                        class="bi bi-eye"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade"
                                                                     id="selectcenter_{{$transaction['id']}}"
                                                                     tabindex="-1"
                                                                     aria-labelledby="exampleModalLabel"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5"
                                                                                    id="exampleModalLabel">تحديد مركز
                                                                                    الصيانة ونوع الفحص</h1>
                                                                                <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                            </div>
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
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">رجوع
                                                                                    </button>
                                                                                    <button type="submit"
                                                                                            class="btn btn-primary">
                                                                                        تأكيد وإنشاء فاتورة
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            @endif


                                                        </div>
                                                    @endif
                                                </div>
                                                @if(auth()->user()->id == $transaction['seller_id'])

                                                    <div class="other_person">
                                                        <h5> تفاصيل المشتري </h5>
                                                        @if($transaction['buyer_id'] != '')
                                                            <div class="user_data">
                                                                <div class="image">
                                                                    @if($transaction['buyer']['image'] !='')
                                                                        <img
                                                                            src="{{asset('assets/uploads/user_images/'.$transaction['buyer']['image'])}}"
                                                                            alt="">
                                                                    @else
                                                                        <img
                                                                            src="{{asset('assets/uploads/user_images/user_avatar.png')}}"
                                                                            alt="">
                                                                    @endif
                                                                </div>
                                                                <div class="info">
                                                                    <p> {{ $transaction['buyer']['name'] }} </p>
                                                                    <span>  <i class="bi bi-phone"></i>  {{$transaction['buyer']['phone']}} </span>
                                                                </div>
                                                            </div>
                                                            @if($transaction['status'] == ' بداية عملية الشراء ')
                                                                <div class="alert alert-info"> من فضلك انتظر اختيار مركز
                                                                    الصيانة من قبل المشتري
                                                                </div>
                                                            @elseif($transaction['status'] == 'تم تحديد مركز الصيانة ونوع الفحص' && $transaction['seller_buy'] != 1)
                                                                <div class="alert alert-info">
                                                                    تم تحديد مركز الفحص ونوع الفحص والسعر
                                                                    <a href="{{url('transaction_invoice/'.$transaction['seller_id'].'-'.$transaction['slug'])}}" class="btn btn-primary">
                                                                    اتمام الدفع من جانبك
                                                                    </a>
                                                                </div>
                                                            @elseif($transaction['status'] == 'تم تحديد مركز الصيانة ونوع الفحص' && $transaction['buyer_buy'] == 1)
                                                                <div class="alert alert-info">
                                                                    تم الدفع من جابنك بنجاح
                                                                    <a href="{{url('transaction/result/'.$transaction['id'])}}" class="btn btn-warning btn-sm"> مشاهدة نتائج الفحص </a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="alert alert-danger"> لا يوجد مشتري حتي الان
                                                            </div>
                                                        @endif

                                                    </div>
                                                @elseif(auth()->user()->id == $transaction['buyer_id'])
                                                    <div class="other_person">
                                                        <h5> تفاصيل البائع </h5>
                                                        <div class="user_data">
                                                            <div class="image">
                                                                @if($transaction['seller']['image'] !='')
                                                                    <img
                                                                        src="{{asset('assets/uploads/user_images/'.$transaction['seller']['image'])}}"
                                                                        alt="">
                                                                @else
                                                                    <img
                                                                        src="{{asset('assets/uploads/user_images/user_avatar.png')}}"
                                                                        alt="">
                                                                @endif

                                                            </div>
                                                            <div class="info">
                                                                <p> {{ $transaction['seller']['name'] }} </p>
                                                                <span>  <i class="bi bi-phone"></i>  {{$transaction['seller']['phone']}} </span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if($transaction['status'] == ' بداية عملية الشراء ')
{{--                                                                <div class="alert alert-info"> يجب تحديد مركز الصيانة--}}
{{--                                                                    للفحص--}}
{{--                                                                </div>--}}
                                                            @elseif($transaction['status'] == 'تم تحديد مركز الصيانة ونوع الفحص')
                                                                <div class="alert alert-info">
                                                                   تم تحديد مركز الفحص وبدء عملية الشراء بنجاح
{{--                                                                    <a href="{{url('transaction_invoice/'.$transaction['seller_id'].'-'.$transaction['slug'])}}" class="btn btn-primary"> مشاهدة التفاصيل--}}
{{--                                                                        واتمام الدفع </a>--}}
                                                                    <a href="{{url('transaction/result/'.$transaction['id'])}}" class="btn btn-warning btn-sm"> مشاهدة نتائج الفحص </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
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
