<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ViewQuizModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    // public function get_complete_quiz($quizId) {

    //     // $query = $this->db->get('quiz');
    //     // return $query->result_array();  

    //     $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText, question.question, answer.answerText, answer.correctAnswer');
    //     $this->db->from('quiz');
    //     $this->db->join('category', 'quiz.categoryId = category.categoryId');
    //     $this->db->join('question', 'quiz.quizId = question.quizId');
    //     $this->db->join('answer', 'question.questionId = answer.questionId');
    //     $this->db->where('quiz.quizId', $quizId);
    //     $query = $this->db->get();
    //     return $query->result_array();

    // }

    public function get_complete_quiz($quizId)
    {
        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText, question.question, question.questionId');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $this->db->join('question', 'quiz.quizId = question.quizId');
        $this->db->where('quiz.quizId', $quizId);
        $query = $this->db->get();
        $quiz_data = $query->result_array();

        foreach ($quiz_data as &$quiz_item) {
            $this->db->select('answer.answerText, answer.correctAnswer, answer.answerId');
            $this->db->from('answer');
            $this->db->where('answer.questionId', $quiz_item['questionId']);
            $answer_query = $this->db->get();
            $quiz_item['answers'] = $answer_query->result_array();
        }

        return $quiz_data;
    }
}
