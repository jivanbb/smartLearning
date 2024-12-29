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
    <h1> Sales Register Detail</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('sp_sales_register/view/' . $id); ?>">Sales Register</a></li>
        <li class="active">View</li>
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
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-3 control-label">Name: </label>

                                    <div class="col-sm-9">
                                        <span class="detail_group-no_of_options"><strong><?php echo $sp_sales_register->name; ?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-5 control-label">Pan No: </label>

                                    <div class="col-sm-7">
                                        <?php echo $sp_sales_register->pan_no; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-5 control-label">Tax Period: </label>

                                    <div class="col-sm-7">
                                        <?php echo $sp_sales_register->tax_period; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-5 control-label">Year: </label>

                                    <div class="col-sm-7">
                                        <?php echo $sp_sales_register->year_name; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>


                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" style=" min-width: 2000px; max-width: max-content;">
                                <thead>
                                    <tr class="">
                                        <th>SN.</th>
                                        <th style="width:90px;">मिति</th>
                                        <th>बीजक नम्बर</th>
                                        <th>खरिदकर्ताको स्थायी लेखा नम्बर</th>
                                        <th>खरिदकर्ताको नाम</th>
                                        <th>वस्तु वा सेवाको नाम</th>
                                        <th>वस्तु वा सेवाको परिमाण</th>
                                        <th>वस्तु वा सेवाको एकाई</th>
                                        <th>जम्मा बिक्री / निकासी (रु)</th>
                                        <th>स्थानीय कर छुटको बिक्री मूल्य (रु)</th>
                                        <th>करयोग्य बिक्री मूल्य (रु)</th>
                                        <th>करयोग्य बिक्री कर (रु)</th>
                                        <th>निकासी गरेको वस्तु वा सेवाको मूल्य</th>
                                        <th>निकासी गरेको देश</th>
                                        <th>निकासी प्रज्ञापनपत्र मिति </th>
                                        <th>निकासी प्रज्ञापनपत्र नम्बर</th>
                                    </tr>
                                </thead>
                                <tbody id="sales_register_table">
                                    <?php $sn = 0;
                                    $total_sales =0;
                                    $total_taxable_discount_price =0;
                                    $total_vatable_price =0;
                                    $total_vat_price =0;
                                    $total_withdraw_item_price=0;
                                    foreach ($register_detail as $register) {
                                        $total_sales +=$register->total;
                                        $total_taxable_discount_price +=$register->taxable_discount_price;
                                        $total_vatable_price +=$register->vatable_price;
                                        $total_vat_price += $register->vat_price;
                                        $total_withdraw_item_price += $register->withdraw_item_price;
                                        $sn++; ?>
                                        <tr>
                                            <td><?php echo $sn; ?></td>
                                            <td><?php echo $register->date; ?></td>
                                            <td><?php echo $register->bill_number; ?></td>
                                            <td><?php echo $register->customer_pan; ?></td>
                                            <td><?php echo $register->customer_name; ?></td>
                                            <td><?php echo $register->item_name; ?></td>
                                            <td><?php echo $register->quantity; ?></td>
                                            <td><?php echo $register->unit; ?></td>
                                            <td><?php echo $register->total; ?></td>
                                            <td><?php echo $register->taxable_discount_price; ?></td>
                                            <td><?php echo $register->vatable_price; ?></td>
                                            <td><?php echo $register->vat_price; ?></td>
                                            <td><?php echo $register->withdraw_item_price; ?></td>
                                            <td><?php echo $register->withdraw_country; ?></td>
                                            <td><?php echo $register->withdraw_date; ?></td>
                                            <td><?php echo $register->withdraw_letter_no; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="8"><center><strong>Total</strong></center></td>
                                        <td><strong><?php echo $total_sales;?></strong></td>
                                        <td><strong><?php echo $total_taxable_discount_price;?></strong></td>
                                        <td><strong><?php echo $total_vatable_price;?></strong></td>
                                        <td><strong><?php echo $total_vat_price;?></strong></td>
                                        <td><strong><?php echo $total_withdraw_item_price;?></strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>