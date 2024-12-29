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
        Customer Detail <small>Edit Customer Detail</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_customer_detail'); ?>"> Customer Detail</a></li>
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
                            <h3 class="widget-user-username"> Board</h3>
                            <h5 class="widget-user-desc">Edit Board</h5>
                            <hr>
                        </div> -->
                        <?= form_open(admin_base_url('/sp_customer_detail/edit_save/' . $this->uri->segment(4)), [
                            'name' => 'form_sp_customer_detail_edit',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_customer_detail_edit',
                            'method' => 'POST'
                        ]); ?>

                        <?php $user_groups = $this->model_group->get_user_group_ids(); ?>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Name <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?= set_value('name', $sp_customer_detail->name); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Pan No <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="pan_no" id="pan_no" placeholder="" value="<?= set_value('pan_no', $sp_customer_detail->pan_no); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Address <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address" id="address" placeholder="" value="<?= set_value('address', $sp_customer_detail->address); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Eamil 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?= set_value('email', $sp_customer_detail->email); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Phone 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="" value="<?= set_value('phone', $sp_customer_detail->phone_no); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Is Client <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control chosen chosen-select-deselect" name="is_client" id="is_client" data-placeholder="Select Is Client">
                                    <option value=""></option>
                                        <option <?= 1 == $sp_customer_detail->is_client ? 'selected' : ''; ?> value="1">Yes</option>
                                        <option <?= 0 == $sp_customer_detail->is_client ? 'selected' : ''; ?> value="0">No</option>
                                </select>
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
    var module_name = "sp_customer_detail"
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
                        window.location.href = ADMIN_BASE_URL + '/sp_customer_detail';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_customer_detail = $('#form_sp_customer_detail_edit');
            var data_post = form_sp_customer_detail.serializeArray();
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
                    url: form_sp_customer_detail.attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    $('form').find('.form-group').removeClass('has-error');
                    $('form').find('.error-input').remove();
                    $('.steps li').removeClass('error');
                    if (res.success) {
                        var id = $('#sp_customer_detail_image_galery').find('li').attr('qq-file-id');
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

                            var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_customer_detail/index/?ajax=1'
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