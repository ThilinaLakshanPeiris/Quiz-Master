<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CheckQuizModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database(); // Load database library for database operations
    }

    // Method to retrieve complete quiz data by quiz ID
    public function get_complete_quiz($quizId)
    {
        // Select necessary columns from tables and perform join operations
        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText, question.question, question.questionId');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $this->db->join('question', 'quiz.quizId = question.quizId');
        $this->db->where('quiz.quizId', $quizId);
        $query = $this->db->get();
        $quiz_data = $query->result_array();

        // Iterate through each quiz question and fetch corresponding answers
        foreach ($quiz_data as &$quiz_item) {
            $this->db->select('answer.answerText, answer.correctAnswer');
            $this->db->from('answer');
            $this->db->where('answer.questionId', $quiz_item['questionId']);
            $answer_query = $this->db->get();
            $quiz_item['answers'] = $answer_query->result_array();
        }

        // Return the complete quiz data
        return $quiz_data;
    }

    // Method to save quiz marks to the database
    public function save_quiz_marks($user_id, $quiz_id, $correct_answers, $total_questions)
    {
        // Prepare data to be inserted into the 'marks' table
        $data = array(
            'id' => $user_id,
            'quizId' => $quiz_id,
            'markValue' => $correct_answers,
            'totalQuestions' => $total_questions,
        );

        // Insert data into the 'marks' table
        $this->db->insert('marks', $data);

        // Check if insertion was successful
        if ($this->db->affected_rows() > 0) {
            // If successful, return true
            return true;
        } else {
            // If insertion failed, return false
            return false;
        }
    }

    // Method to save quiz ratings to the database
    public function save_quiz_ratings($user_id, $quiz_id, $rateValue)
    {
        // Start database transaction
        $this->db->trans_start();

        // Define where clause for checking existing record
        $where = array(
            'quizId' => $quiz_id,
            'id' => $user_id
        );

        // Check if a record exists
        $existing_record = $this->db->get_where('quizrating', $where)->row();

        try {
            if ($existing_record) {
                // If a record exists, update it
                $data = array(
                    'rateValue' => $rateValue
                );
                $this->db->where($where);
                $this->db->update('quizrating', $data);
            } else {
                // If no record exists, insert new data
                $insertData = array(
                    'quizId' => $quiz_id,
                    'id' => $user_id,
                    'rateValue' => $rateValue
                );
                $this->db->insert('quizrating', $insertData);
            }

            // Complete database transaction
            $this->db->trans_complete();

            // Check transaction status
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            // Rollback transaction and return false in case of exception
            $this->db->trans_rollback();
            return false;
        }
    }
}
