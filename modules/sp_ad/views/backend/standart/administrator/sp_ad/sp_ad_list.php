<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_ad/add';
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
<section class="content-header">
   <h1>
      <?= cclang('sp_ad') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('sp_ad') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <div class="row">
                     <div class="col-md-12">
                        <button type="button" class="btn btn-flat btn-success btn_add_new pull-right" data-toggle="modal" data-target="#new_add"><i class="fa fa-plus-square-o"></i> <?= cclang('sp_ad'); ?></button>
                     </div>
                  </div>
                  <form name="form_sp_ad" id="form_sp_ad" action="<?= admin_base_url('/sp_ad/index'); ?>">
                     <!-- /.widget-user -->
                     <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr class="">
                                 <th data-field="title" data-sort="1" data-primary-key="0"> <?= cclang('title') ?></th>
                                 <th data-field="image" data-sort="0" data-primary-key="0"> <?= cclang('image') ?></th>
                                 <th data-field="link" data-sort="1" data-primary-key="0"> <?= cclang('link') ?></th>
                                 <th data-field="order" data-sort="1" data-primary-key="0"> <?= cclang('order') ?></th>
                                 <th>Type</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_sp_ad">
                              <?= $tables ?>
                           </tbody>
                        </table>
                     </div>
                     <div class="col-md-4">
                        <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                           <div class="table-pagination"><?= $pagination; ?></div>
                        </div>
                     </div>
                  </form>
               </div>
               <hr>

            </div>

         </div>
      </div>
   </div>
</section>

<div id="new_add" class="modal fade new-july-design" role="dialog">

   <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Advertisement</h4>
         </div>
         <div class="modal-body new-july-design">
            <?= form_open('', [
               'name' => 'form_sp_ad_add',
               'class' => 'form-horizontal',
               'id' => 'form_sp_ad_add',
               'enctype' => 'multipart/form-data',
               'method' => 'POST'
            ]); ?>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group group-course_id ">
                     <label for="course_id" class="col-sm-3 control-label">Title <i class="required">*</i>
                     </label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group group-chapter_id ">
                     <label for="chapter_id" class="col-sm-3 control-label">Link </label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" name="link" id="link" placeholder="Link">
                     </div>
                  </div>
               </div>

            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group group-topic_id ">
                     <label for="chapter_id" class="col-sm-3 control-label">Order </label>
                     <div class="col-sm-9">
                        <input type="number" class="form-control" name="order" id="order" placeholder="Order">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group group-type ">
                     <label for="chapter_id" class="col-sm-3 control-label">Type </label>
                     <div class="col-sm-9">
                        <select class="form-control" name="type">
                           <option value="">Type </option>
                           <option value="banner">Banner</option>
                           <option value="left">Left Corner</option>
                           <option value="right">Right Corner</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group group-topic_id ">
                     <label for="chapter_id" class="col-sm-2 control-label">Description </label>
                     <div class="col-sm-9">
                        <textarea class="form-control" name="description" rows="2" cols="150"></textarea>
                     </div>
                  </div>
               </div>

            </div>

            <div class="row">
               <div class="col-md-12">
                  <div class="form-group group-materials ">
                     <label for="materials" class="col-sm-3 control-label">Image <i class="required">*</i>
                     </label>
                     <div class="col-sm-9">
                        <div id="sp_ad_image_galery"></div>
                        <input class="data_file" name="sp_ad_image_uuid" id="sp_ad_image_uuid" type="hidden" value="<?= set_value('sp_ad_image_uuid'); ?>">
                        <input class="data_file" name="sp_ad_image_name" id="sp_ad_image_name" type="hidden" value="<?= set_value('sp_ad_image_name'); ?>">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer pr-5p">
            <button class="btn  btn-primary btn_save  btn_action " id="btn_save" data-stype='stay'> <?= cclang('save'); ?>
               <button type="button" class="btn   btn-close" data-dismiss="modal">Close</button>
         </div>
         <?= form_close(); ?>

      </div>
   </div>

</div>
<script>
   var module_name = "sp_ad"
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



      $(document).on('click', '#apply', function() {

         var bulk = $('#bulk');
         var serialize_bulk = $('#form_sp_ad').serialize();

         if (bulk.val() == 'delete') {
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
                     document.location.href = ADMIN_BASE_URL + '/sp_ad/delete?' + serialize_bulk;
                  }
               });

            return false;

         } else if (bulk.val() == '') {
            swal({
               title: "Upss",
               text: "<?= cclang('please_choose_bulk_action_first'); ?>",
               type: "warning",
               showCancelButton: false,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Okay!",
               closeOnConfirm: true,
               closeOnCancel: true
            });

            return false;
         }

         return false;

      }); /*end appliy click*/

      $('.btn_save').click(function() {
         $('.message').fadeOut();

         var form_sp_ad = $('#form_sp_ad_add');
         var data_post = form_sp_ad.serializeArray();
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
               url: ADMIN_BASE_URL + '/sp_ad/add_save',
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

               } else {
                  showValidationMessage(`${res.message}`);
               }

               if (use_ajax_crud == true) {

                  var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_ad/index/?ajax=1'
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
      var params = {};
      params[csrf] = token;

      $('#sp_ad_image_galery').fineUploader({
         template: 'qq-template-gallery',
         request: {
            endpoint: ADMIN_BASE_URL + '/sp_ad/upload_image_file',
            params: params
         },
         deleteFile: {
            enabled: true,
            endpoint: ADMIN_BASE_URL + '/sp_ad/delete_image_file',
         },
         thumbnails: {
            placeholders: {
               waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
               notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
            }
         },
         multiple: false,
         validation: {
            allowedExtensions: ["*"],
            sizeLimit: 0,
         },
         showMessage: function(msg) {
            toastr['error'](msg);
         },
         callbacks: {
            onComplete: function(id, name, xhr) {
               if (xhr.success) {
                  var uuid = $('#sp_ad_image_galery').fineUploader('getUuid', id);
                  $('#sp_ad_image_uuid').val(uuid);
                  $('#sp_ad_image_name').val(xhr.uploadName);
               } else {
                  toastr['error'](xhr.error);
               }
            },
            onSubmit: function(id, name) {
               var uuid = $('#sp_ad_image_uuid').val();
               $.get(ADMIN_BASE_URL + '/sp_ad/delete_image_file/' + uuid);
            },
            onDeleteComplete: function(id, xhr, isError) {
               if (isError == false) {
                  $('#sp_ad_image_uuid').val('');
                  $('#sp_ad_image_name').val('');
               }
            }
         }
      }); /*end image galery*/


      //check all
      var checkAll = $('#check_all');
      var checkboxes = $('input.check');

      checkAll.on('ifChecked ifUnchecked', function(event) {
         if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
         } else {
            checkboxes.iCheck('uncheck');
         }
      });

      checkboxes.on('ifChanged', function(event) {
         if (checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
         } else {
            checkAll.removeProp('checked');
         }
         checkAll.iCheck('update');
      });
      initSortableAjax('sp_ad', $('table.dataTable'));
   }); /*end doc ready*/
</script>