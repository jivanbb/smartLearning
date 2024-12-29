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
                                    <li><a href="<?php echo base_url('sp_mcq_practise/detail/' . $id) ?>">MCQ Practice</a></li>
                                    <li class="active"><a href="<?php echo base_url('sp_mcq_practise/study/' . $id) ?>">Study Materials</a></li>
                                </ul>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped dataTable">
                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $sn = 0;
                                                foreach ($study_detail as $res) {
                                                    $sn++; ?>
                                                    <tr>
                                                        <td><?php echo $sn; ?></td>
                                                        <td><?php echo $res->name; ?></td>
                                                        <td> <?php foreach (explode(',', $res->materials) as $file): ?>
                                                                <?php if (!empty($file)): ?>
                                                                    <?php if (is_image($file)): ?>
                                                                        <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/sp_materials/' . $file; ?>">
                                                                            <img src="<?= BASE_URL . 'uploads/sp_materials/' . $file; ?>" class="image-responsive" alt="image sp_materials" title="materials sp_materials" width="40px">
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <a href="<?= BASE_URL . 'uploads/sp_materials/' . $file; ?>" target="blank">
                                                                            <img src="<?= get_icon_file($file); ?>" class="image-responsive image-icon" alt="image sp_materials" title="materials <?= $file; ?>" width="40px">
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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