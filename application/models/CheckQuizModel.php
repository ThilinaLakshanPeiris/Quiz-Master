<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CheckQuizModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    public function get_complete_quiz($quizId)
    {

        // $query = $this->db->get('quiz');
        // return $query->result_array(); 

        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText, question.question, question.questionId');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $this->db->join('question', 'quiz.quizId = question.quizId');
        $this->db->where('quiz.quizId', $quizId);
        $query = $this->db->get();
        $quiz_data = $query->result_array();

        foreach ($quiz_data as &$quiz_item) {
            $this->db->select('answer.answerText, answer.correctAnswer');
            $this->db->from('answer');
            $this->db->where('answer.questionId', $quiz_item['questionId']);
            $answer_query = $this->db->get();
            $quiz_item['answers'] = $answer_query->result_array();
        }

        return $quiz_data;
    }

    public function save_quiz_marks($user_id, $quiz_id, $correct_answers, $total_questions) {

        $data = array(
            'id' => $user_id,
            'quizId' => $quiz_id,
            'markValue' => $correct_answers,
            'totalQuestions' => $total_questions,
        );

        $this->db->insert('marks', $data);

        if ($this->db->affected_rows() > 0) {
            // If successful, return the inserted category ID
            return true;
        } else {
            // If insertion failed, return false or handle the error as needed
            return false;
        }

    }

}
