<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_chapter/add';
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
      <?= cclang('sp_chapter') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('sp_chapter') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <!-- <a class="btn btn-flat btn-success btn_add_new pull-right" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('sp_chapter')]); ?>  (Ctrl+a)" href="<?= admin_site_url('/sp_chapter/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('sp_chapter'); ?></a> -->
                  <?php if (check_role_exist_or_not(10, array( "add"))) { ?>
                  <button type="button" class="btn btn-flat btn-success btn_add_new pull-right" data-toggle="modal" data-target="#new_chapter"><i class="fa fa-plus-square-o"></i> <?= cclang('sp_chapter'); ?></button>
                  <?php }?>
                  <form name="form_sp_chapter" id="form_sp_chapter" action="<?= admin_base_url('/sp_chapter/index'); ?>">



                     <!-- /.widget-user -->
                     <div class="row">
                        <div class="col-md-8">
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control chosen chosen-select board_id" name="board_id" >
                                 <option value="">Board/University</option>
                                 <?php foreach (db_get_all_data('sp_board',['created_by'=>$user_id,'is_deleted'=>0]) as $row): ?>
                                    <option <?= $row->id == @$filter['board_id'] ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                              <div class="col-sm-3 padd-left-0 ">
                                 <select type="text" class="form-control" name="course_id" id="param">
                                    <option value=""><?= cclang('course'); ?></option>
                                    <?php if(@$filter['course_id']){
                                    $courses =get_courses( @$filter['course_id']);
                                    foreach($courses as $course){?>
                                      <option <?= $course->id == @$filter['course_id'] ? 'selected' : ''; ?> value="<?php echo $course->id; ?>"><?php echo $course->name ?></option>
                                    <?php }}?>
                                 </select> 
                              </div>
                              <div class="col-sm-1 padd-left-0 ">
                                 <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                    Filter
                                 </button>
                              </div>
                              <div class="col-sm-1 padd-left-2 ">
                                 <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_chapter'); ?>" title="<?= cclang('reset_filter'); ?>">
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
                                    <!-- <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th> -->
                                    <th data-field="course_id" data-sort="1" data-primary-key="0"> <?= cclang('course_id') ?></th>
                                    <th data-field="name" data-sort="1" data-primary-key="0"> <?= cclang('name') ?></th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody id="tbody_sp_chapter">
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

<div id="new_chapter" class="modal fade new-july-design" role="dialog">

   <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Chapter</h4>
         </div>
         <div class="modal-body new-july-design">
            <?= form_open('', [
               'name' => 'form_sp_chapter_add',
               'class' => 'form-horizontal',
               'id' => 'form_sp_chapter_add',
               'enctype' => 'multipart/form-data',
               'method' => 'POST'
            ]); ?>
            <div class="form-group group-name ">
               <label for="name" class="col-sm-3 control-label">Course <i class="required">*</i>
               </label>
               <div class="col-sm-8">
                  <select class="form-control chosen chosen-select-deselect" name="course_id" id="course" data-placeholder="Select Course">
                     <option value=""></option>
                     <?php
                     $conditions = ['created_by'=>$user_id,'is_deleted'=>0];  ?>

                     <?php foreach (db_get_all_data('sp_course', $conditions) as $row): ?>
                        <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                     <?php endforeach; ?>
                  </select>
                  <small class="info help-block">
                  </small>
               </div>
            </div>
            <div class="dt-responsive table-responsive" style="padding-left:15px; padding-right:15px; ">
               <table id="ledger_table" class="table table-striped table-bordered nowrap">
                  <thead>
                     <tr>
                        <th>Chapter Name</th>
                        <th width="20%">Action</th>
                     </tr>
                  </thead>
                  <tbody id="chapter_table">
                  </tbody>
               </table>
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
   var module_name = "sp_chapter"
   var use_ajax_crud = false
</script>
<!-- <script src="<?= BASE_ASSET ?>js/filter.js"></script> -->


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


      $('.btn_add_new').on('click', function() {
         $("#chapter_table").append(chapterRow());
      });
      $("#chapter_table").on('keyup', '.lst ', function(e) {
         var code = (e.keyCode ? e.keyCode : e.which);
         if (code == 13) {
            $("#chapter_table").append(chapterRow());
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

         var form_sp_course = $('#form_sp_chapter_add');
         var data_post = form_sp_course.serializeArray();
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
               url: ADMIN_BASE_URL + '/sp_chapter/add_save',
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

                  var url = BASE_URL + ADMIN_NAMESPACE_URL + '/sp_chapter/index/?ajax=1'
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

      $('.board_id').change(function() {
         $('#param').empty();
         var board_id = $(this).val();
         if (board_id !== '') {

            $.ajax({
               type: 'GET',
               data:board_id,
               dataType: 'html',
               url: BASE_URL + 'administrator/sp_mcq_question/getCourseByUniversity/' + board_id,
               success: function(html) {
                  $('#param').html(html);
               }
            });
         }
      });
      
      // initSortableAjax('sp_chapter', $('table.dataTable'));
   }); /*end doc ready*/

   function chapterRow() {

      var totalRows = $('#chapter_table tr').length;
      var count = totalRows + 1;
      var html = '<tr>';
      html += '<td><input type="text" class="form-control inputs lst" name="name[]"  /></td>';
      if (totalRows > 0) {
         html += `<td class="">
<button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fa fa-minus"></i></button>
</td>`;
      } else {
         html += `<td class="text-right">Enter for Next
</td>`;
      }
      html += `</tr>`;
      return html;

   }
</script>