<?= get_header(); ?>
<link href="<?= theme_asset(); ?>/css/clean-blog.css" rel="stylesheet">

<body id="page-top">
    <?= get_navigation(); ?>
  <!-- teacher details area start -->
  <div class="teacher-details pt--120 pb--60">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="tch-left-thumb">
                        <?php if(empty($teacher_detail->avatar)){?>
                        <img src="<?= theme_asset() ?>img/user.png" alt="image" style="max-width: 100%; height: auto;">
                        <?php }else{?>
                        <img src="<?= base_url('uploads/user/'.$teacher_detail->avatar) ?>" alt="image" style="max-width: 100%; height: auto;">
                        <?php }?>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="teacher-contenttchd-content pl-5 pb-5">
                        <h3><?php echo $teacher_detail->full_name;?></h3>
                        <span><?php echo $teacher_detail->specialization;?></span>
                        <p><?php echo $teacher_detail->description;?>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- teacher details area end -->
    <!-- related course area start -->
    <div class="related-course pb--40">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                        <h3><?php echo $teacher_detail->full_name;?> <span>other </span> courses</h3>  
                </div>
            </div>
            <div class="course-list">
                <div class="row">
                    <?php $course_list =get_teacher_course($teacher_detail->id);
                    foreach($course_list as $course){?>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="w-cs-single">
                            <img src="<?= theme_asset() ?>img/course-2.jpg" alt="image">
                            <div class="fix">
                            <?php $allowedlimit = 32; ?>
                                <p class="mb-0"><a href="#"><?php echo (mb_strlen($course->name) > $allowedlimit) ? mb_substr($course->name, 0, $allowedlimit) . "..." : $course->name; ?></a></p>
                            </div>
                        </div>
                    </div>
                  <?php }?>
                </div>
            </div>
        </div>
    </div>


    <?= get_footer(); ?>