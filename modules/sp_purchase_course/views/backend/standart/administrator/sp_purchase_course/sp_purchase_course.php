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
    Purchase Course </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=""><a href="<?= admin_site_url('/sp_purchase_course'); ?>">Purchase Course</a></li>
    <li class="active"><?= cclang('detail'); ?></li>
  </ol>
</section>
<section class="content">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-body ">

          <div class="box box-widget widget-user-2">
            <div class="form-horizontal form-step" name="form_sp_mcq_question" id="form_sp_mcq_question">
              <?= form_open('', [
                'name' => 'form_sp_purchase_course',
                'class' => 'form-horizontal form-step',
                'id' => 'form_sp_purchase_course',
                'enctype' => 'multipart/form-data',
                'method' => 'POST'
              ]); ?>

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
                        $courses = $this->model_sp_mcq_exam->getCourseByTeacher(@$filter['teacher']);
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
                      <th data-field="creator_name" data-sort="1" data-primary-key="0"> Creater Name</th>
                      <th data-field="amount" data-sort="1" data-primary-key="0"> Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($course_list as $res) {?>
                      <tr>
                        <td><?php echo ++$offset; ?></td>
                        <td><?php echo $res->course_name; ?></td>
                        <td><?php echo $res->full_name; ?></td>
                        <td><?php echo $res->amount; ?></td>
                        <?php $encrypted_id = encrypt_string($res->id) ?>
                        <td> <a href="#" class="btn btn-flat btn-success btn_add_new"><i class="fa fa-cart-plus"></i> <?= cclang('buy')  ?> </a></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <?= form_close(); ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>