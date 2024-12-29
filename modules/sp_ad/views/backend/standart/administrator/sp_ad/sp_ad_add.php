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
<style>
</style>
<section class="content-header">
    <h1>
        Advertisement <small><?= cclang('new', ['Advertisement']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_ad'); ?>">Advertisement</a></li>
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
                            <h3 class="widget-user-username">Sp Ad</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Sp Ad']); ?></h5>
                            <hr>
                        </div> -->
                        <?= form_open('', [
                            'name' => 'form_sp_ad_add',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_ad_add',
                            'enctype' => 'multipart/form-data',
                            'method' => 'POST'
                        ]); ?>
                        <?php
                        $user_groups = $this->model_group->get_user_group_ids();
                        ?>

                        <div class="form-group group-title ">
                            <label for="title" class="col-sm-2 control-label">Title </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?= set_value('title'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>


                        <div class="form-group group-image ">
                            <label for="image" class="col-sm-2 control-label">Image <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <div id="sp_ad_image_galery"></div>
                                <input class="data_file" name="sp_ad_image_uuid" id="sp_ad_image_uuid" type="hidden" value="<?= set_value('sp_ad_image_uuid'); ?>">
                                <input class="data_file" name="sp_ad_image_name" id="sp_ad_image_name" type="hidden" value="<?= set_value('sp_ad_image_name'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>


                        <div class="form-group group-link ">
                            <label for="link" class="col-sm-2 control-label">Link </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?= set_value('link'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>


                        <div class="form-group group-order ">
                            <label for="order" class="col-sm-2 control-label">Order </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="order" id="order" placeholder="Order" value="<?= set_value('order'); ?>">
                                <small class="info help-block">
                                </small>
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
            </div>
        </div>
    </div>
</section>

<script>
    var module_name = "sp_ad"
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
                        window.location.href = ADMIN_BASE_URL + '/sp_ad';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_ad = $('#form_sp_ad_add');
            var data_post = form_sp_ad.serializeArray();
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
                    url: ADMIN_BASE_URL + '/sp_ad/add_save',
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('.steps li').removeClass('error');
                    $('form').find('.error-input').remove();
                    if (res.success) {
                        var id_image = $('#sp_ad_image_galery').find('li').attr('qq-file-id');

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
                        if (typeof id_image !== 'undefined') {
                            $('#sp_ad_image_galery').fineUploader('deleteFile', id_image);
                        }
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

                        var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_ad/index/?ajax=1'
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
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 2000);
                });

            return false;
        }); /*end btn save*/

        var params = {};
        params[csrf] = token;

        $('#sp_ad_image_galery').fineUploader({
            template: 'qq-template-gallery',
            request: {
                endpoint: ADMIN_BASE_URL + '/sp_ad/upload_image_file',
                params: params
            },
            deleteFile: {
                enabled: true,
                endpoint: ADMIN_BASE_URL + '/sp_ad/delete_image_file',
            },
            thumbnails: {
                placeholders: {
                    waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                    notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
                }
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
                        var uuid = $('#sp_ad_image_galery').fineUploader('getUuid', id);
                        $('#sp_ad_image_uuid').val(uuid);
                        $('#sp_ad_image_name').val(xhr.uploadName);
                    } else {
                        toastr['error'](xhr.error);
                    }
                },
                onSubmit: function(id, name) {
                    var uuid = $('#sp_ad_image_uuid').val();
                    $.get(ADMIN_BASE_URL + '/sp_ad/delete_image_file/' + uuid);
                },
                onDeleteComplete: function(id, xhr, isError) {
                    if (isError == false) {
                        $('#sp_ad_image_uuid').val('');
                        $('#sp_ad_image_name').val('');
                    }
                }
            }
        }); /*end image galery*/







    }); /*end doc ready*/
</script>