<script type="text/javascript">
  function domo() {
    $('*').bind('keydown', 'Ctrl+e', function() {
      $('#btn_edit').trigger('click');
      return false;
    });

    $('*').bind('keydown', 'Ctrl+x', function() {
      $('#btn_back').trigger('click');
      return false;
    });
  }

  jQuery(document).ready(domo);
</script>
<section class="content-header">
  <h1>
    Exam Result </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=""><a href="<?= admin_site_url('/sp_exam_result'); ?>">Exam Result</a></li>
    <li class="active"><?= cclang('detail'); ?></li>
  </ol>
</section>
<section class="content">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-body ">

          <div class="box box-widget widget-user-2">
            <form  name="form_sp_exam_result" id="form_sp_mcq_question" action="<?= admin_base_url('sp_exam_result/index'); ?>">


              <div class="row">
                <div class="col-md-8">
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
                      <?php if (@$filter['course_id']) {
                        $courses = get_teacher_course(@$filter['teacher']);
                        foreach ($courses as $course) { ?>
                          <option <?= $course->id == @$filter['course_id'] ? 'selected' : ''; ?> value="<?php echo $course->id; ?>"><?php echo $course->name ?></option>
                      <?php }
                      } ?>
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
                    <div class="table-pagination"><?= $pagination; ?></div>
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
                      <th data-field="creator_name" data-sort="1" data-primary-key="0"> Full Marks</th>
                      <th data-field="amount" data-sort="1" data-primary-key="0"> Attempts</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($exam_list as $res) {
                      $attempts = get_exam_attempts($user_id, $res->exam_id); ?>
                      <tr>
                        <td><?php echo ++$offset; ?></td>
                        <td><?php echo $res->course_name; ?></td>
                        <td><?php echo $res->full_marks; ?></td>
                        <td><?php echo $attempts; ?></td>
                        <td><a href="<?= admin_site_url('/sp_exam_result/result_detail/' . $res->exam_id); ?>"><i class="fa fa-eye"></i> </a> </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
                    </form>
          </div>
        </div>
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
          data: teacher,
          dataType: 'html',
          url: BASE_URL + '/administrator/sp_mcq_practise/getCourse/' + teacher,
          success: function(html) {
            $('#course_id').html(html);
          }
        });
      }
    });
  });
</script>