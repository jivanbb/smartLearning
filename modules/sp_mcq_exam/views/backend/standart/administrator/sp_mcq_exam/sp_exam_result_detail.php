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
      MCQ Exam
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a href="<?= admin_site_url('/sp_mcq_exam'); ?>">MCQ Exam</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<section class="content">
   <div class="row">

      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <div class="box box-widget widget-user-2">

                  <div class="form-horizontal form-step" name="form_data" id="form_sp_mcq_question">
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-3 control-label">Course: </label>

                              <div class="col-sm-9">
                                 <?php echo $exam_detail->course_name; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-7 control-label">No of Question: </label>

                              <div class="col-sm-5">
                                 <?php echo $exam_detail->total_questions; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-7 control-label">Full Marks: </label>

                              <div class="col-sm-5">
                                 <?php echo $exam_detail->full_marks; ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="form-group ">
                              <label for="content" class="col-sm-7 control-label">Pass Marks: </label>

                              <div class="col-sm-5">
                                 <span class="detail_group-no_of_options"><?= _ent($exam_detail->pass_marks); ?></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <?php $sn = 0;
                        $question_detail =  json_decode($exam_detail->questions);
                        $correct_ans = json_decode($exam_detail->correct_ans);
                        $wrong_ans = json_decode($exam_detail->wrong_ans);
                        $not_ans = json_decode($exam_detail->not_ans);
                        foreach ($question_detail as $data) {
                           $detail = get_qustion_detail($data);
                           $ans_detail =   getAnswer_detail($data, $correct_ans, $wrong_ans, $not_ans);
                           $sn++; ?>
                           <div class="col-md-12">
                              <table>
                                 <tbody>
                                    <tr>
                                       <td><?php echo $sn . ')  '; ?></td>
                                       <td colspan="2"><?php echo $detail->question; ?></td>
                                    </tr>
                                    <tr>
                                       <td></td>
                                       <td>
                                          <p class="options-para"><input type="radio" <?php if ($detail->correct_option == 1) {
                                                                                          echo "checked";
                                                                                       } ?>> <?php echo $detail->option_1; ?></p>
                                       </td>
                                    </tr>
                                    <?php if ($detail->no_of_options == 2 || $detail->no_of_options == 3 || $detail->no_of_options == 4) { ?>
                                       <tr>
                                          <td></td>
                                          <td>
                                             <p class="options-para"><input type="radio" <?php if ($detail->correct_option == 2) {
                                                                                             echo "checked";
                                                                                          } ?>> <?php echo $detail->option_2; ?></p>
                                          </td>
                                       </tr>
                                    <?php } ?>
                                    <?php if ($detail->no_of_options == 3 || $detail->no_of_options == 4) { ?>
                                       <tr>
                                          <td></td>
                                          <td>
                                             <p class="options-para"><input type="radio" <?php if ($detail->correct_option == 3) {
                                                                                             echo "checked";
                                                                                          } ?>> <?php echo $detail->option_3; ?></p>
                                          </td>
                                       </tr>
                                    <?php } ?>
                                    <?php if ($detail->no_of_options == 4) { ?>
                                       <tr>
                                          <td></td>
                                          <td>
                                             <p class="options-para"><input type="radio" <?php if ($detail->correct_option == 4) {
                                                                                             echo "checked";
                                                                                          } ?>> <?php echo $detail->option_4; ?></p>
                                          </td>
                                       </tr>

                                    <?php } ?>
                                    <tr>
                                       <td>Your Answer:</td>
                                       <td><?php if ($ans_detail == "correct") {
                                           echo "correct";
                                                         } elseif ($ans_detail == "wrong") {
                                                            $res = get_wrong_ans_detail($id,$data);
                                                            echo $res->ans;
                                                         } elseif ($ans_detail == "not_answered") {
                                                            echo "Not Answered";
                                                         } else {
                                                         } ?> </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                           <hr>
                        <?php } ?>


                     </div>


                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php function getAnswer_detail($questionNumber, $correctAnswers, $wrongAnswers, $notAnswered)
{
   if (in_array($questionNumber, $correctAnswers)) {
      return 'correct';
   } elseif (in_array($questionNumber, $wrongAnswers)) {
      return 'wrong';
   } elseif (in_array($questionNumber, $notAnswered)) {
      return 'not_answered';
   }
   return '';
} ?>