<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadQuiz extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('loadQuizModel');
    }

    public function load_quizzes() {

        $quizzes = $this->loadQuizModel->get_quizzes();
        echo json_encode($quizzes);

    }

    public function load_user_quizzes($id) {

        $quizzes = $this->loadQuizModel->get_user_quizzes($id);
        echo json_encode($quizzes);

    }
}

?>