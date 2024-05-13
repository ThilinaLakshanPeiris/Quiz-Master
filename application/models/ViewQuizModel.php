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

    public function get_complete_quiz($quizId)
    {
        // Select quiz details, category, and questions based on the provided quiz ID
        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText, question.question, question.questionId');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $this->db->join('question', 'quiz.quizId = question.quizId');
        $this->db->where('quiz.quizId', $quizId);
        $query = $this->db->get();
        $quiz_data = $query->result_array();

        // Iterate through each question in the quiz data
        foreach ($quiz_data as &$quiz_item) {
            // Select answers for each question based on the question ID
            $this->db->select('answer.answerText, answer.correctAnswer, answer.answerId');
            $this->db->from('answer');
            $this->db->where('answer.questionId', $quiz_item['questionId']);
            $answer_query = $this->db->get();
            // Store the answers as an array within the quiz item
            $quiz_item['answers'] = $answer_query->result_array();
        }

        // Return the complete quiz data including questions and answers
        return $quiz_data;
    }
}
