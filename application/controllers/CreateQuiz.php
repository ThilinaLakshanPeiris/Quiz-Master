<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CreateQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('createQuizModel');
        $this->load->helper('url'); // Load URL helper for redirect
    }

    // Method to load the view for creating a quiz
    public function index()
    {
        $this->load->view('createQuiz');
    }

    // Method to submit a quiz
    public function submit_quiz()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $postData = file_get_contents("php://input");

            // Check if the POST data is not empty
            if (!empty($postData)) {

                $jsonData = json_decode($postData, true);

                $user_id = $jsonData['user_id'];
                $quizName = $jsonData['quiz_name'];
                $quizCategory = $jsonData['quiz_category'];
                $questions = $jsonData['questions'];

                // Get the category ID for the quiz
                $category_id = $this->createQuizModel->get_category_id($quizCategory);

                if ($category_id == false) {
                    echo "Error Fetching Quiz Details";
                } else {
                    $quiz_id = $this->createQuizModel->insert_quiz($quizName, $category_id, $user_id);

                    if ($quiz_id == false) {
                        echo "Error Fetching Quiz Details";
                    } else {
                        // Retrieve or create rating ID for the quiz
                        $rating_id = $this->createQuizModel->get_rating_id($quiz_id, $user_id);
                        $this->createQuizModel->set_rating_id($quiz_id, $rating_id);
                    }
                }

                foreach ($questions as $question) {
                    $questionText = $question['question_text'];
                    $answers = $question['answers'];

                    $question_id = $this->createQuizModel->insert_question($quiz_id, $questionText);

                    foreach ($answers as $answer) {
                        $answerText = $answer['answer_text'];
                        $isCorrect = $answer['is_correct'];

                        // Insert answers for each question
                        $this->createQuizModel->insert_answer($question_id, $answerText, $isCorrect);
                    }
                }

                // Respond with success message
                echo "Quiz data received and processed successfully!";
                echo json_encode($jsonData); // For testing purposes, echo back the received JSON data
            } else {
                echo "Error: Empty POST data";
            }
        } else {
            echo "Error: Only POST requests are allowed";
        }
    }
}
