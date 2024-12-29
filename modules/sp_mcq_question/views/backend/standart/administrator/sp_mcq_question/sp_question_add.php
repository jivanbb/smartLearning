<script type="text/javascript">
    function domo() {

        $('*').bind('keydown', 'Ctrl+s', function() {
            $('#btn_save').trigger('click');
            return false;
        });

        $('*').bind('keydown', 'Ctrl+x', function() {
            $('#btn_cancel').trigger('click');
            return false;
        });

        $('*').bind('keydown', 'Ctrl+d', function() {
            $('.btn_save_back').trigger('click');
            return false;
        });

    }

    jQuery(document).ready(domo);
</script>
<style>
</style>
<section class="content-header">
    <h1>
        Question <small>Course:<?php echo $mcq_question->course_name; ?> &nbsp;&nbsp;&nbsp;&nbsp; Chapter:<?php echo $mcq_question->chapter_name; ?> &nbsp;&nbsp;&nbsp; Topic:<?php echo $mcq_question->topic_name; ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_mcq_question'); ?>"> Question</a></li>
        <li class="active"><?= cclang('new'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <div class="box box-widget widget-user-2">
                        <!-- <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username">Question</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Question']); ?></h5>
                            <hr>
                        </div> -->
                        <?= form_open('', [
                            'name' => 'form_sp_question_add',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_question_add',
                            'enctype' => 'multipart/form-data',
                            'method' => 'POST'
                        ]); ?>
                        <?php
                        $user_groups = $this->model_group->get_user_group_ids();
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-course_id ">
                                    <label for="course_id" class="col-sm-2 control-label">question <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea id="question" rows="6" cols="40" name="question"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-no_of_options ">
                                    <label for="no_of_options" class="col-sm-2 control-label">Explanation </label>
                                    <div class="col-sm-10">
                                        <textarea id="content" name="explanation" rows="6" cols="40"><?= set_value('Explanation'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-2 control-label">Option 1 <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-10">
                                        <textarea name="option_1" rows="2" cols="65"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php if ($mcq_question->no_of_options == 2 || $mcq_question->no_of_options == 3 || $mcq_question->no_of_options == 4) { ?>
                                    <div class="form-group group-topic_id ">
                                        <label for="topic_id" class="col-sm-2 control-label">Option 2 <i class="required">*</i>
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea name="option_2" rows="2" cols="65"></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($mcq_question->no_of_options == 3 || $mcq_question->no_of_options == 4) { ?>
                                    <div class="form-group group-topic_id ">
                                        <label for="topic_id" class="col-sm-2 control-label">Option 3 <i class="required">*</i>
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea name="option_3" rows="2" cols="65"></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <?php if ($mcq_question->no_of_options == 4) { ?>
                                    <div class="form-group group-topic_id ">
                                        <label for="topic_id" class="col-sm-2 control-label">Option 4 <i class="required">*</i>
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea name="option_4" rows="2" cols="65"></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-no_of_question ">
                                    <label for="no_of_question" class="col-sm-2 control-label">Correct option<i class="required">*</i>
                                    </label>
                                    <div class="col-sm-10">
                                        <select class="form-control chosen chosen-select-deselect" name="correct_option" id="correct_option" data-placeholder="Select Correct option">
                                            <option value=""></option>
                                            <option value="1">Option 1</option>
                                            <?php if ($mcq_question->no_of_options == 2 || $mcq_question->no_of_options == 3 || $mcq_question->no_of_options == 4) { ?>
                                                <option value="2">Option 2</option>
                                            <?php } ?>
                                            <?php if ($mcq_question->no_of_options == 3 || $mcq_question->no_of_options == 4) { ?>
                                                <option value="3">Option 3</option>
                                            <?php } ?>
                                            <?php if ($mcq_question->no_of_options == 4) { ?>
                                                <option value="4">Option 4</option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="mcq_id" value="<?php echo $mcq_question->id ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group group-no_of_options ">
                                    <label for="no_of_options" class="col-sm-2 control-label">Question Type </label>
                                    <div class="col-sm-10">
                                        <select class="form-control " name="question_type" id="question_type" data-placeholder="Select Question Type">
                                            <option value="">Question Type</option>
                                            <option value="free">Free</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="message"></div>
                        <div class="row-fluid col-md-7 container-button-bottom">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                                <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                                <i class="ion ion-ios-list-outline"></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>

                            <div class="custom-button-wrapper">

                            </div>


                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                                <i class="fa fa-undo"></i> <?= cclang('cancel_button'); ?>
                            </a>

                            <span class="loading loading-hide">
                                <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg">
                                <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                <br>
                                <table class="table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr class="">
                                            <th>SN</th>
                                            <th data-field="question" data-sort="1" data-primary-key="0"> <?= cclang('question') ?></th>
                                            <th data-field="option_1" data-sort="1" data-primary-key="0">Option 1</th>
                                            <?php if ($mcq_question->no_of_options == 2 || $mcq_question->no_of_options == 3 || $mcq_question->no_of_options == 4) { ?>
                                                <th data-field="option_2" data-sort="1" data-primary-key="0"> Option 2</th>
                                            <?php } ?>
                                            <?php if ($mcq_question->no_of_options == 3 || $mcq_question->no_of_options == 4) { ?>
                                                <th data-field="option_3" data-sort="1" data-primary-key="0"> Option 3</th>
                                            <?php } ?>
                                            <?php if ($mcq_question->no_of_options == 4) { ?>
                                                <th data-field="option_4" data-sort="1" data-primary-key="0"> Option 4</th>
                                            <?php } ?>
                                            <th data-field="no_of_options" data-sort="1" data-primary-key="0"> <?= cclang('correct') . ' ' . cclang('option') ?></th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sn = 0;
                                        foreach ($question_details as $question) {
                                            $sn++; ?>
                                            <tr>
                                                <td><?php echo $sn; ?></td>
                                                <td><?php echo $question->question; ?></td>
                                                <td><?php echo $question->option_1; ?></td>
                                                <td><?php echo $question->option_2; ?></td>
                                                <td><?php echo $question->option_3; ?></td>
                                                <td><?php echo $question->option_4; ?></td>
                                                <td><?php echo $question->correct_option; ?></td>
                                                <td> <a href="<?= admin_site_url('/sp_mcq_question/question_edit/' . $question->id); ?>" data-id="<?= $question->id ?>" class="label-default btn-act-edit"><i class="fa fa-edit "></i> </a>
                                                    <a href="javascript:void(0);" data-href="<?= admin_site_url('/sp_mcq_question/question_delete/' . $question->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> </a>
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
    </div>
</section>
<script src="<?= BASE_ASSET ?>ckeditor/ckeditor.js"></script>
<script>
    var module_name = "sp_mcq_question"
    var use_ajax_crud = false
</script>

<script>
    $(document).ready(function() {

        CKEDITOR.replace('content', {
            filebrowserUploadUrl: BASE_URL + 'administrator/upload/answer_upload'
        });
        var content = CKEDITOR.instances.content;
        CKEDITOR.replace('question', {
            filebrowserUploadUrl: BASE_URL + 'administrator/upload/question_upload'
        });
        var question = CKEDITOR.instances.question;

        "use strict";

        window.event_submit_and_action = '';
        $('#btn_cancel').click(function() {
            swal({
                    title: "<?= cclang('are_you_sure'); ?>",
                    text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        window.location.href = ADMIN_BASE_URL + '/sp_mcq_question';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $(document).on('click', 'a.remove-data', function() {

            var url = $(this).attr('data-href');

            swal({
                    title: "<?= cclang('are_you_sure'); ?>",
                    text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
                    cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = url;
                    }
                });

            return false;
        });

        $('.btn_save').click(function() {
            $('.message').fadeOut();
            $('#content').val(content.getData());
            $('#question').val(question.getData());
            var form_sp_question = $('#form_sp_question_add');
            var data_post = form_sp_question.serializeArray();
            var save_type = $(this).attr('data-stype');

            data_post.push({
                name: 'save_type',
                value: save_type
            });

            data_post.push({
                name: 'event_submit_and_action',
                value: window.event_submit_and_action
            });
            $('.loading').show();

            $.ajax({
                    url: ADMIN_BASE_URL + '/sp_mcq_question/question_save',
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('.steps li').removeClass('error');
                    $('form').find('.error-input').remove();
                    if (res.success) {

                        if (save_type == 'back') {
                            window.location.href = res.redirect;
                            return;
                        }

                        if (use_ajax_crud) {
                            toastr['success'](res.message)
                        } else {

                            $('.message').printMessage({
                                message: res.message
                            });
                            $('.message').fadeIn();
                        }
                        showPopup(false)


                        resetForm();
                        $('.chosen option').prop('selected', false).trigger('chosen:updated');

                    } else {
                        if (res.errors) {

                            $.each(res.errors, function(index, val) {
                                $('form #' + index).parents('.form-group').addClass('has-error');
                                $('form #' + index).parents('.form-group').find('small').prepend(`
                      <div class="error-input">` + val + `</div>
                      `);
                            });
                            $('.steps li').removeClass('error');
                            $('.content section').each(function(index, el) {
                                if ($(this).find('.has-error').length) {
                                    $('.steps li:eq(' + index + ')').addClass('error').find('a').trigger('click');
                                }
                            });
                        }
                        $('.message').printMessage({
                            message: res.message,
                            type: 'warning'
                        });
                    }

                    if (use_ajax_crud == true) {

                        var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_mcq_question/index/?ajax=1'
                        reloadDataTable(url);
                    }

                })
                .fail(function() {
                    $('.message').printMessage({
                        message: 'Error save data',
                        type: 'warning'
                    });
                })
                .always(function() {
                    $('.loading').hide();
                    // $('html, body').animate({
                    //     scrollTop: $(document).height()
                    // }, 2000);
                });

            return false;
        }); /*end btn save*/








    }); /*end doc ready*/
</script>