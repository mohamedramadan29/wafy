<div class="large_screen">

    <header dir="rtl">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light navigation">
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img width="70px" src="{{asset('assets/website/uploads/logo.webp')}}" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto main-nav ">
                                <li class="nav-item">
                                    <a class="nav-link" id='index_link' aria-current="page" href="{{url('/')}}">
                                        الرئيسية </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#about_us">  من نحن   </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#faq"> الاسئلة الشائعة </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="western_link" href="https://wa.me/+966563398184" target="_blank"> تحدث معنا  </a>
                                </li>
                                @if(auth()->check())
                                    <li class="nav-item">
                                        <div class="dropdown">
                                            @php
                                                $unreadNotificationsUsers = \Illuminate\Support\Facades\Auth::user()->unreadNotifications;
                                            @endphp
                                            @if ($unreadNotificationsUsers->count() > 0)
                                                <span class="counter"> {{ $unreadNotificationsUsers->count() }} </span>
                                            @endif
                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                               aria-expanded="false">
                                                <i class="bi bi-bell-fill"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @forelse ($unreadNotificationsUsers as $notification)
                                                    @if ($notification['type'] == 'App\Notifications\NewBuyer')
                                                        <li><a class="dropdown-item"
                                                               href="{{ url('transaction/' . $notification['data']['seller_id'] . '-' . $notification['data']['transaction_slug']) }}">
                                                                {{ $notification['data']['title'] }}
                                                                : {{ $notification['data']['transaction_title'] }}
                                                                <br>
                                                                <span class="timer"> <i class="fa fa-clock"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </span>
                                                            </a>
                                                        </li>
                                                        <hr>
                                                    @elseif($notification['type'] == 'App\Notifications\SelectCenter')
                                                        <li><a class="dropdown-item"
                                                               href="{{ url('user/transactions') }}">
                                                                {{ $notification['data']['title'] }}
                                                                : {{ $notification['data']['transaction_title'] }}
                                                                <br>
                                                                <span class="timer"> <i class="fa fa-clock"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </span>
                                                            </a>
                                                        </li>
                                                        <hr>
                                                    @endif
                                                @empty
                                                    <li><a class="dropdown-item"> لا يوجد لديك اشعارات في الوقت
                                                            الحالي </a>
                                                    </li>
                                                    <hr>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="western_link" href="{{url('user/dashboard')}}">
                                            حسابي </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" id="western_link" href="{{url('register')}}"> تسجيل
                                            دخول </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</div>

<div class="small_screen">
    <div class="top_header medieum" dir="rtl">
        <div class="container-fluid">
            <div class="row">
                <div class="">
                    <div class="top2">
                        <div>
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img width="60px" src="{{asset('assets/website/uploads/logo.webp')}}" alt="">
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            @if(auth()->check())
                                <li class="nav-item">
                                    <div class="dropdown">
                                        @php
                                            $unreadNotificationsUsers = \Illuminate\Support\Facades\Auth::user()->unreadNotifications;
                                        @endphp

                                        @if ($unreadNotificationsUsers->count() > 0)
                                            <span class="counter"> {{ $unreadNotificationsUsers->count() }} </span>
                                        @endif
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            <i class="bi bi-bell-fill"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @forelse ($unreadNotificationsUsers as $notification)
                                                @if ($notification['type'] == 'App\Notifications\NewBuyer')
                                                    <li><a class="dropdown-item"
                                                           href="{{ url('transaction/' . $notification['data']['seller_id'] . '-' . $notification['data']['transaction_slug']) }}">
                                                            {{ $notification['data']['title'] }}
                                                            : {{ $notification['data']['transaction_title'] }}
                                                            <br>
                                                            <span class="timer"> <i class="fa fa-clock"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <hr>
                                                @elseif($notification['type'] == 'App\Notifications\SelectCenter')
                                                    <li><a class="dropdown-item"
                                                           href="{{ url('user/transactions') }}">
                                                            {{ $notification['data']['title'] }}
                                                            : {{ $notification['data']['transaction_title'] }}
                                                            <br>
                                                            <span class="timer"> <i class="fa fa-clock"></i>
                                                                {{ $notification->created_at->diffForHumans() }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <hr>
                                                @endif
                                            @empty
                                                <li><a class="dropdown-item"> لا يوجد لديك اشعارات في الوقت
                                                        الحالي </a>
                                                </li>
                                                <hr>
                                            @endforelse
                                        </ul>
                                    </div>
                                </li>
                                <div class="dropdown navbar_user_image">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if(auth()->user()->image !='')
                                            <img src="{{asset('assets/uploads/user_images/'.auth()->user()->image)}}"
                                                 alt="">
                                        @else
                                            <img src="{{asset('assets/uploads/user_images/user_avatar.png')}}" alt="">
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{url('user/transactions')}}">  جميع المعاملات  </a></li>
                                        <li><a class="dropdown-item" href="{{url('user/add-transaction')}}"> بدء معاملة جديدة  </a></li>
                                        <li><a class="dropdown-item" href="{{url('user/profile')}}"> بيانات حسابي  </a></li>
                                        <li><a class="dropdown-item" href="{{url('user/change-password')}}"> تعديل رمز الحماية   </a></li>
                                        <li><a class="dropdown-item" href="{{url('user/logout')}}">  تسجيل خروج  </a></li>
                                    </ul>
                                </div>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link mobile_login_button" id="western_link" href="{{url('register')}}"> تسجيل
                                        دخول </a>
                                </li>
                            @endif
                            <span class="mobile_menu">
                                <i style="color: #333;font-size: 31px; cursor: pointer;" class="bi bi-list"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="last_header">
        <nav class="navbar navbar-expand-lg navbar-light navigation">
            <div class="overlay"></div>
            <div class="new_links">
                <ul>
                    <li class="nav-item">
                        <a class="nav-link" id='index_link' aria-current="page" href="{{url('/')}}">
                            الرئيسية </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about_us">  من نحن   </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq"> الاسئلة الشائعة </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="western_link" href="https://wa.me/+966563398184" target="_blank"> تحدث معنا  </a>
                    </li>
                    @if(\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" id="western_link" href="{{url('user/dashboard')}}">
                            حسابي </a>
                    </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" id="western_link" href="{{url('register')}}"> تسجيل
                                دخول </a>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get current page from URL
        const path = window.location.pathname.split("/").pop();

        // Select all nav links
        const navLinks = document.querySelectorAll('.nav-link');

        // Loop through each nav link
        navLinks.forEach(link => {
            // Get the href attribute of the link
            const href = link.getAttribute('href');

            // Check if the href matches the current path
            if (path === href) {
                // Add 'active' class to the matching link
                link.classList.add('active');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuIcon = document.querySelector('.mobile_menu');
        const newLinks = document.querySelector('.new_links');
        const overlay = document.querySelector('.overlay');
        const body = document.body;

        mobileMenuIcon.addEventListener('click', function () {
            newLinks.classList.toggle('active');
            overlay.classList.toggle('active');
            body.classList.toggle('overlay-active');
        });

        overlay.addEventListener('click', function () {
            newLinks.classList.remove('active');
            overlay.classList.remove('active');
            body.classList.remove('overlay-active');
        });
    });
</script>
