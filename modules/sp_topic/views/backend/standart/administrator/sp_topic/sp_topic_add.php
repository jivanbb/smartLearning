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
        Topic <small><?= cclang('new', ['Topic']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_topic'); ?>">Topic</a></li>
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
                            'name' => 'form_sp_topic_add',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_topic_add',
                            'enctype' => 'multipart/form-data',
                            'method' => 'POST'
                        ]); ?>
                        <?php
                        $user_groups = $this->model_group->get_user_group_ids();
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group group-course_id ">
                                    <label for="course_id" class="col-sm-2 control-label">Course <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control chosen chosen-select-deselect" name="course_id" id="course_id" data-placeholder="Select Course">
                                            <option value=""></option>
                                            <?php $conditions = [];  ?>

                                            <?php foreach (db_get_all_data('sp_course', $conditions) as $row): ?>
                                                <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group group-chapter_id ">
                                    <label for="chapter_id" class="col-sm-2 control-label">Chapter <i class="required">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control chosen chosen-select-deselect" name="chapter_id" id="chapter_id" data-placeholder="Select Chapter">
                                            <option value=""></option>
                                            <?php $conditions = [];     ?>

                                            <?php foreach (db_get_all_data('sp_chapter', $conditions) as $row): ?>
                                                <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="info help-block">
                                        </small>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                             <div class="col-md-12"> 
                            <div class="dt-responsive table-responsive">
                                <table  class="table table-striped table-bordered ">
                                    <thead >
                                        <tr class="">
                                            <th style="width:150px; !important"><?= cclang('topic') . ' ' . cclang('number') ?></th>
                                            <th><?= cclang('topic').' '.cclang('name') ?></th>
                                            <th><?= cclang('action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="topic_table">
                                    </tbody>
                                </table>
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
            </div>
        </div>
    </div>
</section>

<script>
    var module_name = "sp_topic"
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
                        window.location.href = ADMIN_BASE_URL + '/sp_topic';
                    }
                });

            return false;
        }); /*end btn cancel*/
    
        $("#topic_table").append(ItemRow());
   
        $("#topic_table").on('keyup', '.lst ', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                $("#topic_table").append(ItemRow());
            }
        });
        $(document).on('keydown', '.inputs', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                var index = $('.inputs').index(this) + 1;
                $('.inputs').eq(index).focus();
                e.preventDefault();
                return false;
            }
        });
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
            $(this).closest('.clone-div').remove();
        });

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_topic = $('#form_sp_topic_add');
            var data_post = form_sp_topic.serializeArray();
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
                    url: ADMIN_BASE_URL + '/sp_topic/add_save',
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

                        var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_topic/index/?ajax=1'
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

    }); /*end doc ready*/
    function ItemRow() {

var totalRows = $('#topic_table tr').length;
var count = totalRows + 1;
var html = '<tr>';
html += '<td><input type="text" class="form-control inputs " name="topic_no[]"  /></td>';
html += '<td><input type="text" class="form-control inputs lst" name="name[]"  /></td>';
if (totalRows > 0) {
    html += `<td class="">
<button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fa fa-minus"></i></button>
</td>`;
} else {
    html += `<td class="text-right">
</td>`;
}
html += `</tr>`;
return html;

}
</script>