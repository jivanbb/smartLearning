<?= get_header(); ?>

<body id="page-top">
   <?= get_navigation(); ?>

   <header>
      <!-- <div class="header-content">
         <div class="header-content-inner">
            <h1 id="homeHeading">Thanks for buying cicool builder</h1>
            <hr>
            <p> you can customize this page by editing this on location <br><code><?= './cc-content/themes/cicool/view/home.php' ?> </code></p>
            <a href="https://github.com/ridwanskaterock/cicool/issues" class="btn btn-primary btn-xl page-scroll" target="blank"><i class="fa fa-github"></i> Support</a>
            <br>
            <hr>
            <br>
            <p>Download modules e-commerce, chat system extension and other on</p>
            <a href="http://cicool-shoop.delightcosmetic.com/" class="btn btn-primary btn-xl page-scroll" target="blank"><i class="fa fa-puzzle-piece"></i> Cicool Shoop</a>
         </div>
      </div> -->
   </header>
   <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <?php $ad_list =get_ad_list();
            foreach($ad_list as $res){?>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="<?= base_url('uploads/sp_ad/'.$res->image) ?>" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown"><?php echo $res->title;?></h5>
                                <!-- <h1 class="display-3 text-white animated slideInDown">The Best Online Learning Platform</h1> -->
                                <p class="fs-5 text-white mb-4 pb-2"><?php echo $res->description;?></p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                <!-- <a href="" class="btn btn-light py-md-3 px-md-5 animated slideInRight">Join Now</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Service Start -->
    <div class="container-xxl py-1">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Skilled Instructors</h5>
                            <p>Access expert instructor of your field, helps learners to achieve their goals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-chalkboard-teacher text-primary mb-4"></i>
                            <h5 class="mb-3">Online Exam</h5>
                            <p>Access our MCQ-based test sets,which you can use to practice for upcoming exams.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-video text-primary mb-4"></i>
                            <h5 class="mb-3">Recorded Classes</h5>
                            <p>Access our recorded packages,which  were previously recorded.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Study Materials</h5>
                            <p>Access e-books and PDF materials containing notes and valuable content.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Categories Start -->
    <div class="container-xxl py-3 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
                <h1 class="mb-5">Courses Categories</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="<?= theme_asset() ?>img/cat-1.jpg" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                    <h5 class="m-0">Web Design</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="<?= theme_asset() ?>img/cat-2.jpg" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                    <h5 class="m-0">Graphic Design</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="<?= theme_asset() ?>img/cat-3.jpg" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                    <h5 class="m-0">Video Editing</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                    <a class="position-relative d-block h-100 overflow-hidden" href="">
                        <img class="img-fluid position-absolute w-100 h-100" src="<?= theme_asset() ?>img/cat-4.jpg" alt="" style="object-fit: cover;">
                        <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin:  1px;">
                            <h5 class="m-0">Online Marketing</h5>
                            <small class="text-primary">49 Courses</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Categories Start -->



    <!-- Courses End -->


    <!-- Team Start -->
    <div class="container-xxl py-3">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
                <h1 class="mb-5">Expert Instructors</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <?php $teacher_list =get_popular_teacher();
                foreach($teacher_list as $teacher){?>
                <div class="testimonial-item text-center">
                    <?php if(empty($teacher->avatar)){?>
                    <img class="border rounded-circle p-2 mx-auto " src="<?= theme_asset() ?>img/user.png" style="width: 80px; height: 80px;">
                    <?php }else{?>
                        <img class="border rounded-circle p-2 mx-auto " src="<?= base_url('uploads/user/'.$teacher->avatar) ?>" style="width: 80px; height: 80px;">
                        <?php }?>
                    <h5 class="mb-0"><?php echo $teacher->full_name;?></h5>
                    <p><?php echo $teacher->address;?></p>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <!-- Team End -->
   <?= get_footer(); ?>