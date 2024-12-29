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
        Edit MCQ
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_mcq_question'); ?>">MCQ </a></li>
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
                        <?= form_open(admin_base_url('/sp_mcq_question/edit_save/' . $this->uri->segment(4)), [
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
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="course_id" id="course_id" data-placeholder="Select Course">
                                    <option value=""></option>
                                    <?php
                                    $conditions = ['created_by' => $user_id];
                                    ?>
                                    <?php foreach (db_get_all_data('sp_course', $conditions) as $row): ?>
                                        <option <?= $row->id == $sp_mcq_question->course_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                        <div class="form-group group-chapter_id  ">
                            <label for="chapter_id" class="col-sm-2 control-label">Chapter <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="chapter_id" id="chapter_id" data-placeholder="Select Chapter">
                                    <option value=""></option>
                                    <?php $chapters = get_chapters(@$sp_mcq_question->course_id); ?>
                                    <?php foreach ($chapters  as $chapter): ?>
                                        <option <?= $chapter->id == $sp_mcq_question->chapter_id ? 'selected' : ''; ?> value="<?= $chapter->id ?>"><?= $chapter->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group group-topic_id">
                            <label for="topic_id" class="col-sm-2 control-label">Topic </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="topic_id" id="topic_id" data-placeholder="Select Topic ">
                                    <option value=""></option>
                                    <?php $topics = get_topics($sp_mcq_question->chapter_id); ?>
                                    <?php foreach ($topics as $topic): ?>
                                        <option <?= $topic->id == $sp_mcq_question->topic_id ? 'selected' : ''; ?> value="<?= $topic->id ?>"><?= $topic->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>

                        <div class="form-group group-no_of_options  ">
                            <label for="no_of_options" class="col-sm-2 control-label">No Of Options <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="no_of_options" id="no_of_options" placeholder="" value="<?= set_value('no_of_options', $sp_mcq_question->no_of_options); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
<!-- 
                        <div class="form-group group-set">
                            <label for="no_of_options" class="col-sm-2 control-label">Set <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="set_id" id="set" data-placeholder="Select Set">
                                    <option value="">Select Set</option>
                                    <?php $conditions = []; ?>
                                    <?php foreach (db_get_all_data('sp_set', $conditions) as $row): ?>
                                        <option <?= $row->id == $sp_mcq_question->set_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> -->

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
                        window.location.href = ADMIN_BASE_URL + '/sp_mcq_question';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('#course_id').change(function() {
            $('#chapter_id').empty();
            $('#topic_id').empty();
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

                            var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_mcq_question/index/?ajax=1'
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