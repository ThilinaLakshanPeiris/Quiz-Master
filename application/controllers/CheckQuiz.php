<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CheckQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('checkQuizModel');
    }

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

                $quiz = $this->checkQuizModel->get_complete_quiz($quiz_id);

                $correct_answers = 0;
                $totalQuestions = 0;

                foreach ($quiz as $quizQuestion) {
                    foreach ($selected_questions as $selectedQuestion) {
                        if($quizQuestion['questionId'] === $selectedQuestion['question_id']){
                            foreach ($quizQuestion['answers'] as $answer) {
                                foreach ($selectedQuestion['answers'] as $selectedAnswer) {
                                    if($answer['answerText'] === $selectedAnswer['answer_text']){
                                        if($answer['correctAnswer'] == "1" && $selectedAnswer['is_selected'] == true) {
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

                $data = array(
                    'user_id' => $user_id,
                    'quiz_id' => $quiz_id,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correct_answers);
                // echo json_encode($selected_questions);
                // echo json_encode($quiz);
                echo json_encode($data);

            } else {
                echo "Error: Empty POST data";
            }
        } else {
            echo "Error: Invalid Request Method";
        }
    }

    public function save_quiz_marks() {
        $postData = file_get_contents("php://input");

        if (!empty($postData)) {
            $jsonData = json_decode($postData, true);

            $user_id = $jsonData['user_id'];
            $quiz_id = $jsonData['quiz_id'];
            $correct_answers = $jsonData['correct_answers'];
            $total_questions = $jsonData['total_questions'];

            $this->checkQuizModel->save_quiz_marks($user_id, $quiz_id, $correct_answers, $total_questions);

            echo "Quiz Marks saved successfully";
        }
    }

}
