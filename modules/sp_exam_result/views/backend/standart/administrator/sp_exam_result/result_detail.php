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
    Result Detail </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=""><a href="<?= admin_site_url('/sp_exam_result/result_detail/' . $exam_id); ?>">Result Detail</a></li>
    <li class="active"><?= cclang('detail'); ?></li>
  </ol>
</section>
<section class="content">
  <div class="row">

    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-body ">

          <div class="box box-widget widget-user-2">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group ">
                  <label for="content" class="col-sm-3 control-label">Course: </label>

                  <div class="col-sm-9">
                    <?php echo $exam_detail->course_name; ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group ">
                  <label for="content" class="col-sm-5 control-label">Creator Name: </label>

                  <div class="col-sm-7">
                    <span class="detail_group-no_of_options"><?= _ent($exam_detail->full_name); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-horizontal form-step" name="form_sp_mcq_question" id="form_sp_mcq_question">

              <div class="table-responsive">

                <br>
                <table class="table table-bordered table-striped dataTable">
                  <thead>
                    <tr class="">
                      <th data-field="sn" data-sort="1" data-primary-key="0"> <?= cclang('sn') ?></th>
                      <th data-field="course_id" data-sort="1" data-primary-key="0"> Exam Date</th>
                      <th data-field="creator_name" data-sort="1" data-primary-key="0"> Start Time</th>
                      <th data-field="amount" data-sort="1" data-primary-key="0"> Submitted Time</th>
                      <th>Time Taken</th>
                      <th>Total Question</th>
                      <th>Score</th>
                      <th>Rank</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $sn = 0;
                    foreach ($result_detail as $res) {
                      $rank = get_student_rank($res->exam_id, $user_id, $res->id);
                      $sn++; ?>
                      <tr>
                        <td><?php echo $sn; ?></td>
                        <td><?php echo $res->created_at; ?></td>
                        <td><?php echo $res->start_time; ?></td>
                        <td><?php echo $res->submitted_time; ?></td>
                        <td><?php echo $res->time_taken; ?></td>
                        <td><?php echo $exam_detail->total_questions; ?></td>
                        <td><?php echo $res->score; ?></td>
                        <td><?php echo $rank . ' / ' . $total_user ?> </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>