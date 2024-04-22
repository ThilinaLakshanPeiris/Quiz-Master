<?php

class Admin extends CI_Controller
{
    /* public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    } */

    public function index()
    {
        $this->load->view('Admin/dashboad');
    }
    public function CreateQuiz()
    {
        $this->load->view('Admin/createQuiz');
    }
    public function ParticipateQuiz()
    {
        $this->load->view('Admin/participateQuiz');
    }
    public function MyQuizzes()
    {
        $this->load->view('Admin/myQuizzes');
    }

}