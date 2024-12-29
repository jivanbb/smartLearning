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
    <h1>Purchase Register </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_purchase_register'); ?>"> Purchase Register</a></li>
        <li class="active">Create</li>
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
                        <?= form_open('', [
                            'name' => 'form_sp_purchase_register_add',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_purchase_register_add',
                            'method' => 'POST'
                        ]); ?>

                        <?php $user_groups = $this->model_group->get_user_group_ids(); ?>
                        <div class="form-group group-name  ">
                            <label for="name" class="col-sm-2 control-label">Pan No <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control customer_no" name="pan_no" id="pan_no" placeholder="" value="">
                                <input type="hidden" class="customer_id" name="customer_id">
                            </div>
                            <label for="name" class="col-sm-2 control-label">Name <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control customer_name" name="name" id="name" readonly>
                            </div>
                        </div>

                        <div class="form-group group-tax_period ">
                            <label for="name" class="col-sm-2 control-label">Tax Period Type <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                                <select class="form-control chosen chosen-select-deselect" name="tax_period_type" id="tax_period_type" data-placeholder="Select Tax Period">
                                    <option value=""></option>
                                    <?php foreach ($tax_period_type as $row): ?>
                                        <option value="<?= $row->slug ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="name" class="col-sm-2 control-label">Tax Period <i class="required">*</i>
                            </label>
                            <div class="col-sm-4">
                            <select name="tax_period_id" class="form-control" id="tax_period">
                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Year <i class="required">*</i></label>
                            <div class="col-sm-4">
                                <select name="year" class="form-control chosen chosen-select-deselect">
                                    <option>Select Year</option>
                                <?php foreach (db_get_all_data('sp_year') as $row): ?>
                              <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                           <?php endforeach; ?>
                                </select>
                            </div>
                        </div>



                        <div class="message"></div>
                        <div class="row-fluid col-md-7 container-button-bottom">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                                <i class="fa fa-save"></i> <?= cclang('next'); ?>
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
                        window.location.href = ADMIN_BASE_URL + '/sp_purchase_register';
                    }
                });

            return false;
        }); /*end btn cancel*/

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sales_register = $('#form_sp_purchase_register_add');
            var data_post = form_sales_register.serializeArray();
            var save_type = $(this).attr('data-stype');
            data_post.push({
                name: 'save_type',
                value: save_type
            });
            $('.loading').show();

            $.ajax({
                    url: ADMIN_BASE_URL + '/sp_purchase_register/add_save',
                    type: 'POST',
                    dataType: 'json',
                    data: data_post,
                })
                .done(function(res) {
                    if (res.success) {
                showStatusMessage('success', 'Success', res.message);
                window.location.href = res.redirect;
                return;
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
        async function chain() {}

        chain();

        $(".customer_no").autocomplete({
            source: BASE_URL + "administrator/sp_sales_register/getPanNo",

            select: function(event, ui) {
                event.preventDefault();
                $(event.target).val(ui.item.label);
                $('.customer_id').val(ui.item.customer_id);
                $('.customer_name').val(ui.item.customer_name);
            },
            focus: function(event, ui) {
                event.preventDefault();
                $(event.target).val(ui.item.label);
            },
            response: function(event, ui) {
                if (ui.content.length === 0) {
                    showStatusMessage('error', 'Error', 'No results found');
                    $(this).val("");
                    return false;
                }
            }

        });


        $('#tax_period_type').change(function() {
            var tax_period_type = $(this).val();
            if (tax_period_type !== '') {
                $.ajax({
                    type: 'GET',
                    data: tax_period_type,
                    dataType: 'html',
                    url: BASE_URL + '/administrator/sp_sales_register/getTaxPeriod/' + tax_period_type,
                    success: function(html) {
                        $('#tax_period').html(html);
                    }
                });
            }
        });


    }); /*end doc ready*/
</script>