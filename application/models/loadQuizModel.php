<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadQuizModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    public function get_quizzes() {

        // $query = $this->db->get('quiz');
        // return $query->result_array();  

        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $query = $this->db->get();
        return $query->result_array();

    }

}
