<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_purchase_register/add';
         return false;
      });

      $('*').bind('keydown', 'Ctrl+f', function() {
         $('#sbtn').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+x', function() {
         $('#reset').trigger('click');
         return false;
      });

      $('*').bind('keydown', 'Ctrl+b', function() {

         $('#reset').trigger('click');
         return false;
      });
   }

   jQuery(document).ready(domo);
</script>
<!-- <section class="content-header">
   <h1>Sales Register</h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Sales Register</li>
   </ol>
</section> -->
<div class="row-fluid">
   <!-- <div class="col-md-12"> -->
      <div class="col-md-12">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <li ><a href="<?php echo base_url(); ?>administrator/sp_sales_register/report">Sales Register</a></li>
               <li class="active"><a href="<?php echo base_url(); ?>administrator/sp_purchase_register/report">Purchase Register</a></li>
               <li ><a href="<?php echo base_url(); ?>administrator/sp_sales_register/report">Sales Return Register</a></li>
               <li ><a href="<?php echo base_url(); ?>administrator/sp_sales_register/report">Purchase Return Register</a></li>
            </ul>
         </div>
      </div>
   <!-- </div> -->

</div>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">

                  <form name="form_sp_sales_register" id="form_sp_sales_register" action="<?= admin_base_url('/sp_purchase_register/report'); ?>">
                     <!-- /.widget-user -->
                     <div class="row">
                        <div class="col-md-12">
                           <div class="col-sm-2 padd-left-0  ">
                              <input type="text" class="form-control customer_no" name="pan_no" id="pan_no" placeholder="Choose Pan" value="<?php echo @$filter['pan_no']?>">
                              <input type="hidden" class="customer_id" name="customer_id">
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <input type="text" class="form-control customer_name" name="name" id="name" placeholder="Name" readonly value="<?php echo @$filter['name']?>">
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <select class="form-control chosen chosen-select-deselect" name="tax_period_type" id="tax_period_type" data-placeholder="Select Tax Period">
                                 <option value=""></option>
                                 <?php foreach ($tax_period_type as $row): ?>
                                    <option <?= $row->slug == @$filter['tax_period_type'] ? 'selected' : ''; ?> value="<?= $row->slug ?>"><?= $row->name; ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <select name="tax_period_id" class="form-control" id="tax_period" placeholder="Tax Period">

                              </select>
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <select name="year" class="form-control chosen chosen-select-deselect">
                                 <option value="">Select Year</option>
                                 <?php foreach (db_get_all_data('sp_year') as $row): ?>
                                    <option <?= $row->id == @$filter['year'] ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                           <div class="col-sm-1 padd-left-0 ">
                              <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                           </div>
                           <div class="col-sm-1 padd-left-2 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_purchase_register/report'); ?>" title="<?= cclang('reset_filter'); ?>">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>

                     </div>
                     <div class="table-responsive">

                        <br>
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr class="">
                                 <th data-field="id" data-sort="1" data-primary-key="0"> <?= cclang('sn') ?></th>
                                 <th data-field="pan_no" data-sort="1" data-primary-key="0"> <?= cclang('pan_no') ?></th>
                                 <th data-field="name" data-sort="1" data-primary-key="0"> <?= cclang('name') ?></th>
                                 <th data-field="year" data-sort="1" data-primary-key="0"> <?= cclang('year') ?></th>
                                 <th>Tax Period</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_sp_sales_register">
                           <?php if ($count > 0) {
                           foreach($purchase_list as $purchase){?>
                                 <tr>
                                    <td><?= _ent(++$offset); ?></td>
                                    <td><?php echo $purchase->pan_no?></td>
                                    <td><?php echo $purchase->name?></td>
                                    <td><?php echo $purchase->year?></td>
                                    <td><?php echo $purchase->tax_period?></td>
                                    <td> <a href="<?= admin_site_url('/sp_purchase_register/view/' . $purchase->id); ?>" data-id="<?= $purchase->id ?>" class="label-default btn-act-edit"><i class="fa fa-eye "></i> </a></td>
                                 </tr>

                             <?php } } else { ?>
                              <tr><td colspan="6"><strong> Data Found!</strong></td></tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>

               </div>
               <!-- <div class="row"> -->
               <!-- <div class="col-md-4"> -->
               <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                  <div class="table-pagination"><?= $pagination; ?></div>
               </div>
               <!-- </div> -->
               <!-- </div> -->
            </div>
            </form>
         </div>
      </div>
   </div>
</section>
<script>
   $(document).ready(function() {
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