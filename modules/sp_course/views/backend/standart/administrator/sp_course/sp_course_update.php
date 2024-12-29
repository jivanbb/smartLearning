<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
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
        Course <small>Edit Course</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_course'); ?>">Course</a></li>
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
                        <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username">Course</h3>
                            <h5 class="widget-user-desc">Edit Course</h5>
                            <hr>
                        </div>
                        <?= form_open(admin_base_url('/sp_course/edit_save/' . $this->uri->segment(4)), [
                            'name' => 'form_sp_course_edit',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_course_edit',
                            'method' => 'POST'
                        ]); ?>

                        <?php
                        $user_groups = $this->model_group->get_user_group_ids();
                        ?>
                        <div class="form-group group-board_university  ">
                            <label for="board_university" class="col-sm-2 control-label">Board/University <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="board_university" id="board_university" data-placeholder="Select Board/University">
                                    <option value=""></option>
                                    <?php
                                    $conditions = ['created_by'=>$user_id];
                                    ?>
                                    <?php foreach (db_get_all_data('sp_board', $conditions) as $row): ?>
                                        <option <?= $row->id == $sp_course->board_university ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Name <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= set_value('name', $sp_course->name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Amount <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="" value="<?= set_value('amount', $sp_course->amount); ?>">
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Valid Days <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="valid_days"  placeholder="" value="<?= set_value('valid_days', $sp_course->valid_days); ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group group-image  ">
                                    <label for="image" class="col-sm-2 control-label">Image <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <div id="sp_course_image_galery"></div>
                                        <input class="data_file data_file_uuid" name="sp_course_image_uuid" id="sp_course_image_uuid" type="hidden" value="<?= set_value('sp_course_image_uuid'); ?>">
                                        <input class="data_file" name="sp_course_image_name" id="sp_course_image_name" type="hidden" value="<?= set_value('sp_course_image_name', $sp_course->image); ?>">
                                        <small class="info help-block">
                                        </small>
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
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>

<script>
    var module_name = "sp_course"
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
                        window.location.href = ADMIN_BASE_URL + '/sp_course';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_course = $('#form_sp_course_edit');
            var data_post = form_sp_course.serializeArray();
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
                    url: form_sp_course.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('form').find('.error-input').remove();
                    $('.steps li').removeClass('error');
                    if (res.success) {
                        var id = $('#sp_course_image_galery').find('li').attr('qq-file-id');
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

                            var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_course/index/?ajax=1'
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



        var params = {};
        params[csrf] = token;

        $('#sp_course_image_galery').fineUploader({
            template: 'qq-template-gallery',
            request: {
                endpoint: ADMIN_BASE_URL + '/sp_course/upload_image_file',
                params: params
            },
            deleteFile: {
                enabled: true, // defaults to false
                endpoint: ADMIN_BASE_URL + '/sp_course/delete_image_file'
            },
            thumbnails: {
                placeholders: {
                    waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                    notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
                }
            },
            session: {
                endpoint: ADMIN_BASE_URL + '/sp_course/get_image_file/<?= $sp_course->id; ?>',
                refreshOnRequest: true
            },
            multiple: false,
            validation: {
                allowedExtensions: ["*"],
                sizeLimit: 0,
            },
            showMessage: function(msg) {
                toastr['error'](msg);
            },
            callbacks: {
                onComplete: function(id, name, xhr) {
                    if (xhr.success) {
                        var uuid = $('#sp_course_image_galery').fineUploader('getUuid', id);
                        $('#sp_course_image_uuid').val(uuid);
                        $('#sp_course_image_name').val(xhr.uploadName);
                    } else {
                        toastr['error'](xhr.error);
                    }
                },
                onSubmit: function(id, name) {
                    var uuid = $('#sp_course_image_uuid').val();
                    $.get(ADMIN_BASE_URL + '/sp_course/delete_image_file/' + uuid);
                },
                onDeleteComplete: function(id, xhr, isError) {
                    if (isError == false) {
                        $('#sp_course_image_uuid').val('');
                        $('#sp_course_image_name').val('');
                    }
                }
            }
        }); /*end image galey*/


        async function chain() {}

        chain();




    }); /*end doc ready*/
</script>