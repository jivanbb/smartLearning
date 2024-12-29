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
    <h1> Company Detail </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_company'); ?>">Company Detail </a></li>
        <li class="active"><?= cclang('new'); ?></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <div class="box box-widget widget-user-2">
                        <?= form_open(admin_base_url('sp_company/edit_save/' . $id), [
                            'name' => 'form_company_detail',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_company_detail',
                            'enctype' => 'multipart/form-data',
                            'method' => 'POST'
                        ]); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-course_id ">
                                    <label for="course_id" class="col-sm-3 control-label">Name<i class="required">*</i>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $company_detail->name;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-course_id ">
                                    <label for="course_id" class="col-sm-3 control-label">Address <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $company_detail->address;?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-3 control-label">Phone <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phone_no" placeholder="Phone" value="<?php echo $company_detail->phone_no;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-3 control-label">Email <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $company_detail->email;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-3 control-label">Facebook Link </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="fb_link" placeholder="Facebook Link" value="<?php echo $company_detail->fb_link;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-3 control-label">Twitter Link </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="twitter_link" placeholder="Twitter Link" value="<?php echo $company_detail->twitter_link;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-3 control-label">Linkedin Link </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="linkedin_link" placeholder="Linkedin Link" value="<?php echo $company_detail->linkedin_link;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-topic_id ">
                                    <label for="topic_id" class="col-sm-3 control-label">Youtube Link </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="youtube_link" placeholder="Youtube Link" value="<?php echo $company_detail->youtube_link;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-topic_id ">
                                    <label for="topic_id" class="col-sm-3 control-label">Footer Note <i class="required">*</i></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="footer_note" placeholder="Footer Note" value="<?php echo $company_detail->footer_note;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message"></div>
                        <div class="row-fluid col-md-7 container-button-bottom">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                                <i class="fa fa-save"></i> <?= cclang('save_button'); ?>
                            </button>

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
                        window.location.href = ADMIN_BASE_URL + '/sp_company';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_company_detail = $('#form_company_detail');
            var data_post = form_company_detail.serializeArray();
            $.ajax({
                    url:  form_company_detail.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    if (res.success) {
                  showStatusMessage('success', 'Success', res.message);
                  setTimeout(() => {
                     window.location.reload(true);
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




    }); /*end doc ready*/
</script>