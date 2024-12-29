<script type="text/javascript">
   function domo() {

      $('*').bind('keydown', 'Ctrl+a', function() {
         window.location.href = ADMIN_BASE_URL + '/sq_mcq_exam/add';
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
      MCQ Exam<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">MCQ Exam</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">
               <div class="box box-widget widget-user-2">
                  <!-- <div class="widget-user-header ">

                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username"><?= cclang('mcq_exam') ?></h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', [cclang('mcq_exam')]); ?> <i class="label bg-yellow"><span class="total-rows"></span> <?= cclang('items'); ?></i></h5>
                  </div> -->

                  <form name="form_sq_mcq_exam" id="form_sq_mcq_exam" action="<?= admin_base_url('/sp_mcq_exam/index'); ?>">



                     <!-- /.widget-user -->
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
                              <select class="form-control " name="course_id" id="course_id" data-placeholder="Course">
                                 <option value="">Course</option>
                                 <?php if(@$filter['course_id']){
                                    $courses =$this->model_sp_mcq_exam->getCourseByTeacher( @$filter['teacher']);
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
                           <div class="col-sm-1 padd-left-0 ">
                              <a class="btn btn-default btn-flat" name="reset" id="reset" value="Apply" href="<?= admin_base_url('/sp_mcq_exam'); ?>" title="<?= cclang('reset_filter'); ?>">
                                 <i class="fa fa-undo"></i>
                              </a>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate">
                              <!-- <div class="table-pagination"><?= $pagination; ?></div> -->
                           </div>
                        </div>
                     </div>
                     <div class="table-responsive">

                        <br>
                        <table class="table table-bordered table-striped dataTable">
                           <thead>
                              <tr class="">
                                 <th data-field="sn" data-sort="1" data-primary-key="0"> <?= cclang('sn') ?></th>
                                 <th data-field="course_id" data-sort="1" data-primary-key="0"> <?= cclang('course') ?></th>
                                 <th data-field="chapter_id" data-sort="1" data-primary-key="0"> No of Questions</th>
                                 <th data-field="full_marks" data-sort="1" data-primary-key="0"> Full Marks</th>
                                 <th data-field="pass_marks" data-sort="1" data-primary-key="0"> Pass Marks</th>
                                 <th data-field="time" data-sort="1" data-primary-key="0"> Time</th>
                                 <th>Set</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $sn = 0;
                              foreach ($results as $res) { 
                                 $sn++; ?>
                                 <tr>
                                    <td><?php echo $sn;?></td>
                                    <td><?php echo $res->course_name;?></td>
                                    <td><?php echo $res->total_questions;?></td>
                                    <td><?php echo $res->full_marks;?></td>
                                    <td><?php echo $res->pass_marks;?></td>
                                    <td><?php echo $res->time;?></td>
                                    <td></td>
                                    <?php $encrypted_id =encrypt_string($res->id)?>
                                    <td> <a  href="<?= admin_site_url('/sp_mcq_exam/start_exam/' . $encrypted_id); ?>" class="btn btn-flat btn-success btn_add_new"><i class="fa fa-book"></i> <?= cclang('start').' '.cclang('exam')?> </a></td>
                                 </tr>
                              <?php } ?>
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
<script>
   $(document).ready(function() {
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
         $('#topic_id').empty();
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
   }); /*end doc ready*/
</script>