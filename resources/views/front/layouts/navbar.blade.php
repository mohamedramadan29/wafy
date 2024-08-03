<div class="large_screen">

    <header dir="rtl">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light navigation">
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img width="70px" src="{{asset('assets/website/uploads/logo.webp')}}" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto main-nav ">
                                <li class="nav-item">
                                    <a class="nav-link" id='index_link' aria-current="page" href="{{url('/')}}"> الرئيسية </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">   الاسئلة الشائعة </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="western_link" href="#">  تواصل معنا  </a>
                                </li>
                                @if(auth()->check())
                                    <li class="nav-item">
                                        <a class="nav-link" id="western_link" href="{{url('user/dashboard')}}"> حسابي  </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" id="western_link" href="{{url('register')}}"> تسجيل دخول  </a>
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
                        <div class="">
                            <span class="mobile_menu">
                                <i style="color: #333;font-size: 18px;" class="bi bi-layout-text-sidebar"></i>
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
                        <a class="nav-link" aria-current="page" href="{{url('/')}}"> الرئيسية </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">   الاسئلة الشائعة </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">  تواصل معنا </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuIcon = document.querySelector('.mobile_menu');
        const newLinks = document.querySelector('.new_links');
        const overlay = document.querySelector('.overlay');
        const body = document.body;

        mobileMenuIcon.addEventListener('click', function() {
            newLinks.classList.toggle('active');
            overlay.classList.toggle('active');
            body.classList.toggle('overlay-active');
        });

        overlay.addEventListener('click', function() {
            newLinks.classList.remove('active');
            overlay.classList.remove('active');
            body.classList.remove('overlay-active');
        });
    });
</script>
