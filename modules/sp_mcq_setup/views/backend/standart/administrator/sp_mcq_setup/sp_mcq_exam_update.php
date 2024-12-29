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
<section class="content-header">
    <h1>
       Edit MCQ Setup
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_mcq_setup'); ?>">MCQ Setup</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<style>
</style>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <div class="box box-widget widget-user-2">
                        <?= form_open(admin_base_url('/sp_mcq_setup/edit_save/' . $this->uri->segment(4)), [
                            'name' => 'form_sp_mcq_question_edit',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_mcq_question_edit',
                            'method' => 'POST'
                        ]); ?>

                        <?php
                        $user_groups = $this->model_group->get_user_group_ids();  ?>

                        <div class="form-group group-course_id">
                            <label for="course_id" class="col-sm-2 control-label">Course <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <select class="form-control chosen chosen-select-deselect" name="course_id" id="course_id" data-placeholder="Select Course" disabled>
                                    <option value=""></option>
                                    <?php $conditions = ['created_by' => $user_id]; ?>
                                    <?php foreach (db_get_all_data('sp_course', $conditions) as $row): ?>
                                        <option <?= $row->id == $mcq_exam->course_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                            <label for="no_of_options" class="col-sm-2 control-label">Time <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="time" id="time" placeholder="Time" value="<?php echo $mcq_exam->time; ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                        <div class="form-group group-chapter_id  ">
                            <label for="chapter_id" class="col-sm-2 control-label">Full Marks <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="full_marks" placeholder="Full Marks" value="<?php echo $mcq_exam->full_marks; ?>">
                            </div>
                            <label for="no_of_options" class="col-sm-2 control-label">Pass Marks <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="pass_marks" placeholder="Pass Marks" value="<?php echo $mcq_exam->pass_marks; ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>


                        <div class="form-group group-topic_id">
                            <label for="no_of_options" class="col-sm-2 control-label">Marks <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="marks" placeholder="Marks" value="<?php echo $mcq_exam->question_marks; ?>">
                                <small class="info help-block">(Each question marks)
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="dt-responsive table-responsive col-md-10">
                                <table class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>SN.</th>
                                            <th>Chapter Name</th>
                                            <th width="20%">No of Question</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam_table">
                                        <?php $sn =0;
                                         foreach ($mcq_exam_detail as $data) { 
                                            $sn++;?>
                                            <tr>
                                                <td><?php echo $sn;?></td>
                                                <td><?php echo $data->chapter_name;?></td>
                                                <td><input type="text" class="form-control" value="<?php echo $data->no_of_question;?>" name="chapter_data[<?php echo $data->chapter_id; ?>][no_of_questions]"></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>

<script>
    var module_name = "sp_mcq_question"
    var use_ajax_crud = false
</script>


<script>
    $(document).ready(function() {

        "use strict";

        window.event_submit_and_action = '';

        $('#btn_cancel').click(function() {
            swal({
                    title: "Are you sure?",
                    text: "the data that you have created will be in the exhaust!",
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
                        window.location.href = ADMIN_BASE_URL + '/sp_mcq_setup';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_mcq_question = $('#form_sp_mcq_question_edit');
            var data_post = form_sp_mcq_question.serializeArray();
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
                    url: form_sp_mcq_question.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('form').find('.error-input').remove();
                    $('.steps li').removeClass('error');
                    if (res.success) {
                        var id = $('#sp_mcq_question_image_galery').find('li').attr('qq-file-id');
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
                        $('.data_file_uuid').val('');
                        showPopup(false)

                        if (use_ajax_crud == true) {

                            var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_mcq_exam/index/?ajax=1'
                            reloadDataTable(url);
                        }



                    } else {
                        if (res.errors) {
                            parseErrorField(res.errors);
                        }
                        $('.message').printMessage({
                            message: res.message,
                            type: 'warning'
                        });
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
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 2000);
                });

            return false;
        }); /*end btn save*/





        async function chain() {}

        chain();




    }); /*end doc ready*/
</script>