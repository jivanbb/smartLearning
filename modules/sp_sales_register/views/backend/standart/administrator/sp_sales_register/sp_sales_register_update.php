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
    <h1> Edit Sales Register</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('sp_sales_register/view/' . $id); ?>">Sales Register</a></li>
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
                        <?= form_open(base_url('administrator/sp_sales_register/edit_save/'), [
                            'name'    => 'form_sp_sales_register',
                            'class'   => 'form-horizontal',
                            'id'      => 'form_sp_sales_register',
                            'method'  => 'POST'
                        ]); ?>
                        <div class="row">
                            <div class="form-group group-name  ">
                                <label for="name" class="col-sm-2 control-label">Pan No <i class="required">*</i>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control customer_no" name="pan_no" id="pan_no" placeholder="" value="<?php echo $sp_sales_register->pan_no; ?>">
                                    <input type="hidden" class="customer_id" name="customer_id" value="<?php echo $sp_sales_register->customer_id; ?>">
                                </div>
                                <label for="name" class="col-sm-2 control-label">Name <i class="required">*</i>
                                </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control customer_name" name="name" id="name" value="<?php echo $sp_sales_register->name; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px;">
                            <div class="form-group group-tax_period ">
                                <label for="name" class="col-sm-2 control-label">Tax Period Type <i class="required">*</i>
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control chosen chosen-select-deselect" name="tax_period_type" id="tax_period_type" data-placeholder="Select Tax Period">
                                        <option value=""></option>
                                        <?php foreach ($tax_period_type as $row): ?>
                                            <option <?= $row->slug == $sp_sales_register->tax_period_type ? 'selected' : ''; ?> value="<?= $row->slug ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <label for="name" class="col-sm-2 control-label">Tax Period <i class="required">*</i>
                                </label>
                                <div class="col-sm-4">
                                    <select name="tax_period_id" class="form-control" id="tax_period">
                                        <option>Select Tax Period</option>
                                        <?php if ($sp_sales_register->tax_period_id) { ?>
                                            <?php foreach (db_get_all_data('sp_tax_period_type') as $row): ?>
                                                <option <?= $row->id == $sp_sales_register->tax_period_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->value; ?></option>
                                        <?php endforeach;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="register_id" value="<?php echo $sp_sales_register->id; ?>">
                        <div class="row" style="margin-top: 5px;">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Year <i class="required">*</i></label>
                                <div class="col-sm-4">
                                    <select name="year" class="form-control chosen chosen-select-deselect">
                                        <option>Select Year</option>
                                        <?php foreach (db_get_all_data('sp_year') as $row): ?>
                                            <option <?= $row->id == $sp_sales_register->year ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped dataTable" style=" min-width: 1500px; max-width: max-content;">
                                    <thead>
                                        <tr class="">
                                            <th>SN.</th>
                                            <th style="width:90px;">मिति</th>
                                            <th style="width:100px;">बीजक नम्बर</th>
                                            <th style="width:100px;">खरिदकर्ताको स्थायी लेखा नम्बर</th>
                                            <th style="width:100px;">खरिदकर्ताको नाम</th>
                                            <th>वस्तु वा सेवाको नाम</th>
                                            <th style="width:80px;">वस्तु वा सेवाको परिमाण</th>
                                            <th style="width:90px;">वस्तु वा सेवाको एकाई</th>
                                            <th style="width:90px;">जम्मा बिक्री / निकासी (रु)</th>
                                            <th style="width:100px;">स्थानीय कर छुटको बिक्री मूल्य (रु)</th>
                                            <th style="width:90px;">करयोग्य बिक्री मूल्य (रु)</th>
                                            <th style="width:90px;">करयोग्य बिक्री कर (रु)</th>
                                            <th style="width:90px;">निकासी गरेको वस्तु वा सेवाको मूल्य</th>
                                            <th style="width:90px;">निकासी गरेको देश</th>
                                            <th style="width:90px;">निकासी प्रज्ञापनपत्र मिति </th>
                                            <th style="width:90px;">निकासी प्रज्ञापनपत्र नम्बर</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales_register_table">
                                        <?php $sn = 0;
                                        foreach ($register_detail as $register) {
                                            $sn++; ?>
                                            <tr>
                                                <td><?php echo $sn; ?></td>
                                                <td><span class="value"><?= _ent($register->date); ?></span><span class="input hidden"><input type="text" class="datepicker" name="group[<?php echo $register->id; ?>][date]" value="<?php echo $register->date; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->bill_number); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][bill_number]" value="<?php echo $register->bill_number; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->customer_pan); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][customer_pan]" value="<?php echo $register->customer_pan; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->customer_name); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][customer_name]" value="<?php echo $register->customer_name; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->item_name); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][item_name]" value="<?php echo $register->item_name; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->quantity); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][quantity]" value="<?php echo $register->quantity; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->unit); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][unit]" value="<?php echo $register->unit; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->total); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][total]" value="<?php echo $register->total; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->taxable_discount_price); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][taxable_discount_price]" value="<?php echo $register->taxable_discount_price; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->vatable_price); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][vatable_price]" value="<?php echo $register->vatable_price; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->vat_price); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][vat_price]" value="<?php echo $register->vat_price; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->withdraw_item_price); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][withdraw_item_price]" value="<?php echo $register->withdraw_item_price; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->withdraw_country); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][withdraw_country]" value="<?php echo $register->withdraw_country; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->withdraw_date); ?></span><span class="input hidden"><input type="text" class="datepicker" name="group[<?php echo $register->id; ?>][withdraw_date]" value="<?php echo $register->withdraw_date; ?>" disabled></td>
                                                <td><span class="value"><?= _ent($register->withdraw_letter_no); ?></span><span class="input hidden"><input type="text" name="group[<?php echo $register->id; ?>][withdraw_letter_no]" value="<?php echo $register->withdraw_letter_no; ?>" disabled></td>
                                                <td><a href="#" class="edit-inline"><i class="fa fa-pencil"></i></a></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mt-10p">
                                <div class="row">
                                    <div class="col-xs-6 p-0">
                                        <button class="btn  btn-primary update_sales_register" id="btn_edit"><?= cclang('edit') ?>
                                        </button>
                                        <button href="#" id="btn_cancel" class='  btn-red cancel-edit-inline btn btn-flat btn-default btn_action' title="<?= cclang('cancel'); ?> (Ctrl+x)">
                                            <?= cclang('cancel'); ?></button>
                                    </div>

                                </div>
                            </div>

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
    $(document).ready(function() {

        $('.edit-inline').on('click', function(e) {
            e.preventDefault();
            var parentRow = $(this).parents('tr');
            $('td span.value', parentRow).addClass('hidden');
            $('td span.input', parentRow).removeClass('hidden');
            $('td span :input', parentRow).prop('disabled', false);
        });

        $('.update_sales_register').click(function() {
            var form_sp_sales_register = $('#form_sp_sales_register');
            var data_post = form_sp_sales_register.serializeArray();
            var save_type = $(this).attr('data-stype');
            data_post.push({
                name: 'save_type',
                value: save_type
            });
            $.ajax({
                    url: BASE_URL + '/administrator/sp_sales_register/edit_save',
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
                        $('.data_file_uuid').val('');
                        $('.edit-inline').each(function() {
                            var parentRow = $(this).parents('tr');
                            var td = $('td', parentRow);
                            td.each(function() {
                                $('span.value', this).removeClass('hidden');
                                var input = $('span.input :input', this);
                                var text = input.val();
                                if (input.is("select")) {
                                    text = $('option:selected', input).text();
                                }
                                $('span.value', this).text(text);
                                $('span.input', this).addClass('hidden');
                                $('span :input', this).prop('disabled', true);
                            });
                        });

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

        $(document).on('keydown', '.inputs', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                var index = $('.inputs').index(this) + 1;
                $('.inputs').eq(index).focus();
                e.preventDefault();
                return false;
            }
        });

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

        $(document).on('click', '.remove', function() {
            $(this).closest('tr').prev('tr').find('td:nth-child(1) input').focus();
            $(this).closest('tr').remove();
            $(this).closest('.clone-div').remove();
        });
        checkDetailExist();

    });

    function ItemRow() {
        var totalRows = $('#sales_register_table tr').length;
        var count = totalRows + 1;
        var html = '<tr>';
        html += '<td></td>';
        html += '<td><input type="text" class="form-control inputs datepicker " name="date[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="bill_number[]"  /></td>';
        html += '<td><input type="text" class="form-control auto_complete_pan inputs" name="customer_pan[]"  /></td>';
        html += '<td><input type="text" class="form-control customer_name inputs" name="customer_name[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="item_name[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="quantity[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="unit[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="total[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="taxable_discount_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="vatable_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="vat_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="withdraw_item_price[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs" name="withdraw_country[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs datepicker" name="withdraw_date[]"  /></td>';
        html += '<td><input type="text" class="form-control inputs lst" name="withdraw_letter_no[]"  /></td>';

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
            source: BASE_URL + "administrator/sp_sales_register/getCustomerPanNo",
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

    function checkDetailExist() {
        var totalRows = $('#sales_register_table tr').length;
        if (totalRows == 0) {
            $("#sales_register_table").append(ItemRow());
            autocompletePanNumber();
        }
    }
</script>