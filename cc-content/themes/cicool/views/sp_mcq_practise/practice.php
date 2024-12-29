<?= get_header(); ?>
<link href="<?= theme_asset(); ?>/css/clean-blog.css" rel="stylesheet">

<body id="page-top">
    <?= get_navigation(); ?>

    <div class="container-xxl py-1">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="row app">
                        <div class="quiz">
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
                <div class="col-md-4 col-sm-12">
                    <div class="question-detail-extra-main-col">
                        <div class="question-default-bookmark">
                            <div class="mcq-extra-detail-container">
                                <p id="timer"></p>
                                <div><strong> Question: </strong><span id="total_question"></span></div>
                                <div><strong>Score: </strong><span id="total_score"></span>/<span id="question_no"></span></div>

                            </div>

                        </div>

                    </div>
                    <div class="row pt-2">
                        <h4 class="">Share MCQs:</h4>
                        <div class="d-flex pt-0">
                            <?php
                            $shareURL = base_url('sp_mcq_practise/practice/' . $id); // Replace with your URL
                            $shareText = "MCQ"; // Replace with your message
                            $encodedURL = urlencode($shareURL);
                            $encodedText = urlencode($shareText);
                            $facebookShareLink = 'https://www.facebook.com/share.php?u=' . urlencode($shareURL);
                            $whatsappLink = "https://wa.me/?text={$encodedText}%20{$encodedURL}"; ?>
                            <a class="btn  share_social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn  share_social" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encodedURL; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn  share_social" href="<?php echo $whatsappLink; ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a class="btn  share_social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= get_footer(); ?>
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
        //     timerInterval = setInterval(() => {
        //         timeLeft--;
        //         countdownElement.textContent = timeLeft;

        //         if (timeLeft === 0) {
        //             clearInterval(timerInterval);
        //             hideNextButton();
        //             showSubmitButton();
        //             showScore();
        //         }
        //     }, 1000);
        // }

        // stop the timer
        // function stopTimer() {
        //     clearInterval(timerInterval);
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
                $('#hint').hide();
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