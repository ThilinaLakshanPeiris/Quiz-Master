<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DeleteQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('viewQuizModel'); // Load model for viewing quizzes (not used in this controller)
        $this->load->model('deleteQuizModel'); // Load model for deleting quizzes
    }

    // Method to delete a quiz by its ID
    public function delete_quiz($quizId)
    {
        // Call the delete_quiz method from the deleteQuizModel to delete the quiz
        $deleted = $this->deleteQuizModel->delete_quiz($quizId);

        // Check if the quiz was successfully deleted
        if($deleted) {
            echo json_encode("Quiz deleted successfully");
        } else {
            echo json_encode("Error");
        }
    }
}
