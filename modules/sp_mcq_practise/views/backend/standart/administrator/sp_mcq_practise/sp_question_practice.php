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
  <h1>MCQ Practice </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=""><a href="<?= admin_site_url('/sp_mcq_question'); ?>">MCQ Practice</a></li>
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
                <div class="quiz">
                  <div><strong> Question: </strong><span id="total_question"></span> &nbsp; &nbsp;<strong>Score:</strong> <span id="total_score"></span>/<span id="question_no"></span></div>
                  <!-- <p id="timer">Time Left: <span id="countdown"></span> S</p> -->
                  <h2 id="question">Your Question is here</h2>
                  <div id="answer-buttons">
                    <button class="option_value">Answer1</button>
                    <button class="option_value">Answer2</button>
                    <button class="option_value">Answer3</button>
                    <button class="option_value">Answer4</button>
                  </div>
                  <div class="buttons">
                    <button id="next-btn">Next</button>
                    <button class="btn-primary" id="explanation">Hint</button>
                  </div>

                  <span id="hint" style="display: none;"></span>
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
  $('#explanation').click(function() {
    $('#hint').toggle();
  });
  const questions = <?php echo $questions; ?>;
  const questionElement = document.getElementById("question");
  const hintElement = document.getElementById("hint");
  const question_no = document.getElementById("question_no");
  const hintButton = document.getElementById("explanation");
  const answerButtons = document.getElementById("answer-buttons");
  const nextButton = document.getElementById("next-btn");
  const submitButton = document.getElementById("submit-btn");
  const total_question = document.getElementById("total_question");
  const total_score = document.getElementById("total_score");
  // const timerElement = document.getElementById("timer");
  // const countdownElement = document.getElementById("countdown");
  let currentQuestionIndex = 0;
  let score = 0;
  let timeLeft = 600;

  let timerInterval;




  //  start the timer
  // function startTimer() {
  //   timerInterval = setInterval(() => {
  //     timeLeft--;
  //     countdownElement.textContent = timeLeft;

  //     if (timeLeft === 0) {
  //       clearInterval(timerInterval);
  //       hideNextButton();
  //       showSubmitButton();
  //       showScore();
  //     }
  //   }, 1000);
  // }

  // stop the timer
  // function stopTimer() {
  //   clearInterval(timerInterval);
  // }

  //  hide the Next button
  function hideNextButton() {
    nextButton.style.display = "none";
  }

  // hide the hint button
  function hideHintButton() {
    hintButton.style.display = "none";
  }

  //  hide the submit button
  function hideSubmitButton() {
    submitButton.style.display = "none";
  }

  // show the Next button
  function showNextButton() {
    nextButton.style.display = "block";
  }
  //  show the Sumit button
  function showSubmitButton() {
    submitButton.style.display = "block";
  }

  //  show a question
  function showQuestion() {
    resetState();
    var sn = currentQuestionIndex + 1;
    const currentQuestion = questions[currentQuestionIndex];
    questionElement.innerHTML = currentQuestion.question;
    total_question.innerHTML = questions.length;
    question_no.innerHTML = currentQuestionIndex;
    hintElement.innerHTML = currentQuestion.explanation;
    currentQuestion.answers.forEach((answer, index) => {
      const button = document.createElement("button");
      button.innerHTML = answer.text;
      button.classList.add("option_value");
      button.addEventListener("click", () => selectAnswer(index));
      answerButtons.appendChild(button);
    });
    showNextButton();
    // startTimer();
  }

  //  reset the answer buttons
  function resetState() {
    while (answerButtons.firstChild) {
      answerButtons.removeChild(answerButtons.firstChild);
    }
    // countdownElement.textContent = timeLeft;
  }

  //  handle answer selection
  function selectAnswer(selectedIndex) {
    // stopTimer();
    // Stop the timer  answer is selected
    const currentQuestion = questions[currentQuestionIndex];
    const isCorrect = currentQuestion.answers[selectedIndex].correct;
    if (isCorrect) {
      score = score + 1;
    }
    answerButtons.childNodes[selectedIndex].classList.add(isCorrect ? "correct" : "incorrect");
    answerButtons.childNodes.forEach((button) => (button.disabled = true));
    total_score.innerHTML = score;
    showNextButton();
  }

  //  handle next question
  function handleNextButtonClick() {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
      showQuestion();
    } else {
      showScore();
      showSubmitButton();
    }
  }

  //  show the final score
  function showScore() {
    resetState();
    questionElement.innerHTML = `Your score: ${score} out of ${questions.length * 1}`;
    hideNextButton();
    hideHintButton();
  }

  //   start the quiz
  function startQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    showQuestion();
  }

  //  quiz start
  startQuiz();

  // Event listener  the Next button
  nextButton.addEventListener("click", handleNextButtonClick);

  //deteailes form

  document.addEventListener("DOMContentLoaded", function() {

    const myForm = document.getElementById("myForm");

    submitButton.addEventListener("click", function() {
      if (myForm.style.display === "none" || myForm.style.display === "") {
        myForm.style.display = "block";
        hideSubmitButton()
      } else {
        myForm.style.display = "none";
      }
    });
  });
</script>