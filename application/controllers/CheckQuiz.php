<?php
// Ensure the script is accessed only through CodeIgniter
defined('BASEPATH') or exit('No direct script access allowed');

class CheckQuiz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models
        $this->load->model('checkQuizModel');
    }

    // Endpoint to check quizzes
    public function check_quizzes()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get the raw POST data
            $postData = file_get_contents("php://input");

            if (!empty($postData)) {
                $jsonData = json_decode($postData, true);

                $user_id = $jsonData['user_id'];
                $quiz_id = $jsonData['quiz_id'];
                $selected_questions = $jsonData['questions'];

                // Retrieve the complete quiz details
                $quiz = $this->checkQuizModel->get_complete_quiz($quiz_id);

                $correct_answers = 0;
                $totalQuestions = 0;

                // Iterate through each question in the quiz
                foreach ($quiz as $quizQuestion) {
                    foreach ($selected_questions as $selectedQuestion) {
                        if ($quizQuestion['questionId'] === $selectedQuestion['question_id']) {
                            // Iterate through each answer in the question
                            foreach ($quizQuestion['answers'] as $answer) {
                                foreach ($selectedQuestion['answers'] as $selectedAnswer) {
                                    // Check if the selected answer matches the correct answer
                                    if ($answer['answerText'] === $selectedAnswer['answer_text']) {
                                        if ($answer['correctAnswer'] == "1" && $selectedAnswer['is_selected'] == true) {
                                            $correct_answers++;
                                            break;
                                        }
                                    }
                                }
                            }
                            $totalQuestions++;
                            break;
                        }
                    }
                }

                // Prepare data to be returned
                $data = array(
                    'user_id' => $user_id,
                    'quiz_id' => $quiz_id,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correct_answers
                );

                // Output JSON response
                echo json_encode($data);
            } else {
                echo "Error: Empty POST data";
            }
        } else {
            echo "Error: Invalid Request Method";
        }
    }

    // Endpoint to save quiz marks
    public function save_quiz_marks()
    {
        $postData = file_get_contents("php://input");

        if (!empty($postData)) {
            $jsonData = json_decode($postData, true);

            $user_id = $jsonData['user_id'];
            $quiz_id = $jsonData['quiz_id'];
            $correct_answers = $jsonData['correct_answers'];
            $total_questions = $jsonData['total_questions'];

            // Call model method to save quiz marks
            $this->checkQuizModel->save_quiz_marks($user_id, $quiz_id, $correct_answers, $total_questions);

            echo "Quiz Marks saved successfully";
        }
    }

    // Endpoint to save quiz ratings
    public function save_quiz_ratings()
    {
        $postData = file_get_contents("php://input");

        if (!empty($postData)) {
            $jsonData = json_decode($postData, true);

            $user_id = $jsonData['user_id'];
            $quiz_id = $jsonData['quiz_id'];
            $rateValue = $jsonData['ratingValue'];

            // Call model method to save quiz ratings
            $this->checkQuizModel->save_quiz_ratings($user_id, $quiz_id, $rateValue);

            echo "Quiz Ratings saved successfully";
        }
    }
}
