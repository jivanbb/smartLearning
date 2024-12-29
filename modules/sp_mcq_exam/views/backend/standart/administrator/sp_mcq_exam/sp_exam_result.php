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
    MCQ Exam </h1>
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
            <div class="form-horizontal form-step" name="form_sp_mcq_question" id="form_sp_mcq_question">
              <div class="row">
                <form id="form_sp_user_exam">
                  <div class="col-md-9">
                    <div class="row">
                      <div class="col-md-9">
                        <h3><?php echo $exam_detail->course_name; ?></h3>
                      </div>
                      <div class="col-md-3">
                        <button> <a href="<?= admin_site_url('/sp_mcq_exam/exam_result_detail/' . $id); ?>" class="btn btn-flat ">View Exam Details </a></button>
                      </div>
                    </div>
                    <?php $wrong_ans = json_decode($exam_detail->wrong_ans);
                    $correct_ans = json_decode($exam_detail->correct_ans);
                    $not_ans = json_decode($exam_detail->not_ans);
                    $questions = json_decode($exam_detail->questions);
                    ?>
                    <div class="row">
                      <div class="col-md-12" style="display: flex;">
                        <input type="text" class="form-control correct index_button">Correct:<?php echo $exam_detail->correct; ?>
                        <input type="text" class="form-control wrong index_button">Wrong:<?php echo $exam_detail->wrong; ?>
                        <input type="text" class="form-control not_answered index_button">Not Answered:<?php echo $exam_detail->not_answered; ?>
                      </div>

                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-12">
                        <?php $sn = 0;
                        foreach ($questions  as $question) {
                          $question_detail = get_qustion_detail($question);
                          $result = getButtonClass($question, $correct_ans, $wrong_ans, $not_ans);
                          if ($result == "correct") {
                            $ans = "Correct";
                          } elseif ($result == "wrong") {
                            $res = get_wrong_ans_detail($id, $question);
                            $ans = $res->ans;
                          } else {
                            $ans = "Not Answered";
                          }
                          $sn++; ?>
                          <button class="question-button <?php echo getButtonClass($question, $correct_ans, $wrong_ans, $not_ans); ?>" data-toggle="modal"
                          data-ans="<?php echo $ans;?>" data-correct="<?php echo $question_detail->correct_option;?>"  data-question_name="<?= _ent($sn . ')' . strip_tags(html_entity_decode($question_detail->question))); ?>" data-option_1="<?= _ent($question_detail->option_1); ?>" data-option_2="<?= _ent($question_detail->option_2); ?>"
                            data-option_3="<?= _ent($question_detail->option_3); ?>" data-option_4="<?= _ent($question_detail->option_4); ?>" data-no_of_options="<?= _ent($question_detail->no_of_options); ?>"><?php echo $sn; ?></button>
                        <?php } ?>
                      </div>

                    </div>

                  </div>
                  <div class="col-md-3">
                    <div class="">
                      <h3><strong>Your Rank <?php echo $rank ?>/<?php echo $total_user; ?></h3>.</strong>

                    </div>
                    <div id="button_container"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="exam_modal" class="modal fade new-july-design" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Question Detail</h4>
      </div>
      <div class="modal-body new-july-design">
        <div><span class="question_detail"></span></div>
        <div id="option1"><input type="radio" id="option_1"> <span class="option_1"></span></div>
        <div id="option2"><input type="radio" id="option_2"> <span class="option_2"></span></div>
        <div id="option3"><input type="radio" id="option_3"> <span class="option_3"></span></div>
        <div id="option4"><input type="radio" id="option_4"> <span class="option_4"></span></div>
      </div>
      <div style="margin-left: 10px;">Your Answer:<span class="your_answer"></span></div>
      <div class="modal-footer pr-5p">
        <button type="button" class="btn   btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

</div>

<?php function getButtonClass($questionNumber, $correctAnswers, $wrongAnswers, $notAnswered)
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
<script>
  $(document).ready(function() {
    const examModal = document.getElementById('exam_modal');
    $('#form_sp_user_exam').on('click', '.question-button', function(e) {
      e.preventDefault();
      $('#option_1').prop('checked', false);
      $('#option_2').prop('checked', false);
      $('#option_3').prop('checked', false);
      $('#option_4').prop('checked', false);
      var correct =  $(this).data('correct');
      if(correct ==1){
        $('#option_1').prop('checked', true);
      }else if(correct ==2){
        $('#option_2').prop('checked', true);
      }else if(correct ==3){
        $('#option_3').prop('checked', true);
      }else if(correct ==4){
        $('#option_4').prop('checked', true);
      }else{}
      examModal.querySelector('.question_detail').innerText = $(this).data('question_name');
      examModal.querySelector('.option_1').innerText = $(this).data('option_1');
      examModal.querySelector('.option_2').innerText = $(this).data('option_2');
      examModal.querySelector('.option_3').innerText = $(this).data('option_3');
      examModal.querySelector('.option_4').innerText = $(this).data('option_4');
      examModal.querySelector('.your_answer').innerText = $(this).data('ans');
      $('#exam_modal').modal('show');
    });

  });
</script>