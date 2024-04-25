<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ViewQuiz extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('viewQuizModel');
    }

    public function view_quizzes($quizId)
    {

        $quiz = $this->viewQuizModel->get_complete_quiz($quizId);

        $data['quiz'] = $quiz;
        $this->load->view('Admin/participateQuiz', $data);
    }
}
