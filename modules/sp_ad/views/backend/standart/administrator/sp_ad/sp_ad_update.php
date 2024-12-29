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
        Advertisement <small>Edit Advertisement</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_ad'); ?>">Advertisement</a></li>
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
                        <?= form_open(admin_base_url('/sp_ad/edit_save/' . $this->uri->segment(4)), [
                            'name' => 'form_sp_ad_edit',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_ad_edit',
                            'method' => 'POST'
                        ]); ?>

                        <?php $user_groups = $this->model_group->get_user_group_ids(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-title  ">
                                    <label for="title" class="col-sm-2 control-label">Title </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="" value="<?= set_value('title', $sp_ad->title); ?>">
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-link  ">
                                    <label for="link" class="col-sm-2 control-label">Link </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="link" id="link" placeholder="" value="<?= set_value('link', $sp_ad->link); ?>">
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-order  ">
                                    <label for="order" class="col-sm-2 control-label">Order </label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" name="order" id="order" placeholder="" value="<?= set_value('order', $sp_ad->order); ?>">
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-order  ">
                                    <label for="order" class="col-sm-2 control-label">Type </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type">
                                            <option value="">Type</option>
                                            <option  <?= $sp_ad->type == "banner" ? 'selected' : ''; ?> value="banner">Banner</option>
                                            <option <?= $sp_ad->type == "left" ? 'selected' : ''; ?> value="left">Left Corner</option>
                                            <option <?= $sp_ad->type == "right" ? 'selected' : ''; ?> value="right">Right Corner</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group group-topic_id ">
                                    <label for="chapter_id" class="col-sm-2 control-label">Description </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="description" rows="2" cols="150"><?php echo $sp_ad->description ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group group-image  ">
                                    <label for="image" class="col-sm-2 control-label">Image <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <div id="sp_ad_image_galery"></div>
                                        <input class="data_file data_file_uuid" name="sp_ad_image_uuid" id="sp_ad_image_uuid" type="hidden" value="<?= set_value('sp_ad_image_uuid'); ?>">
                                        <input class="data_file" name="sp_ad_image_name" id="sp_ad_image_name" type="hidden" value="<?= set_value('sp_ad_image_name', $sp_ad->image); ?>">
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
    var module_name = "sp_ad"
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
                        window.location.href = ADMIN_BASE_URL + '/sp_ad';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_ad = $('#form_sp_ad_edit');
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
                    url: form_sp_ad.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('form').find('.error-input').remove();
                    $('.steps li').removeClass('error');
                    if (res.success) {
                        var id = $('#sp_ad_image_galery').find('li').attr('qq-file-id');
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

                            var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_ad/index/?ajax=1'
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

        $('#sp_ad_image_galery').fineUploader({
            template: 'qq-template-gallery',
            request: {
                endpoint: ADMIN_BASE_URL + '/sp_ad/upload_image_file',
                params: params
            },
            deleteFile: {
                enabled: true, // defaults to false
                endpoint: ADMIN_BASE_URL + '/sp_ad/delete_image_file'
            },
            thumbnails: {
                placeholders: {
                    waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                    notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
                }
            },
            session: {
                endpoint: ADMIN_BASE_URL + '/sp_ad/get_image_file/<?= $sp_ad->id; ?>',
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
        }); /*end image galey*/




        async function chain() {}

        chain();




    }); /*end doc ready*/
</script>