<body class="black-bg">
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets/img/logo/loder.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader End -->

    <header>
        <div class="header-area header-transparent">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper d-flex align-items-center justify-content-between">

                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo">
                            </a>
                        </div>

                        <!-- Main-menu -->
                        <div class="main-menu f-right d-none d-lg-block">
                            <nav>
                                <ul id="navigation">
                                    <li><a href="{{ url('/') }}" data-key="home">Home</a></li>
                                    <li><a href="{{ url('about') }}" data-key="about">About</a></li>
                                    <li><a href="{{ url('courses') }}" data-key="courses">Courses</a></li>
                                    <li><a href="{{ url('pricing') }}" data-key="pricing">Pricing</a></li>
                                    <li><a href="{{ url('gallery') }}" data-key="gallery">Gallery</a></li>
                                    {{-- Example submenu (optional)
                                    <li><a href="{{ url('blog') }}" data-key="blog">Blog</a>
                                        <ul class="submenu">
                                            <li><a href="{{ url('blog') }}" data-key="blog">Blog</a></li>
                                            <li><a href="{{ url('blog-details') }}" data-key="blog-details">Blog
                                                    Details</a></li>
                                            <li><a href="{{ url('elements') }}" data-key="elements">Elements</a></li>
                                        </ul>
                                    </li>
                                    --}}
                                    <li><a href="{{ url('contact') }}" data-key="contact">Contact</a></li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Header-btn -->
                        <div class="header-btns d-none d-lg-block f-right">
                            <a href="{{ url('contact') }}" class="btn" data-key="contact-me">Contact me</a>
                        </div>

                        <!-- Language Switcher -->
                        <!-- Desktop -->
                        <div class="language-switch d-none d-lg-block" style="margin-left: 15px;">
                            <a href="#" onclick="setLanguage('en')">EN</a> |
                            <a href="#" onclick="setLanguage('ar')">AR</a>
                        </div>

                        <!-- Mobile -->
                        <div class="language-switch d-block d-lg-none text-center mt-2">
                            <a href="#" onclick="setLanguage('en')">EN</a> |
                            <a href="#" onclick="setLanguage('ar')">AR</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Include JS -->
    <script src="translate.js"></script>