<?= get_header(); ?>
<link href="<?= theme_asset(); ?>/css/clean-blog.css" rel="stylesheet">

<body id="page-top">
    <?= get_navigation(); ?>

    <div class="container-xxl py-5">
        <div class="container">
            <!-- course details start -->
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <h3 class="mb-4"><?php echo $course_detail->course_name; ?> </h3>
                    <div class="cs-post-share">
                        <div class="row">
                            <div class="tags">
                                <ul class="list-inline">
                                    <li class="active"><a href="<?php echo base_url('sp_mcq_practise/detail/' . $id) ?>">MCQ Practice</a></li>
                                    <li ><a href="<?php echo base_url('sp_mcq_practise/study/' . $id) ?>">Study Materials</a></li>
                                </ul>

                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php foreach ($chapter_detail as $res) { ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#chapter<?php echo $res->chapter_id; ?>" aria-expanded="false" aria-controls="chapter<?php echo $res->chapter_id; ?>">
                                                    <?php echo $res->name; ?>
                                                </button>
                                            </h2>
                                            <div id="chapter<?php echo $res->chapter_id; ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <?php $topic_list = get_mcq_topics($res->chapter_id); ?>
                                                <div class="accordion-body">
                                                    <?php if (!empty($topic_list)) {
                                                        foreach($topic_list as $topic){
                                                            $encrypted_id =encrypt_string($topic->mcq_id); ?>
                                                        <p><a href="<?php echo base_url('sp_mcq_practise/practice/' .$encrypted_id) ?>"><?php echo $topic->name;?></a></p>
                                                        <?php }?>
                                                    <?php } else {
                                                         $encrypted_id =encrypt_string($res->id); ?>
                                                        <p><a href="<?php echo base_url('sp_mcq_practise/practice/' . $encrypted_id) ?>"><?php echo $res->name; ?></a></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <!-- sidebar start -->
                <div class="col-lg-4 col-md-4">
                    <div class="sidebar">
                        <!-- widget nstructor start -->
                        <div class="widget widget-instructor">
                            <h4 class="widget-title">Course instructor</h4>
                            <div class="instructor">
                                <div class="post-author-info flex">
                                    <div class="thumb">
                                        <img src="<?= theme_asset() ?>img/user.png" alt="image" style="max-width: 100%; height: auto;">
                                    </div>
                                    <h5><?php echo $course_detail->full_name; ?></h5>
                                    <div class="auther_detail"><?php echo $course_detail->specialization; ?></div>
                                    <div class="auther_detail"><?php echo $course_detail->email; ?></div>
                                    <div class="auther_detail"><?php echo $course_detail->address; ?></div>
                                </div>
                            </div>
                        </div>
                        <!-- widget nstructor end -->
                    </div>
                </div>
            </div>
            <!--  end -->
        </div>
    </div>



    <?= get_footer(); ?>