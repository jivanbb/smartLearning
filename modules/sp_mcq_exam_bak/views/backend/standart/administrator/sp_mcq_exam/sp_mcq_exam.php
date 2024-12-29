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
            <!-- <div class="widget-user-header ">
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <h3 class="widget-user-username">Sq Mcq Question</h3>
                     <h5 class="widget-user-desc">Detail Sq Mcq Question</h5>
                     <hr>
                  </div> -->


            <div class="form-horizontal form-step" name="form_sp_mcq_question" id="form_sp_mcq_question">
              <div class="row app">

                  <div id="result" class="quiz-body">
                    <form name="quizForm" onSubmit="">
                      <fieldset class="form-group">
                        <h4><span id="qid">1.</span> <span id="question"></span></h4>
                        <div class="option-block-container" id="question-options">
                        </div> <!-- End of option block -->
                      </fieldset>
                      <button name="previous" id="previous" class="btn btn-success">Previous</button>
                      &nbsp;
                      <button name="next" id="next" class="btn btn-success">Next</button>
                      <!-- <p id="timer">Time Left: <span id="countdown"></span> S</p> -->
                    </form>
                  </div>
               

              </div>



            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  const quiz = <?php echo $questions; ?>;
  const countdownElement = document.getElementById("countdown");
    var quizApp = function () {
    this.score = 0;
    this.qno = 1;
    this.currentque = 0;
    var totalque = quiz.length;
    this.displayQuiz = function (cque) {
    this.currentque = cque;
    if (this.currentque < totalque) {
    $("#tque").html(totalque);
    $("#previous").attr("disabled", false);
    $("#next").attr("disabled", false);
    $("#qid").html(quiz[this.currentque].id + '.');
    $("#question").html(quiz[this.currentque].question);
    $("#question-options").html("");
    for (var key in quiz[this.currentque].options[0]) {
    if (quiz[this.currentque].options[0].hasOwnProperty(key)) {
    $("#question-options").append(
    "<div class='form-check option-block'>" +
    "<label class='form-check-label'>" +
    "<input type='radio' class='form-check-input' name='option' id='q" + key + "' value='" + quiz[this.currentque].options[0][key] + "'>&nbsp;&nbsp;<span id='optionval'>" +
    quiz[this.currentque].options[0][key] +
    "</span></label>"
    );
    }
    }
    }
    if (this.currentque <= 0) {
    $("#previous").attr("disabled", true);
    }
    if (this.currentque >= totalque) {
    $('#next').attr('disabled', true);
    for (var i = 0; i < totalque; i++) {
    this.score = this.score + quiz[i].score;
    }
    return this.showResult(this.score);
    }
    }
    this.showResult = function (scr) {
      var total_marks =totalque * <?php echo $question_mark; ?>;
    $("#result").addClass('result');
    $("#result").html("<h1 class='res-header'>Total Score: &nbsp;" + scr + '/' + total_marks + "</h1>");
    for (var j = 0; j < totalque; j++) {
    var res;
    if (quiz[j].score == 0) {
    res = '<span class="wrong">' + quiz[j].score + '</span><i class="fa fa-remove c-wrong"></i>';
    } else {
    res = '<span class="correct">' + quiz[j].score + '</span><i class="fa fa-check c-correct"></i>';
    }
    $("#result").append(
    '<div class="result-question"><span>Q ' + quiz[j].id + '</span> &nbsp;' + quiz[j].question + '</div>' +
    '<div><b>Correct answer:</b> &nbsp;' + quiz[j].answer + '</div>' +
    '<div class="last-row"><b>Score:</b> &nbsp;' + res +
    '</div>'
    );
    }
    }
    this.checkAnswer = function (option) {
    var answer = quiz[this.currentque].answer;
    option = option.replace(/</g, "&lt;") //for <
    option = option.replace(/>/g, "&gt;") //for >
    option = option.replace(/"/g, "&quot;")
    if (option == quiz[this.currentque].answer) {
    if (quiz[this.currentque].score == "") {
    quiz[this.currentque].score =  <?php echo $question_mark; ?>;
    quiz[this.currentque].status = "correct";
    }
    } else {
    quiz[this.currentque].status = "wrong";
    }
    }
    this.changeQuestion = function (cque) {
    this.currentque = this.currentque + cque;
    this.displayQuiz(this.currentque);
    }
    }
    var jsq = new quizApp();
    var selectedopt;
    $(document).ready(function () {
    jsq.displayQuiz(0);
    $('#question-options').on('change', 'input[type=radio][name=option]', function (e) {
    //var radio = $(this).find('input:radio');
    $(this).prop("checked", true);
    selectedopt = $(this).val();
    });
    });
    $('#next').click(function (e) {
    e.preventDefault();
    if (selectedopt) {
    jsq.checkAnswer(selectedopt);
    }
    jsq.changeQuestion(1);
    });
    $('#previous').click(function (e) {
    e.preventDefault();
    if (selectedopt) {
    jsq.checkAnswer(selectedopt);
    }
    jsq.changeQuestion(-1);
    });
</script>