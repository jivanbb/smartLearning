<?= get_header(); ?>
<link href="<?= theme_asset(); ?>/css/clean-blog.css" rel="stylesheet">

<body id="page-top">
    <?= get_navigation(); ?>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row ">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="course-item ">
                            <div class="d-flex">
                                <div class="col-md-9">
                                    <p><?php echo $exam_detail->course_name; ?></p>
                                    <p>Published 5 days ago</p>
                                </div>
                                <div class="col-md-3 justify-right">
                                    <div class="exam-details-container">
                                        <div class="exam-details-text">Time:</div>
                                        <div class="exam-details-numbers"><?php echo $exam_detail->time; ?> mins</div>
                                        <div class="exam-details-text">Full Marks:</div>
                                        <div class="exam-details-numbers"><?php echo $exam_detail->full_marks; ?> marks</div>
                                        <div class="exam-details-text">PassMarks: </div>
                                        <div class="exam-details-numbers"><?php echo $exam_detail->pass_marks; ?> marks</div>
                                        <div class="exam-details-text">Negative Marking: </div>
                                        <div class="exam-details-numbers">0 percent</div>
                                        <div class="exam-details-text">No of Question: </div>
                                        <div class="exam-details-numbers"><?php echo $exam_detail->total_questions;?> question</div>
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex ">
                                <small class="flex-fill text-center  py-2"><i class="fa fa-user-tie text-primary me-2"></i>Pradip kumar luitel</small>
                                <small class="flex-fill text-center  py-2"><i class="fa fa-star text-primary me-2"></i>5(Rating)</small>

                                <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>30 Appeared</small>
                            </div>
                        </div>
                    </div>
                    </br>
                    <div class="box-container">
                        <div class="row">
                            <div class="col-md-2"> <img class="img-fluid rounded-circle center" src="<?= theme_asset() ?>img/team-3.jpg" alt=""></div>
                            <div class="col-md-7">
                                <div class="reviewer-rating">
                                    <span>Ashok Bhatta</span>
                                </div>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>

                                <div>Very Good</div>
                            </div>
                            <div class="col-md-3">04 Nov, 2024</div>
                        </div>
                    </div>
                    <div class="box-container">
                        <div class="row">
                            <div class="col-md-2"> <img class="img-fluid rounded-circle center" src="<?= theme_asset() ?>img/team-1.jpg" alt=""></div>
                            <div class="col-md-7">
                                <div class="reviewer-rating">
                                    <span>Sunil Giri</span>
                                </div>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>

                                <div>Nice</div>
                            </div>
                            <div class="col-md-3">10 Nov, 2024</div>
                        </div>
                    </div>
                    <div class="box-container">
                        <div class="row">
                            <div class="col-md-2"> <img class="img-fluid rounded-circle center" src="<?= theme_asset() ?>img/team-2.jpg" alt=""></div>
                            <div class="col-md-7">
                                <div class="reviewer-rating">
                                    <span>Gauri bist</span>
                                </div>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>

                                <div>Extra Odinary</div>
                            </div>
                            <div class="col-md-3">09 Nov, 2024</div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3 col-md-3">
                    <div class="question-detail-extra-main-col">
                        <div class="question-default-bookmark">
                            <div class="mcq-extra-detail-container">
                                <span class="exam-overview-time">Free</span>
                                <a href="<?php echo base_url('administrator/login/?exam=' .$id) ?>" class="start_button btn btn-primary">Start</a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <?= get_footer(); ?>