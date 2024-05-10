<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DeleteQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('viewQuizModel');
        $this->load->model('deleteQuizModel');
    }

    public function delete_quiz($quizId)
    {
        // $quiz = $this->viewQuizModel->get_complete_quiz($quizId);

        // $data['quiz'] = $quiz;
        // $this->load->view('Admin/editQuiz', $data);
        $deleted = $this->deleteQuizModel->delete_quiz($quizId);

        if($deleted) {
            echo json_encode("Quiz deleted successfully");
        }
        else {
            echo json_encode("Error");
        }
    }
}
