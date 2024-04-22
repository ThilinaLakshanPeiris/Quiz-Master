<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadQuiz extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('loadQuizModel');
    }

    public function load_quizzes() {

        $quizzes = $this->loadQuizModel->get_quizzes();
        echo json_encode($quizzes);

    }
}

?>