<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EditQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('viewQuizModel'); // Load model for viewing quizzes
        $this->load->model('updateQuizModel'); // Load model for updating quizzes
        $this->load->model('createQuizModel'); // Load model for creating quizzes
    }

    // Method to load the view for editing a quiz
    public function edit_quiz_view($quizId)
    {
        // Retrieve the complete quiz details by its ID
        $quiz = $this->viewQuizModel->get_complete_quiz($quizId);

        $data['quiz'] = $quiz;
        // Load the view for editing quiz with quiz data
        $this->load->view('Admin/editQuiz', $data);
    }

    // Method to update a quiz
    public function update_quiz($quizId)
    {
        // Get the raw update data from the request
        $updateData = file_get_contents("php://input");

        // Decode the JSON data
        $jsonData = json_decode($updateData, true);

        // Check if the quiz ID exists
        $query = $this->updateQuizModel->check_update_quiz_id($quizId);

        if ($query && !empty($updateData)) {
            // If the quiz ID exists and the update data is not empty

            // Extract necessary information from the JSON data
            $quizName = $jsonData['quiz_name'];
            $quizCategory = $jsonData['quiz_category'];
            $questions = $jsonData['questions'];

            // Get the category ID for the quiz category
            $categoryId = $this->createQuizModel->get_category_id($quizCategory);

            if ($categoryId) {
                // If the category ID exists

                // Update the quiz information
                if ($this->updateQuizModel->update_quiz($quizId, $quizName, $categoryId)) {
                    // If the quiz is updated successfully

                    // Update each question and its answers
                    foreach ($questions as $question) {
                        try {
                            $questionText = $question['question_text'];
                            $question_id = $question['question_id'];
                            $answers = $question['answers'];

                            if ($this->updateQuizModel->update_question($quizId, $question_id, $questionText)) {
                                foreach ($answers as $answer) {
                                    $answerText = $answer['answer_text'];
                                    $answerid = $answer['answer_id'];
                                    $isCorrect = $answer['is_correct'];

                                    // Update each answer
                                    $this->updateQuizModel->update_answer($question_id, $answerid, $answerText, $isCorrect);
                                }
                            } else {
                                echo json_encode("Error while updating question table");
                            }
                        } catch (Exception $e) {
                            echo json_encode("Error: " . $e->getMessage());
                        }
                    }
                    echo json_encode("Quiz updated successfully!");
                } else {
                    echo json_encode("Error while updating quiz table");
                }
            }
            echo json_encode("Quiz updated successfully!");
        } else {
            echo json_encode("This quiz id does not exist!");
        }
    }
}
