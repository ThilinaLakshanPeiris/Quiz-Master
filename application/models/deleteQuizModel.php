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

    // Function to delete a quiz and its associated questions, answers, and ratings from the database
    public function delete_quiz($quizId)
    {
        // Select question IDs associated with the specified quiz ID
        $this->db->select('question.questionId');
        $this->db->from('question');
        $this->db->where('question.quizId', $quizId);
        $query = $this->db->get();

        try {
            // Iterate through each question and delete its associated answers
            foreach ($query->result_array() as $questionId) {
                $this->db->delete('answer', array('questionId' => $questionId['questionId']));
            }
            
            // Delete questions associated with the specified quiz ID
            $this->db->delete('question', array('quizId' => $quizId));

            // Delete marks associated with the specified quiz ID
            $this->db->delete('marks', array('quizId' => $quizId));

            // Disable foreign key checks to delete quiz ratings associated with the specified quiz ID
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
            $this->db->where('quizId', $quizId);
            $this->db->delete('quizrating');
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

            // Delete the quiz itself
            $this->db->delete('quiz', array('quizId' => $quizId));

            return true; // Return true on successful deletion
        } catch (Exception $e) {
            return false; // Return false if an exception occurs during deletion
        }
    }
}
