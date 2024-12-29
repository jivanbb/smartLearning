<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_sales_register/add';
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
      <div class="col-md-10">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
               <li class="active"><a href="<?php echo base_url(); ?>administrator/sp_sales_register">Sales Register</a></li>
               <li ><a href="<?php echo base_url(); ?>administrator/sp_purchase_register">Purchase Register</a></li>
               <li ><a href="<?php echo base_url(); ?>administrator/sp_sales_register">Sales Return Register</a></li>
               <li ><a href="<?php echo base_url(); ?>administrator/sp_sales_register">Purchase Return Register</a></li>
            </ul>
         </div>
      </div>
      <div class="col-md-2">
         <?php if (check_role_exist_or_not(29, array("add"))) { ?>
            <a href="<?php echo base_url(); ?>administrator/sp_sales_register/add"  class="btn btn-flat btn-success btn_add_new pull-right" ><i class="fa fa-plus-square-o"></i> Sales Register</a>
         <?php } ?>
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

                  <form name="form_sp_sales_register" id="form_sp_sales_register" action="<?= admin_base_url('/sp_sales_register/index'); ?>">
                     <!-- /.widget-user -->
                     <div class="row">
                        <div class="col-md-8">
                           <div class="col-sm-3 padd-left-0  ">
                              <input type="text" class="form-control" name="q" id="filter" placeholder="<?= cclang('filter'); ?>" value="<?= $this->input->get('q'); ?>">
                           </div>
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control chosen chosen-select" name="f" id="field">
                                 <option value=""><?= cclang('all'); ?></option>
                                 <option <?= $this->input->get('f') == 'name' ? 'selected' : ''; ?> value="name">Name</option>
                              </select>
                           </div>
                           <div class="col-sm-1 padd-left-0 ">
                              <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                           </div>
                           <div class="col-sm-1 padd-left-2 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_sales_register'); ?>" title="<?= cclang('reset_filter'); ?>">
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
                              <?= $tables ?>
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
   var module_name = "sp_sales_register"
   var use_ajax_crud = false
</script>
<script src="<?= BASE_ASSET ?>js/filter.js"></script>


<script>
   $(document).ready(function() {

      "use strict";



      if (use_ajax_crud == false) {

         $(document).on('click', 'a.remove-data', function() {

            var url = $(this).attr('data-href');

            swal({
                  title: "<?= cclang('are_you_sure'); ?>",
                  text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
                  cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
                  closeOnConfirm: true,
                  closeOnCancel: true
               },
               function(isConfirm) {
                  if (isConfirm) {
                     document.location.href = url;
                  }
               });

            return false;
         });
      }

      initSortableAjax('sp_sales_register', $('table.dataTable'));

      $('.btn_save').click(function() {
         $('.message').fadeOut();

         var form_sp_sales_register = $('#form_sp_sales_register_add');
         var data_post = form_sp_sales_register.serializeArray();
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
               url: ADMIN_BASE_URL + '/sp_sales_register/add_save',
               type: 'POST',
               dataType: 'json',
               data: data_post,
            })
            .done(function(res) {
               $('form').find('.form-group').removeClass('has-error');
               $('.steps li').removeClass('error');
               $('form').find('.error-input').remove();
               if (res.success) {
                  showStatusMessage('success', 'Success', res.message);
                  setTimeout(() => {
                     window.location.reload(true);
                  });
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
                  showValidationMessage(`${res.message}`);
               }

               if (use_ajax_crud == true) {

                  var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_sales_register/index/?ajax=1'
                  reloadDataTable(url);
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
</script>