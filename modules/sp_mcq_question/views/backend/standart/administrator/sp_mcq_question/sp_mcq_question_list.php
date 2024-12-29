<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sq_mcq_question/add';
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
      <?= cclang('sq_mcq_question') ?><small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('sq_mcq_question') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
               <?php if (check_role_exist_or_not(13, array("add"))) { ?>
                  <a class="btn btn-flat btn-success btn_add_new pull-right" id="btn_add_new" title="<?= cclang('add_new_button', [cclang('sq_mcq_question')]); ?>  (Ctrl+a)" href="<?= admin_site_url('/sp_mcq_question/add'); ?>"><i class="fa fa-plus-square-o"></i> <?= cclang('sq_mcq_question'); ?></a>
                  <?php }?>
                  <form name="form_sq_mcq_question" id="form_sq_mcq_question" action="<?= admin_base_url('/sp_mcq_question/index'); ?>">



                     <!-- /.widget-user -->
                     <div class="row">
                        <div class="col-md-8">
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control chosen chosen-select board_id" name="board_id">
                                 <option value="">Board/University</option>
                                 <?php foreach (db_get_all_data('sp_board',['created_by'=>$user_id,'is_deleted'=>0]) as $row): ?>
                                    <option <?= $row->id == @$filter['board_id'] ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->name; ?></option>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control " name="course_id" id="course_id">
                                 <option value=""><?= cclang('course'); ?></option>
                                 <?php if (@$filter['course_id']) {
                                    $courses = get_courses(@$filter['board_id']);
                                    foreach ($courses as $course) { ?>
                                       <option <?= $course->id == @$filter['course_id'] ? 'selected' : ''; ?> value="<?php echo $course->id; ?>"><?php echo $course->name ?></option>
                                 <?php }
                                 } ?>
                              </select>
                           </div>
                           <div class="col-sm-3 padd-left-0 ">
                              <select type="text" class="form-control " name="chapter_id" id="chapter_id">
                                 <option value=""><?= cclang('chapter'); ?></option>
                                 <?php if (@$filter['chapter_id']) {
                                    $chapters = get_chapters(@$filter['course_id']);
                                    foreach ($chapters as $chapter) { ?>
                                       <option <?= $chapter->id == @$filter['chapter_id'] ? 'selected' : ''; ?> value="<?php echo $chapter->id; ?>"><?php echo $chapter->name ?></option>
                                 <?php }
                                 } ?>
                              </select>
                           </div>
                           <div class="col-sm-1 padd-left-0 ">
                              <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                           </div>
                           <div class="col-sm-1 padd-left-2 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_mcq_question'); ?>" title="<?= cclang('reset_filter'); ?>">
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
                                 <th data-field="id" data-sort="1" data-primary-key="0"> <?= cclang('sn') ?></th>
                                 <th data-field="course" data-sort="1" data-primary-key="0"><?= cclang('course') ?></th>
                                 <th data-field="chapter_id" data-sort="1" data-primary-key="0"> <?= cclang('chapter') ?></th>
                                 <th data-field="topic_id" data-sort="1" data-primary-key="0"> <?= cclang('topic') ?></th>
                                 <th data-field="no_of_options" data-sort="1" data-primary-key="0"> <?= cclang('options') ?></th>
                                 <th data-field="questions" data-sort="1" data-primary-key="0"> <?= cclang('questions') ?></th>
                                 <!-- <th>Set</th> -->
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody id="tbody_sq_mcq_question">
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
<script>
   var module_name = "sq_mcq_question"
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

      
      $('.publish_practise').click(function() {
			var id = $(this).data('id');
			Swal.fire({
				title: "Are you sure?",
				text: "You are Publishing to public !",
				icon: "warning",
				color: "red",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Publish",
				cancelButtonText: "Cancel",
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
                    url: BASE_URL + 'administrator/sp_mcq_question/publish_exam',
                    type: 'POST',
                    dataType: 'json',
                    data: {id:id},
                })
                .done(function(res) {
                    if (res.success) {
                        showStatusMessage('success', 'Success', res.message);
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 2000);
                    } else {
                        showValidationMessage(`${res.message}`);
                    }

                })
                .fail(function() {
                    showStatusMessage('error', 'Error', 'Error save data');
                })
                .always(function() {
                    $('.loading').hide();
                    $('.btn_save').prop("disabled", false);
                });
				} else {
					showStatusMessage('error', 'Error', 'Error occured :)');
				}
			});
			return false;

		});

      $('.board_id').change(function() {
         var board_id = $(this).val();
         if (board_id !== '') {

            $.ajax({
               type: 'GET',
               data: board_id,
               dataType: 'html',
               url: BASE_URL + 'administrator/sp_mcq_question/getCourseByUniversity/' + board_id,
               success: function(html) {
                  $('#course_id').html(html);
               }
            });
         }
      });

      $('#course_id').change(function() {
         $('#chapter_id').empty();
         var course_id = $(this).val();
         if (course_id !== '') {

            $.ajax({
               type: 'GET',
               data: course_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getChapter/' + course_id,
               success: function(html) {
                  $('#chapter_id').html(html);
               }
            });
         }
      });

      //  initSortableAjax('sq_mcq_question', $('table.dataTable'));
   }); /*end doc ready*/
</script>