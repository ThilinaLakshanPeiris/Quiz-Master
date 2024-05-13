<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CreateQuizModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database(); // Load the database library for database operations
    }

    // Method to insert a new quiz into the database
    public function insert_quiz($quiz_name, $quiz_category, $user_id)
    {
        // Prepare data to be inserted into the 'quiz' table
        $data = array(
            'quiz_title' => $quiz_name,
            'categoryId' => $quiz_category,
            'id' => $user_id,
        );

        // Insert data into the 'quiz' table
        $this->db->insert('quiz', $data);

        // Check if insertion was successful
        if ($this->db->affected_rows() > 0) {
            // If successful, return the inserted quiz ID
            return $this->db->insert_id();
        } else {
            // If insertion failed, return false
            return false;
        }
    }

    // Method to get the category ID for a given category name
    public function get_category_id($quiz_category)
    {
        // Check if a similar category already exists
        $existing_category = $this->db->get_where('category', array('categoryText' => $quiz_category))->row();

        if ($existing_category) {
            // If a similar category exists, return its ID
            return $existing_category->categoryId;
        } else {
            // If no similar category exists, you can choose to insert the new category (commented out in this code)
            // and return its ID
        }
    }

    // Method to insert a question into the database
    public function insert_question($quiz_id, $question_text)
    {
        // Prepare data to be inserted into the 'question' table
        $data = array(
            'quizId' => $quiz_id,
            'question' => $question_text
        );

        // Insert data into the 'question' table
        $this->db->insert('question', $data);

        // Return the inserted question ID
        return $this->db->insert_id();
    }

    // Method to insert an answer into the database
    public function insert_answer($question_id, $answer_text, $correct_answer)
    {
        // Prepare data to be inserted into the 'answer' table
        $data = array(
            'questionId' => $question_id,
            'answerText' => $answer_text,
            'correctAnswer' => $correct_answer
        );

        // Insert data into the 'answer' table
        $this->db->insert('answer', $data);
    }

    // Method to insert a new record into the 'quizrating' table and return the inserted ID
    public function get_rating_id($quiz_id, $user_id)
    {
        // Prepare data to be inserted into the 'quizrating' table
        $data = array(
            'quizId' => $quiz_id,
            'id' => $user_id,
            'rateValue' => 0
        );

        // Insert data into the 'quizrating' table
        $this->db->insert('quizrating', $data);

        // Return the inserted rating ID
        return $this->db->insert_id();
    }

    // Method to set the rating ID for a quiz in the 'quiz' table
    public function set_rating_id($quiz_id, $rating_id)
    {
        // Start database transaction
        $this->db->trans_start();

        // Prepare data to be updated in the 'quiz' table
        $data = array(
            'ratingId' => $rating_id,
        );

        try {
            // Update the 'quiz' table with the new rating ID
            $this->db->where('quizId', $quiz_id);
            $this->db->update('quiz', $data);

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
