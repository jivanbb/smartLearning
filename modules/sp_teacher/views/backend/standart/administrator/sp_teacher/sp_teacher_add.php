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
        Create Teacher
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_teacher'); ?>">Teacher </a></li>
        <li class="active"><?= cclang('new'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <div class="box box-widget widget-user-2">
                        <?= form_open('', [
                            'name' => 'form_teacher_add',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_teacher_add',
                            'enctype' => 'multipart/form-data',
                            'method' => 'POST'
                        ]); ?>
                        <div class="form-group group-course_id ">
                            <label for="course_id" class="col-sm-2 control-label">Education <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <select class="form-control chosen chosen-select-deselect" name="education" id="education" data-placeholder="Select Education">
                                    <option value=""></option>
                                    <?php $conditions = []; ?>
                                    <?php foreach (db_get_all_data('sp_education', $conditions) as $row): ?>
                                        <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                            <label for="no_of_options" class="col-sm-2 control-label">Specialization </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="specialization" id="specialization" placeholder="Specialization">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>



                        <div class="form-group group-chapter_id ">
                            <label for="chapter_id" class="col-sm-2 control-label">Experience <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="experience" id="experience" placeholder="Experience">
                                <small class="info help-block">In Years</small>
                            </div>
                            <label for="topic_id" class="col-sm-2 control-label">Address <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                                <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                            </div>
                        </div>

                        <div class="form-group group-chapter_id ">
                        <label for="topic_id" class="col-sm-2 control-label">Description <i class="required">*</i>
                            </label>
                            <div class="col-sm-10">
                            <textarea name="description" rows="4" cols="50"></textarea>
                            </div>
                        </div>


                        <div class="row-fluid container-button-bottom">
                            <button style="margin-left: 65px;" class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                                <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                            </button>

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
            </div>
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
                        window.location.href = ADMIN_BASE_URL + '/sp_teacher';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_mcq_question = $('#form_teacher_add');
            var data_post = form_sp_mcq_question.serializeArray();
       
            $('.loading').show();

            $.ajax({
                    url: ADMIN_BASE_URL + '/sp_teacher/add_save',
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    if (res.success) {
                        showStatusMessage('success', 'Success', res.message);
                        setTimeout(() => {
                            // window.location.reload(true);
                            window.location.href = res.redirect;
                            return;
                        });
                        resetForm();
                        $('.chosen option').prop('selected', false).trigger('chosen:updated');

                    } else {
                            showValidationMessage(`${res.message}`);
                    }

                })
                .fail(function() {
                    showStatusMessage('error', 'Error', 'Error save data');
                })
                .always(function() {
                    $('.loading').hide();
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 2000);
                });

            return false;
        }); /*end btn save*/





    }); /*end doc ready*/
</script>