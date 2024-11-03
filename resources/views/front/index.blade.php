@extends('front.layouts.master')
@section('title')
    وفي - الرئيسية
@endsection
@section('content')
    <div class="page_content">
        <div class="hero" style="background-image:url({{asset('assets/website/uploads/hero.jpg')}})">
            <div class="container">
                <div class="data">
                    <h3> بيع واشتري سيارتك بثقة وأمان </h3>
                    <p> استمتع بتجربة بيع وشراء السيارات بسهولة وفحص شامل من مراكز معتمدة </p>

                </div>

            </div>
        </div>
        <!--------------------- Start About Us --------------------->
        <div class="about_us" id="about_us">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info">
                                <h4> من نحن </h4>
                                <p style="color: #2172b3;"> بيع واشتري سياراتك بثقة وأمان، منصة تجمعك بالمشتري المثالي
                                    بكل سهولة! </p>
                                <p>
                                    نحن منصة إلكترونية متخصصة في تسهيل عملية بيع السيارات من خلال الربط بين البائع
                                    والمشتري بأمان وموثوقية. نعمل كوسيط موثوق يساعد في ضمان سير العملية بسلاسة من خلال
                                    تقديم خدمات الفحص، التحقق من حالة السيارات، وضمان عملية دفع آمنة وشفافة.
                                </p>
                                <a href="{{url('register')}}" class="btn btn-primary global_button"> بيع الان <i
                                        class="bi bi-arrow-left"></i> </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="image">
                                <img src="{{asset('assets/website/uploads/about_car.svg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------- End About US ----------------------->
        <!-------------------------------- Start Content About Seller And Buyer -------------->

        <div class="buttons_data">
            <h2> كيفية استخدام المنصة </h2>
            <div class="user_type">

                <div class="type seller active" data-target="seller">
                    للبائع
                </div>
                <div class="type buyer" data-target="buyer">
                    للمشتري
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
                        document.querySelectorAll('.about_seller_buyer').forEach(function (section) {
                            section.classList.remove('active');
                        });

                        // Show the targeted about_seller_buyer section
                        var target = element.getAttribute('data-target');
                        document.getElementById(target).classList.add('active');
                    });
                });
            </script>
        </div>
        <div class="about_seller_buyer active" id="seller">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="info">
                                <h4> أمان تعاملاتك، حتى تكتمل الصفقة بنجاح. </h4>
                                <p>نضمن لك استلام مستحقاتك فور إنهاء عملية البيع وتسليم السيارة. </p>
                                <ul class="list-unstyled">
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> ابدأ عملية
                                            البيع: </strong> يمكنك إنشاء عملية بيع جديدة من خلال إدخال
                                        تفاصيل السيارة المراد بيعها، بما في ذلك الصور والمواصفات والحالة الحالية.
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> إرسال رابط
                                            للمشتري: </strong> بعد إتمام ادخال عملية البيع في الموقع،
                                        يمكنك إرسال رابط العملية إلى المشتري ليقوم بمراجعة تفاصيل السيارة.
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> التنسيق مع
                                            مركز الفحص: </strong> بعد أن يتخذ المشتري قراره، يمكنة
                                        التنسيق مع مركز الفحص المعتمد لدينا لإجراء فحص شامل لحالة السيارة قبل إتمام
                                        الصفقة.
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> إتمام
                                            الصفقة: </strong> بعد اجتياز الفحص وتوافق الطرفين على السعر
                                        والحالة، يتم إتمام الصفقة من خلال طرق الدفع الآمنة المتاحة في المنصة.
                                    </li>
                                </ul>

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
                        <div class="col-lg-12 col-12">
                            <div class="info">
                                <h4> جودة مضمونة، وراحة بال في كل خطوة. </h4>
                                <p> مدفوعاتك محمية حتى تتأكد من مطابقة السيارة لمواصفاتك. </p>
                                <ul class="list-unstyled">
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> استلام رابط
                                            العملية: </strong> عندما تتلقى رابط العملية من البائع، يمكنك الدخول لمراجعة
                                        كافة تفاصيل السيارة (المواصفات، الصور، السعر المقترح).
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> اختيار مركز
                                            الفحص ونوع الفحص: </strong> يمكنك اختيار مركز الفحص المعتمد ونوع الفحص
                                        المطلوب (مثلاً: فحص شامل، فحص ميكانيكي، فحص إلكتروني).
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> <strong> إتمام
                                            الدفع: </strong> بمجرد التأكد من تفاصيل الصفقة، يمكنك الدفع من خلال خيارات
                                        الدفع الآمنة المتوفرة عبر المنصة.
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--------------------- Start Our Goals  --------------------->
        <div class="about_us our_goals">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="info">
                                <h4> أهدافنا </h4>
                                <ul class="list-unstyled">
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> تقديم تجربة سهلة وآمنة
                                        لكل من البائع والمشتري.
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> ضمان جودة السيارات من
                                        خلال فحص شامل يتم في مراكز معتمدة
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> تبسيط عملية البيع
                                        والشراء عبر الإنترنت مع توفير الثقة بين الأطراف المعنية.
                                    </li>
                                    <li><img src="{{asset('assets/website/uploads/check.png')}}"> خلق بيئة عادلة وشفافة
                                        في بيع وشراء السيارات المستعملة.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="image">
                                <img src="{{asset('assets/website/uploads/our_goals.svg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------- End Our Goals  ----------------------->

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
