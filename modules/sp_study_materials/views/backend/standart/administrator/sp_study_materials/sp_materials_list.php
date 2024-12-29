<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/Sp_materials/add';
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
      <?= cclang('sp_materials') ?>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?= cclang('sp_materials') ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <form name="form_sp_materials" id="form_sp_materials" action="<?= admin_base_url('sp_study_materials'); ?>">
            
                     <div class="row">
                        <div class="col-md-10">
                           <div class="col-sm-2 padd-left-0 ">
                           <select class="form-control chosen chosen-select" name="teacher" id="teacher" data-placeholder="Teacher">
                                 <option value="">Teacher</option>
                                 <?php foreach ($teachers as $teacher) { ?>
                                    <option <?= $teacher->id == @$filter['teacher'] ? 'selected' : ''; ?> value="<?php echo $teacher->id; ?>"><?php echo $teacher->full_name ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="col-sm-2 padd-left-0 ">
                              <select type="text" class="form-control " name="course_id" id="course_id">
                                 <option value=""><?= cclang('course'); ?></option>
                                 <?php if (@$filter['course_id']) {
                                      $courses =$this->model_sp_study_materials->getCourseByTeacher( @$filter['teacher']);
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
                           <div class="col-sm-2 padd-left-0 ">
                              <select class="form-control " name="topic_id" id="topic_id" data-placeholder="Select Topic">
                                 <option value=""><?= cclang('topic'); ?></option>
                                 <?php if(@$filter['topic_id']){
                                    $topics =get_topics( @$filter['chapter_id']);
                                    foreach($topics as $topic){?>
                                      <option <?= $topic->id == @$filter['topic_id'] ? 'selected' : ''; ?> value="<?php echo $topic->id; ?>"><?php echo $topic->name ?></option>
                                    <?php }}?>
                              </select>
                           </div>
                           <div class="col-sm-1 padd-left-0 ">
                              <button type="submit" class="btn btn-flat" name="sbtn" id="sbtn" value="Apply" title="<?= cclang('filter_search'); ?>">
                                 Filter
                              </button>
                           </div>
                           <div class="col-sm-1 padd-left-2 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_study_materials'); ?>" title="<?= cclang('reset_filter'); ?>">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>
                     </div>
                  </form>
                  <div class="table-responsive">

                     <br>
                     <table class="table table-bordered table-striped dataTable">
                        <thead>
                           <tr class="">
                              <!-- <th>
                                    <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
                                 </th> -->
                              <th data-field="course_id" data-sort="1" data-primary-key="0"> <?= cclang('course') ?></th>
                              <th data-field="chapter_id" data-sort="1" data-primary-key="0"> <?= cclang('chapter') ?></th>
                              <th data-field="topic_id" data-sort="1" data-primary-key="0"> <?= cclang('topic') ?></th>
                              <th data-field="materials" data-sort="1" data-primary-key="0"> <?= cclang('materials') ?></th>
                           </tr>
                        </thead>
                        <tbody id="tbody_sp_materials">
                           <?= $tables ?>
                        </tbody>
                     </table>
                  </div>
               </div>
               <hr>

            </div>
            </form>
         </div>
      </div>
   </div>
</section>

<!-- <script>
   var module_name = "sp_materials"
   var use_ajax_crud = false
</script>
<script src="<?= BASE_ASSET ?>js/filter.js"></script> -->


<script>
   $(document).ready(function() {

      "use strict";



      // if (use_ajax_crud == false) {

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
      // }



      $(document).on('click', '#apply', function() {

         var bulk = $('#bulk');
         var serialize_bulk = $('#form_sp_materials').serialize();

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
                     document.location.href = ADMIN_BASE_URL + '/sp_materials/delete?' + serialize_bulk;
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

      $('#teacher').change(function() {
         $('#chapter_id').empty();
         $('#topic_id').empty();
         var teacher = $(this).val();
         if (teacher !== '') {

            $.ajax({
               type: 'GET',
               data:teacher,
               dataType: 'html',
               url: BASE_URL + 'administrator/sp_mcq_practise/getCourse/' + teacher,
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

      $('#chapter_id').change(function() {
         $('#topic_id').empty();
         var chapter_id = $(this).val();
         if (chapter_id !== '') {

            $.ajax({
               type: 'GET',
               data: chapter_id,
               dataType: 'html',
               url: BASE_URL + '/administrator/sp_mcq_question/getTopic/' + chapter_id,
               success: function(html) {
                  $('#topic_id').html(html);
               }
            });

         }
      });

      // initSortableAjax('sp_materials', $('table.dataTable'));
   }); /*end doc ready*/
</script>