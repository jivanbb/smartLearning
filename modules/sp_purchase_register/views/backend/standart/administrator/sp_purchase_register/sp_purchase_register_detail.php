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
    <h1> Purchase Register Detail </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('/sp_purchase_register'); ?>"> Purchase Register Detail </a></li>
        <li class="active">Detail</li>
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
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-3 control-label">Name: </label>

                                    <div class="col-sm-9">
                                        <span class="detail_group-no_of_options"><strong><?php echo $sp_purchase_register->name; ?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-6 control-label">Pan No: </label>

                                    <div class="col-sm-6">
                                        <?php echo $sp_purchase_register->pan_no; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-7 control-label">Tax Period: </label>

                                    <div class="col-sm-5">
                                        <?php echo $sp_purchase_register->tax_period; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-3 control-label">Year: </label>

                                    <div class="col-sm-9" style="display: flex;">
                                        <?php echo $sp_purchase_register->year_name; ?>
                                        <button type="button" style="margin-left: 5px;" class="btn btn-flat btn-success btn_add_new pull-right" data-toggle="modal" data-target="#new_customer"><i class="fa fa-plus-square-o"></i> <?= cclang('customer_detail'); ?></button>
                                        <a class="btn btn-flat btn-excel btn-success" title="<?= cclang('excel'); ?>" style="margin-left: 5px;"
                                            href="<?= site_url('administrator/sp_purchase_register/purchase_register_excel/?' . http_build_query($this->input->get())); ?>"><i
                                                class="fa fa-download"></i>
                                        </a>
                                        <a class="btn btn-flat btn-excel btn-success" data-toggle="modal" data-target="#uploadcsv" style="margin-left: 5px;"><i class="fa fa-upload" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?= form_open('', [
                            'name' => 'form_sp_purchase_register_detail',
                            'class' => 'form-horizontal form-step',
                            'id' => 'form_sp_purchase_register_detail',
                            'method' => 'POST'
                        ]); ?>
                        <!-- <div class="row"> -->
                        <!-- <div class="col-md-12"> -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" style=" min-width: 2000px; max-width: max-content;">
                                <thead>
                                    <tr>
                                        <th colspan="8" class="text-center">बीजक / प्रज्ञापनपत्र नम्बर</th>
                                        <th rowspan="2" style="width:300px;" class="text-center">जम्मा बिक्री / निकासी (रु)</th>
                                        <th rowspan="2" style="width:300px;" class="text-center">कर छुट हुने वस्तुको खरिद मूल्य (रु)</th>
                                        <th colspan="2" class="text-center">करयोग्य खरिद (पूंजीगत बाहेक)</th>
                                        <th colspan="2" class="text-center">करयोग्य पैठारी (पूंजीगत बाहेक)</th>
                                        <th colspan="2" class="text-center">पूंजीगत करयोग्य खरिद / पैठारी</th>
                                    </tr>
                                    <tr class="">
                                        <th style="width:300px;">मिति</th>
                                        <th style="width:250px; ">बीजक नम्बर</th>
                                        <th style="width:250px;">प्रज्ञापनपत्र नं</th>
                                        <th style="width:300px;">आपूर्तिकर्ताको स्थायी लेखा नम्बर</th>
                                        <th style="width:250px;">आपूर्तिकर्ताको नाम</th>
                                        <th style="width:280px;">वस्तु वा सेवाको विवरण</th>
                                        <th style="width:280px;">वस्तु वा सेवाको परिमाण</th>
                                        <th style="width:280px;">वस्तु वा सेवाको एकाई</th>
                                        <th style="width:150px;">मूल्य (रु)</th>
                                        <th style="width:150px;">कर (रु)</th>
                                        <th style="width:150px;">मूल्य (रु)</th>
                                        <th style="width:150px;">कर (रु)</th>
                                        <th style="width:150px;">मूल्य (रु)</th>
                                        <th style="width:150px;">कर (रु)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sales_register_table">
                                </tbody>
                                <input type="hidden" name="register_id" value="<?php echo $register_id; ?>">
                            </table>
                        </div>
                        <!-- </div> -->
                        <!-- </div> -->

                        <div class="message"></div>
                        <div class="row-fluid col-md-7 container-button-bottom">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
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
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>

<div id="uploadcsv" class="modal fade bd-example-modal-sm" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload CSV</h4>
            </div>
            <?= form_open(base_url('administrator/sp_purchase_register/import'), [
                'name'    => 'sales_register_upload',
                'class'   => 'form-horizontal',
                'id'      => 'sales_register_upload',
                'enctype' => 'multipart/form-data',
                'method'  => 'POST'
            ]); ?>
            <div class="modal-body ">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="form-wrap">
                            <input type="file" name="upload_file" class="form-control" />
                            <input type="hidden" name="purchase_register_id" value="<?php echo $register_id; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-flat btn-primary btn_action" data-stype='stay'>Upload</button>
                <button type="button" class="btn-default btn-close" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>


    </div>
</div>

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

        $("#sales_register_table").append(ItemRow());
        autocompletePanNumber();

        $("#sales_register_table").on('keyup', '.lst ', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                $("#sales_register_table").append(ItemRow());
                $('.datepicker').each(function(index, el) {
                    $(this).datetimepicker({
                        timepicker: false,
                        formatDate: 'Y.m.d',

                    });
                });

                $('.datepicker').each(function(index, el) {
                    $(this).inputmask({
                        mask: "y-1-2",
                        placeholder: "yyyy-mm-dd",
                        leapday: "-02-29",
                        separator: "-",
                        alias: "yyyy/mm/dd"
                    });
                });
                autocompletePanNumber();
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
            $(this).closest('tr').prev('tr').find('td:nth-child(1) input').focus();
            $(this).closest('tr').remove();
            $(this).closest('.clone-div').remove();
        });

        $('.btn_save').click(function() {
            $('.message').fadeOut();

            var form_sp_purchase_register_detail = $('#form_sp_purchase_register_detail');
            var data_post = form_sp_purchase_register_detail.serializeArray();
            $('.loading').show();

            $.ajax({
                    url: ADMIN_BASE_URL + '/sp_purchase_register/detail_save',
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
    function ItemRow() {

        var totalRows = $('#sales_register_table tr').length;
        var count = totalRows + 1;
        var html = '<tr>';
        html += '<td><input type="text" class="form-control inputs datepicker " name="date[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="bill_number[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="declaration_form_number[]"  /></td>';
        html += '<td><input type="text" class="form-control auto_complete_pan inputs" name="supplier_pan[]"  /></td>';
        html += '<td><input type="text" class="form-control customer_name inputs" name="supplier_name[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="item_name[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="quantity[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="unit[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="total_purchase_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="purchase_discount_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="vatable_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="vat_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="without_vatable_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="without_vat_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs " name="capital_vatable_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs lst" name="capital_vat_price[]"  /></td>';

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

    function autocompletePanNumber() {
        $(".auto_complete_pan").autocomplete({
            source: BASE_URL + "administrator/sp_purchase_register/getSupplierPanNo",
            select: function(event, ui) {
                event.preventDefault();
                var target = $(event.target);
                var parentRow = target.parents('tr');
                $(event.target).val(ui.item.label);
                $('.customer_name', parentRow).val(ui.item.customer_name);
            },
            change: function(event, ui) {
                if (!ui.item) {
                    $(event.target).val('');
                }
            },
            focus: function(event, ui) {
                event.preventDefault();
                $(event.target).val(ui.item.label);
            },
            response: function(event, ui) {
                if (ui.content.length === 0) {
                    showStatusMessage('error', 'Error', 'No results found');
                    return false;
                }
            }
        });
    }
</script>