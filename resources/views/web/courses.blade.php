@extends('layouts.web')

@section('content')
   <main>
        <!--? Hero Start -->
        <div class="slider-area2">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 pt-70">
                                <h2 data-key="hero-title-courses">Courses</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->

        <!--? Team -->
        <section class="team-area fix section-padding30">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="section-tittle text-center mb-55">
                            <h2 data-key="offer-title">What I Offer</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-cat text-center mb-30">
                            <div class="cat-icon">
                                <img data-key="team1-img" src="assets/img/gallery/team1.png" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="services.html" data-key="team1-title">Body Building</a></h5>
                                <p data-key="team1-desc">You’ll look at graphs and charts in Task One, how to approach
                                    the task</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-cat text-center mb-30">
                            <div class="cat-icon">
                                <img data-key="team2-img" src="assets/img/gallery/team2.png" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="services.html" data-key="team2-title">Muscle Gain</a></h5>
                                <p data-key="team2-desc">You’ll look at graphs and charts in Task One, how to approach
                                    the task</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-cat text-center mb-30">
                            <div class="cat-icon">
                                <img data-key="team3-img" src="assets/img/gallery/team3.png" alt="">
                            </div>
                            <div class="cat-cap">
                                <h5><a href="services.html" data-key="team3-title">Weight Loss</a></h5>
                                <p data-key="team3-desc">You’ll look at graphs and charts in Task One, how to approach
                                    the task</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services End -->

        <!-- Training categories Start -->
        <section class="traning-categories black-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                <img data-key="cat1-img" src="assets/img/gallery/cat1.png" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3 data-key="cat1-title">Personal training</h3>
                                        <p data-key="cat1-desc">You’ll look at graphs and charts in Task One, how to
                                            approach the task and <br> the language needed for a successful answer.</p>
                                        <a href="courses.html" class="border-btn" data-key="cat1-btn">View Courses</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="single-topic text-center mb-30">
                            <div class="topic-img">
                                <img data-key="cat2-img" src="assets/img/gallery/cat2.png" alt="">
                                <div class="topic-content-box">
                                    <div class="topic-content">
                                        <h3 data-key="cat2-title">Group training</h3>
                                        <p data-key="cat2-desc">You’ll look at graphs and charts in Task One, how to
                                            approach the task and <br> the language needed for a successful answer.</p>
                                        <a href="courses.html" class="btn" data-key="cat2-btn">View Courses</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Traning categories End-->
        <!--? video_start -->
        <div class="video-area section-bg2 d-flex align-items-center" data-background="assets/img/gallery/video-bg.png">
            <div class="container">
                <div class="video-wrap position-relative">
                    <div class="video-icon">
                        <a class="popup-video btn-icon" href="https://www.youtube.com/watch?v=up68UAfH0d0"><i
                                class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- video_end -->
        <!-- ? services-area -->
   <section class="services-area">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8">
                <div class="single-services mb-40 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                    <div class="features-icon">
                        <img src="assets/img/icon/icon1.svg" alt="" data-key="service-icon1">
                    </div>
                    <div class="features-caption">
                        <h3 data-key="service-title1">Location</h3>
                        <p data-key="service-desc1">You’ll look at graphs and charts in Task One, how to approach</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                <div class="single-services mb-40 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <div class="features-icon">
                        <img src="assets/img/icon/icon2.svg" alt="" data-key="service-icon2">
                    </div>
                    <div class="features-caption">
                        <h3 data-key="service-title2">Phone</h3>
                        <p data-key="service-phone1">(90) 277 278 2566</p>
                        <p data-key="service-phone2">(78) 267 256 2578</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                <div class="single-services mb-40 wow fadeInUp" data-wow-duration="2s" data-wow-delay=".4s">
                    <div class="features-icon">
                        <img src="assets/img/icon/icon3.svg" alt="" data-key="service-icon3">
                    </div>
                    <div class="features-caption">
                        <h3 data-key="service-title3">Email</h3>
                        <p data-key="service-email1">jacson767@gmail.com</p>
                        <p data-key="service-email2">contact56@zacsion.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    </main>
@endsection