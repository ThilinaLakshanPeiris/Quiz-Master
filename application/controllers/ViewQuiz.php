<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ViewQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('viewQuizModel'); // Load model for viewing quizzes
    }

    // Method to view a specific quiz
    public function view_quizzes($quizId)
    {
        // Call the method from the viewQuizModel model to retrieve the complete quiz data by ID
        $quiz = $this->viewQuizModel->get_complete_quiz($quizId);

        // Prepare data to be passed to the view
        $data['quiz'] = $quiz;

        // Load the 'participateQuiz' view with the quiz data
        $this->load->view('Admin/participateQuiz', $data);
    }
}
