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
      Video  Materials <small>Edit Video Materials</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_video'); ?>">Video Materials</a></li>
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
                        <!-- <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <h3 class="widget-user-username">Sp Materials</h3>
                            <h5 class="widget-user-desc">Edit Sp Materials</h5>
                            <hr>
                        </div> -->
                        <?= form_open(admin_base_url('/sp_video/edit_save/' . $this->uri->segment(4)), [
                            'name' => 'form_sp_video_edit',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_video_edit',
                            'method' => 'POST'
                        ]); ?>

                        <?php $user_groups = $this->model_group->get_user_group_ids(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-course_id  ">
                                    <label for="course_id" class="col-sm-2 control-label">Course<i class="required">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select type="text" class="form-control chosen chosen-select course_id" name="course_id">
                                            <option value="">Course</option>
                                            <?php foreach (db_get_all_data('sp_course', [ 'is_deleted' => 0]) as $row): ?>
                                                <option <?= $row->id == $sp_video->course_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id  ">
                                    <label for="chapter_id" class="col-sm-2 control-label">Chapter </label>
                                    <div class="col-sm-8">
                                        <select type="text" class="form-control " name="chapter_id" id="chapter_id">
                                            <option value=""><?= cclang('chapter'); ?></option>
                                            <?php if ($sp_video->course_id) {
                                                $chapters = get_chapters($sp_video->course_id);
                                                foreach ($chapters as $chapter) { ?>
                                                    <option <?= $chapter->id == $sp_video->chapter_id ? 'selected' : ''; ?> value="<?php echo $chapter->id; ?>"><?php echo $chapter->name ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-topic_id  ">
                                    <label for="topic_id" class="col-sm-2 control-label">Topic</label>
                                    <div class="col-sm-8">
                                        <select type="text" class="form-control " name="topic_id" id="topic_id">
                                            <option value=""><?= cclang('topic'); ?></option>
                                            <?php if ($sp_video->chapter_id) {
                                                $topics = get_topics($sp_video->chapter_id);
                                                foreach ($topics as $topic) { ?>
                                                    <option <?= $topic->id == $sp_video->topic_id ? 'selected' : ''; ?> value="<?php echo $topic->id; ?>"><?php echo $topic->name ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group group-materials  ">
                                    <label for="materials" class="col-sm-2 control-label">Video Upload <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <div id="sp_video_materials_galery"></div>
                                        <div id="sp_video_materials_galery_listed">
                                            <?php foreach ((array) explode(',', $sp_video->materials) as $idx => $filename): ?>
                                                <input type="hidden" class="listed_file_uuid" name="sp_video_materials_uuid[<?= $idx ?>]" value="" /><input type="hidden" class="listed_file_name" name="sp_video_materials_name[<?= $idx ?>]" value="<?= $filename; ?>" />
                                            <?php endforeach; ?>
                                        </div>
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
    var module_name = "sp_video"
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
                        window.location.href = ADMIN_BASE_URL + '/sp_video';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('#course_id').change(function() {
         $('#chapter_id').empty();
         var course_id = $(this).val();
         if (course_id !== '') {

            $.ajax({
               type: 'GET',
               data: course_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getChapter/' + course_id,
               success: function(html) {
                  $('#chapter_id').html(html);
               }
            });
         }
      });

      $('#chapter_id').change(function() {
         $('#topic_id').empty();
         var chapter_id = $(this).val();
         if (chapter_id !== '') {

            $.ajax({
               type: 'GET',
               data: chapter_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getTopic/' + chapter_id,
               success: function(html) {
                  $('#topic_id').html(html);
               }
            });

         }
      });

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_video = $('#form_sp_video_edit');
            var data_post = form_sp_video.serializeArray();
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
                    url: form_sp_video.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('form').find('.error-input').remove();
                    $('.steps li').removeClass('error');
                    if (res.success) {
                        var id = $('#sp_video_image_galery').find('li').attr('qq-file-id');
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

                            var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_video/index/?ajax=1'
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

        $('#sp_video_materials_galery').fineUploader({
            template: 'qq-template-gallery',
            request: {
                endpoint: ADMIN_BASE_URL + '/sp_video/upload_materials_file',
                params: params
            },
            deleteFile: {
                enabled: true,
                endpoint: ADMIN_BASE_URL + '/sp_video/delete_materials_file',
            },
            thumbnails: {
                placeholders: {
                    waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                    notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
                }
            },
            session: {
                endpoint: ADMIN_BASE_URL + '/sp_video/get_materials_file/<?= $sp_video->id; ?>',
                refreshOnRequest: true
            },
            validation: {
                allowedExtensions: ["mp4|avi|mov|flv|wmv|mkv"],
                sizeLimit: 0,
            },
            showMessage: function(msg) {
                toastr['error'](msg);
            },
            callbacks: {
                onComplete: function(id, name, xhr) {
                    if (xhr.success) {
                        var uuid = $('#sp_video_materials_galery').fineUploader('getUuid', id);
                        $('#sp_video_materials_galery_listed').append('<input type="hidden" class="listed_file_uuid" name="sp_video_materials_uuid[' + id + ']" value="' + uuid + '" /><input type="hidden" class="listed_file_name" name="sp_video_materials_name[' + id + ']" value="' + xhr.uploadName + '" />');
                    } else {
                        toastr['error'](xhr.error);
                    }
                },
                onDeleteComplete: function(id, xhr, isError) {
                    if (isError == false) {
                        $('#sp_video_materials_galery_listed').find('.listed_file_uuid[name="sp_video_materials_uuid[' + id + ']"]').remove();
                        $('#sp_video_materials_galery_listed').find('.listed_file_name[name="sp_video_materials_name[' + id + ']"]').remove();
                    }
                }
            }
        }); /*end materials galery*/


        async function chain() {}

        chain();




    }); /*end doc ready*/
</script>