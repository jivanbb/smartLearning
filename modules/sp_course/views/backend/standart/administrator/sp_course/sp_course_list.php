<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_course/add';
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
      <?= cclang('sp_course') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('sp_course') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <?php if (check_role_exist_or_not(9, array("add"))) { ?>
                     <button type="button" class="btn btn-flat btn-success btn_add_new pull-right" data-toggle="modal" data-target="#new_course"><i class="fa fa-plus-square-o"></i> <?= cclang('sp_course'); ?></button>
                  <?php } ?>
                  <form name="form_sp_course" id="form_sp_course" action="<?= admin_base_url('/sp_course/index'); ?>">



                     <!-- /.widget-user -->
                     <div class="row">
                        <div class="col-md-8">
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control chosen chosen-select" name="board_id" id="param">
                                 <option value=""><?= cclang('board'); ?></option>
                                 <?php foreach (db_get_all_data('sp_board', ['created_by' => $user_id, 'is_deleted' => 0]) as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                 <?php endforeach; ?>
                              </select>
                              <input type="hidden" name="q" id="filter" value="<?= $this->input->get('q'); ?>">
                              <input type="hidden" name="f" id="field" value="<?= $this->input->get('f'); ?>">
                           </div>
                           <div class="col-sm-1 padd-left-0 ">
                              <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                           </div>
                           <div class="col-sm-1 padd-left-2 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_course'); ?>" title="<?= cclang('reset_filter'); ?>">
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
                                 <!-- <th data-field="id"data-sort="1" data-primary-key="0"> <?= cclang('id') ?></th> -->
                                 <th data-field="board_university" data-sort="1" data-primary-key="0"> <?= cclang('board_university') ?></th>
                                 <th data-field="name" data-sort="1" data-primary-key="0"> <?= cclang('name') ?></th>
                                 <th>Amount</th>
                                 <th>Valid Days</th>
                                 <th>Image</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_sp_course">
                              <?= $tables ?>
                           </tbody>
                        </table>
                     </div>
               </div>
               <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                  <div class="table-pagination"><?= $pagination; ?></div>
               </div>
            </div>
            </form>
         </div>
      </div>
   </div>
</section>

<div id="new_course" class="modal fade new-july-design" role="dialog">

   <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Course</h4>
         </div>
         <div class="modal-body new-july-design">
            <?= form_open('', [
               'name' => 'form_sp_course_add',
               'class' => 'form-horizontal',
               'id' => 'form_sp_course_add',
               'enctype' => 'multipart/form-data',
               'method' => 'POST'
            ]); ?>
            <div class="form-group group-name ">
               <label for="name" class="col-sm-3 control-label">Board/University <i class="required">*</i>
               </label>
               <div class="col-sm-8">
                  <select class="form-control chosen chosen-select-deselect" name="board_university" id="board_university" data-placeholder="Select Board/University">
                     <option value=""></option>
                     <?php $conditions = ['created_by' => $user_id, 'is_deleted' => 0];  ?>
                     <?php foreach (db_get_all_data('sp_board', $conditions) as $row): ?>
                        <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <small class="info help-block">
                  </small>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group group-course_id ">
                     <label for="course_id" class="col-sm-4 control-label">Amount<i class="required">*</i>
                     </label>
                     <div class="col-sm-8">
                        <input type="text" class="form-control" name="amount" placeholder="Amount">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group group-course_id ">
                     <label for="course_id" class="col-sm-5 control-label">Valid Days <i class="required">*</i>
                     </label>
                     <div class="col-sm-7">
                        <input type="number" class="form-control" name="valid_days" placeholder="Valid Days">
                     </div>
                  </div>
               </div>
            </div>
            <div class="dt-responsive table-responsive" style="padding-left:15px; padding-right:15px; ">
               <table id="ledger_table" class="table table-striped table-bordered nowrap">
                  <thead>
                     <tr>
                        <th>Course Name</th>
                        <th width="5%">Action</th>
                     </tr>
                  </thead>
                  <tbody id="course_table">
                  </tbody>
               </table>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group group-image ">
                     <label for="image" class="col-sm-3 control-label">Image <i class="required">*</i>
                     </label>
                     <div class="col-sm-9">
                        <div id="sp_course_image_galery"></div>
                        <input class="data_file" name="sp_course_image_uuid" id="sp_course_image_uuid" type="hidden" value="<?= set_value('sp_course_image_uuid'); ?>">
                        <input class="data_file" name="sp_course_image_name" id="sp_course_image_name" type="hidden" value="<?= set_value('sp_course_image_name'); ?>">
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
   var module_name = "sp_course"
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


      initSortableAjax('sp_course', $('table.dataTable'));
      $('.btn_add_new').on('click', function() {
         $("#course_table").append(courseRow());
      });
      $("#course_table").on('keyup', '.lst ', function(e) {
         var code = (e.keyCode ? e.keyCode : e.which);
         if (code == 13) {
            $("#course_table").append(courseRow());
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

         var form_sp_course = $('#form_sp_course_add');
         var data_post = form_sp_course.serializeArray();
         $('.loading').show();

         $.ajax({
               url: ADMIN_BASE_URL + '/sp_course/add_save',
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
                  showValidationMessage(`${res.message}`);
               }

               if (use_ajax_crud == true) {

                  var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_course/index/?ajax=1'
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

      $('#sp_course_image_galery').fineUploader({
         template: 'qq-template-gallery',
         request: {
            endpoint: ADMIN_BASE_URL + '/sp_course/upload_image_file',
            params: params
         },
         deleteFile: {
            enabled: true,
            endpoint: ADMIN_BASE_URL + '/sp_course/delete_image_file',
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
                  var uuid = $('#sp_course_image_galery').fineUploader('getUuid', id);
                  $('#sp_course_image_uuid').val(uuid);
                  $('#sp_course_image_name').val(xhr.uploadName);
               } else {
                  toastr['error'](xhr.error);
               }
            },
            onSubmit: function(id, name) {
               var uuid = $('#sp_course_image_uuid').val();
               $.get(ADMIN_BASE_URL + '/sp_course/delete_image_file/' + uuid);
            },
            onDeleteComplete: function(id, xhr, isError) {
               if (isError == false) {
                  $('#sp_course_image_uuid').val('');
                  $('#sp_course_image_name').val('');
               }
            }
         }
      }); /*end image galery*/



   }); /*end doc ready*/

   function courseRow() {

      var totalRows = $('#course_table tr').length;
      var count = totalRows + 1;
      var html = '<tr>';
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