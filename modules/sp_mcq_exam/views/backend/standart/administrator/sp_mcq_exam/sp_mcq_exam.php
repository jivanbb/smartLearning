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
                <?= form_open('', [
                  'name' => 'form_sp_user_exam',
                  'class' => 'form-horizontal form-step',
                  'id' => 'form_sp_user_exam',
                  'enctype' => 'multipart/form-data',
                  'method' => 'POST'
                ]); ?>
                <div class="col-md-8">
                  <div class="main-wrapper">
                    <div class="quiz-container" id="quiz-container">

                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class=""><strong>Total Time: <?php echo $time_min; ?> min</strong> <span class="time_left"><strong>Time Left: </strong></span><span id="countdown"></span> Sec
                    <button class="prev-next btn_save" style="background-color: red;">Submit</button>
                  </div>
                  <div id="button_container"></div>
                </div>
                <input type="hidden" name="exam_id" value="<?php echo $exam_id ?>">
                <input type="hidden" name="start_time" value="<?php echo $start_time;?>">
                <input type="hidden" name="question_mark" value="<?php echo $question_mark;?>">
                <?= form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  const questions = <?php echo $questions; ?>;
  let timeLeft = <?php echo $time; ?>;
  let timerInterval;
  const countdownElement = document.getElementById("countdown");
  let quizContainer = document.getElementById("quiz-container");
  let buttonContainer = document.getElementById("button_container");
  let selectedAnswers = {};
  let question;
  let index;
  let selectQn = [];

  const generateOptions = (e) => {
    let options = ``;
    for (let i = 0; i < question.options.length; i++) {
      let question_id = question.question_id;
      let option = question.options[i];
      let selected = false;
      if (selectedAnswers[`${question.question}`] == option) {
        selected = true;
        $("#qn" + index).addClass("answered");
      }
      options += `<div class="each-answer">
        <input type="radio" class="answer-btn" data-index="${index}" data-qn="${question_id}" onclick="addAnswer(this)" ${selected ? "checked='true'" : ""}  value="${option}"> ${option}
    </div>`;
    }
    return options;
  }

  const generateJumpBtns = () => {
    let btns = ``;
    for (let i = 0; i < questions.length; i++) {
      let question = questions[i];
      let question_id = question.question_id;
      btns += `<button class="jumper-button ${i == index ? "active" : ""}"    id="qn${i}" onclick="showQuestion(${i})">${i + 1}</button>
      <input type="hidden" name="question[]" value="${question_id}">`;
    }
    return btns;
  }

  const addAnswer = (e) => {
    let currentOptions = document.getElementsByClassName("answer-btn");
    for (let i = 0; i < currentOptions.length; i++) {
      let currentOption = currentOptions[i];
      if (currentOption.checked == true) {
        selectQn.push(index);
        var indexingnum = e.getAttribute('data-index');
        var question_id = e.getAttribute('data-qn');
        $("#qn" + indexingnum).addClass("answered");
        selectedAnswers[`${question.question}`] = currentOption.value;
      }
    }
  }

  //  start the timer
  function startTimer() {
    timerInterval = setInterval(() => {
      timeLeft--;
      countdownElement.textContent = timeLeft;

      if (timeLeft === 0) {
        clearInterval(timerInterval);
      }
    }, 1000);
  }


  const showQuestion = (i) => {
    index = i;
    if (questions[index]) {
      question = questions[index];
      let options = generateOptions();
      let jumpBtns = generateJumpBtns();
      quizContainer.innerHTML = `<div class="pointer-container">
        <h3>Question ${index + 1} of ${questions.length}</h3>
    </div>
    <div>
        ${question.question}
    </div>
    <div class="answers-containers">
        ${options}
    </div>`;
      buttonContainer.innerHTML = `<div class="action-btns">
        ${index > 0 ? `<button class="prev-next" onclick="showQuestion(${index} - 1)">Previous</button>` : ""}
        ${jumpBtns}
        ${index < questions.length - 1 ? `<button class="prev-next" onclick="showQuestion(${index} + 1)">Next</button>` : ""}
    </div>`;
      $.each(selectQn, function(index, value) {
        // console.log("Index: " + index + ", Value: " + value);
        $('#qn' + value).addClass('answered');
      });
    } else {
      alert("Invalid question");
    }
  }

  showQuestion(0);
  startTimer();

  $(document).ready(function() {
    $('.btn_save').click(function() {
      var form_sp_user_exam = $('#form_sp_user_exam');
      var data_post = form_sp_user_exam.serializeArray();
      let message = `You are Submiting to Exam !`;
      let answered = Object.keys(selectedAnswers);
      if (answered.length < questions.length) {
        message += `\nYou have ${questions.length - answered.length} questions out of ${questions.length} unanswered.`
      }
      let wrong_arr_list = [];
      let attempted = 0;
      let correct = 0;
      let wrong = 0;
      let not_answered = 0;
      let correct_arr = [];
      let wrong_arr = [];
      let not_answered_list = [];
      Swal.fire({
        title: "Are you sure?",
        text: message,
        icon: "warning",
        color: "red",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          for (let i = 0; i < questions.length; i++) {
            let question = questions[i];
            if (selectedAnswers[`${question.question}`] != undefined) {
              attempted++;
              if (selectedAnswers[`${question.question}`] == question.answer) {
                let question_id = question.question_id;
                correct_arr.push(question_id);
                correct++;
              } else {
                let question_id = question.question_id;
                wrong_arr.push(question_id);
                wrong_arr_list.push({
                  qn: question_id,
                  ans: selectedAnswers[`${question.question}`]
                });
                wrong++;
              }
            } else {
              let question_id = question.question_id;
              not_answered_list.push(question_id);
              not_answered++;
            }
          }
          let wrong_detail = JSON.stringify(wrong_arr_list);
          data_post.push({
            name: 'wrong_ans',
            value: wrong_arr
          });
          data_post.push({
            name: 'wrong_detail',
            value: wrong_detail
          });
          data_post.push({
            name: 'wrong',
            value: wrong
          });
          data_post.push({
            name: 'correct_ans',
            value: correct_arr
          });
          data_post.push({
            name: 'not_answered_list',
            value: not_answered_list
          });
          data_post.push({
            name: 'not_answered',
            value: not_answered
          });
          data_post.push({
            name: 'correct',
            value: correct
          });
          data_post.push({
            name: 'attempted',
            value: attempted
          });
          $.ajax({
              url: BASE_URL + 'administrator/sp_mcq_exam/save_exam',
              type: 'POST',
              dataType: 'json',
              data: data_post,
            })
            .done(function(res) {
              if (res.success) {
                showStatusMessage('success', 'Success', res.message);
                // setTimeout(() => {
                //   window.location.reload(true);
                // }, 2000);
                window.location.href = res.redirect;
                return;
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
  });
</script>