<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('loadQuizModel'); // Load model for loading quizzes
    }

    // Method to load all quizzes
    public function load_quizzes()
    {
        // Call the method from the loadQuizModel model to retrieve all quizzes
        $quizzes = $this->loadQuizModel->get_quizzes();
        echo json_encode($quizzes); // Output quizzes data as JSON
    }

    // Method to load quizzes of a specific user
    public function load_user_quizzes($id)
    {
        // Call the method from the loadQuizModel model to retrieve quizzes of a specific user by ID
        $quizzes = $this->loadQuizModel->get_user_quizzes($id);
        echo json_encode($quizzes); // Output quizzes data as JSON
    }

    // Method to load quizzes in which a user has participated
    public function load_participated_quizzes($id)
    {
        // Call the method from the loadQuizModel model to retrieve quizzes in which a user has participated by ID
        $quizzes = $this->loadQuizModel->get_participated_quizzes($id);
        echo json_encode($quizzes); // Output quizzes data as JSON
    }
}
