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

    public function index()
    {
        $this->load->view('createQuiz');
    }

    // public function submit_quiz()
    // {
    //     // Get form data
    //     $data = json_decode(trim(file_get_contents('php://input')), true); // Get raw POST data
    //     $quiz_name = $data['quiz_name'];
    //     $quiz_category = $data['quiz_category'];
    //     $questions = $data['questions'];

    //     // Insert quiz details into database
    //     $quiz_id = $this->CreateQuizModel->insert_quiz($quiz_name, $quiz_category);

    //     // Insert questions and answers into database
    //     foreach ($questions as $question) {
    //         $question_text = $question['question'];
    //         $answers = $question['answers'];

    //         $question_id = $this->CreateQuizModel->insert_question($quiz_id, $question_text);

    //         foreach ($answers as $answer) {
    //             $answer_text = $answer['answer_text'];
    //             $correct_answer = $answer['correct_answer'];

    //             $this->CreateQuizModel->insert_answer($question_id, $answer_text, $correct_answer);
    //         }
    //     }

    //     // You can redirect to a success page or return a JSON response
    //     // echo json_encode(array('success' => true));
    // }

    public function submit_quiz()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get the raw POST data
            $postData = file_get_contents("php://input");

            // Check if the POST data is not empty
            if (!empty($postData)) {
                // Decode the JSON data into an associative array
                $jsonData = json_decode($postData, true);

                // Access the data as needed
                $quizName = $jsonData['quiz_name'];
                $quizCategory = $jsonData['quiz_category'];
                $questions = $jsonData['questions'];

                // Insert quiz details into database
                $category_id = $this->createQuizModel->insert_category($quizCategory);

                if($category_id == false) {
                    echo "Error Fetching Quiz Details";
                }
                else {
                    echo json_encode($category_id);
                }

                $quiz_id = $this->createQuizModel->insert_quiz($quizName, $category_id);

                if($quiz_id == false) {
                    echo "Error Fetching Quiz Details";
                }
                else {
                    echo json_encode($quiz_id);
                }

                // echo json_encode($quizName);
                // // Process each question
                foreach ($questions as $question) {
                    $questionText = $question['question_text'];
                    $answers = $question['answers'];

                    $question_id = $this->createQuizModel->insert_question($quiz_id, $questionText);

                    // Process each answer for the question
                    foreach ($answers as $answer) {
                        $answerText = $answer['answer_text'];
                        $isCorrect = $answer['is_correct'];

                        $this->createQuizModel->insert_answer($question_id, $answerText, $isCorrect);

                        // Perform further processing as needed, such as saving to database
                        // Example: Save $questionText, $answerText, $isCorrect to database
                    }
                }

                // For demonstration purposes, echo back a success message
                echo "Quiz data received and processed successfully!";
                echo json_encode($jsonData);
            } else {
                // Handle empty POST data
                echo "Error: Empty POST data";
            }
        } else {
            // Handle non-POST requests
            echo "Error: Only POST requests are allowed";
        }
    }
}
