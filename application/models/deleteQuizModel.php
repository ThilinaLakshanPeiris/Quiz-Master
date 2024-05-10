<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DeleteQuizModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    public function delete_quiz($quizId)
    {

        $this->db->select('question.questionId');
        $this->db->from('question');
        $this->db->where('question.quizId', $quizId);
        $query = $this->db->get();

        try {
            foreach ($query->result_array() as $questionId) {
                $this->db->delete('answer', array('questionId' => $questionId['questionId']));
            }
            $this->db->delete('question', array('quizId' => $quizId));
            $this->db->delete('marks', array('quizId' => $quizId));
            $this->db->delete('quiz', array('quizId' => $quizId));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
