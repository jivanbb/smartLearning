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
    <h1> Purchase Register Detail</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a href="<?= admin_site_url('sp_purchase_register/view/' . $id); ?>">Purchase Register</a></li>
        <li class="active">View5</li>
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
                                        <span class="detail_group-no_of_options"><strong><?php echo $sp_purchase_register->name; ?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-5 control-label">Pan No: </label>

                                    <div class="col-sm-7">
                                        <?php echo $sp_purchase_register->pan_no; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-5 control-label">Tax Period: </label>

                                    <div class="col-sm-7">
                                        <?php echo $sp_purchase_register->tax_period; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label for="content" class="col-sm-5 control-label">Year: </label>

                                    <div class="col-sm-7">
                                        <?php echo $sp_purchase_register->year_name; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
            
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" style=" min-width: 2000px; max-width: max-content;">
                                <thead>
                                    <tr class="">
                                    <tr>
                                        <th colspan="10" class="text-center">बीजक / प्रज्ञापनपत्र नम्बर</th>
                                        <th rowspan="2" style="width:200px;" class="text-center">जम्मा खरिद मूल्य (रु)</th>
                                        <th rowspan="2" style="width:200px;" class="text-center">कर छुट हुने वस्तुको खरिद मूल्य (रु)</th>
                                        <th colspan="2" class="text-center">करयोग्य खरिद (पूंजीगत बाहेक)</th>
                                        <th colspan="2" class="text-center">करयोग्य पैठारी (पूंजीगत बाहेक)</th>
                                        <th colspan="2" class="text-center">पूंजीगत करयोग्य खरिद / पैठारी</th>
                                    </tr>
                                    <th>SN.</th>
                                    <th style="width:90px;">मिति</th>
                                    <th>बीजक नम्बर</th>
                                    <th>प्रज्ञापनपत्र नं.</th>
                                    <th>आपूर्तिकर्ताको स्थायी लेखा नम्बर</th>
                                    <th>आपूर्तिकर्ताको नाम</th>
                                    <th>वस्तु वा सेवाको नाम</th>
                                    <th>वस्तु वा सेवाको परिमाण</th>
                                    <th>वस्तु वा सेवाको एकाई</th>
                                    <th>मूल्य (रु)</th>
                                    <th>कर (रु)</th>
                                    <th>मूल्य (रु)</th>
                                    <th>कर (रु)</th>
                                    <th>मूल्य (रु)</th>
                                    <th>कर (रु)</th>
                                    </tr>
                                </thead>
                                <tbody id="sales_register_table">
                                    <?php $sn = 0;
                                    $total_purchase_price = 0;
                                    $purchase_discount_price = 0;
                                    $vatable_price = 0;
                                    $vat_price = 0;
                                    $without_vatable_price = 0;
                                    $without_vat_price = 0;
                                    $capital_vatable_price = 0;
                                    $capital_vat_price = 0;
                                    foreach ($register_detail as $register) {
                                        $total_purchase_price += $register->total_purchase_price;
                                        $purchase_discount_price += $register->purchase_discount_price;
                                        $vatable_price += $register->vatable_price;
                                        $vat_price += $register->vat_price;
                                        $without_vatable_price += $register->without_vatable_price;
                                        $without_vat_price += $register->without_vat_price;
                                        $capital_vatable_price +=$register->capital_vatable_price;
                                        $capital_vat_price +=$register->capital_vat_price;
                                        $sn++; ?>
                                        <tr>
                                            <td><?php echo $sn; ?></td>
                                            <td><?php echo $register->date; ?></td>
                                            <td><?php echo $register->bill_number; ?></td>
                                            <td><?php echo $register->declaration_form_number; ?></td>
                                            <td><?php echo $register->supplier_pan; ?></td>
                                            <td><?php echo $register->supplier_name; ?></td>
                                            <td><?php echo $register->item_name; ?></td>
                                            <td><?php echo $register->quantity; ?></td>
                                            <td><?php echo $register->unit; ?></td>
                                            <td><?php echo $register->total_purchase_price; ?></td>
                                            <td><?php echo $register->purchase_discount_price; ?></td>
                                            <td><?php echo $register->vatable_price; ?></td>
                                            <td><?php echo $register->vat_price; ?></td>
                                            <td><?php echo $register->without_vatable_price; ?></td>
                                            <td><?php echo $register->without_vat_price; ?></td>
                                            <td><?php echo $register->capital_vatable_price; ?></td>
                                            <td><?php echo $register->capital_vat_price; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="9"><center><strong>Total</strong></center></td>
                                        <td><strong><?php echo $total_purchase_price;?></strong></td>
                                        <td><strong><?php echo $purchase_discount_price;?></strong></td>
                                        <td><strong><?php echo $vatable_price;?></strong></td>
                                        <td><strong><?php echo $vat_price;?></strong></td>
                                        <td><strong><?php echo $without_vatable_price;?></strong></td>
                                        <td><strong><?php echo $without_vat_price;?></strong></td>
                                        <td><strong><?php echo $capital_vatable_price;?></strong></td>
                                        <td><strong><?php echo $capital_vat_price;?></strong></td>
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