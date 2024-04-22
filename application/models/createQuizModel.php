<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CreateQuizModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    public function insert_quiz($quiz_name, $quiz_category)
    {
        $data = array(
            'quiz_title' => $quiz_name,
            'categoryId' => $quiz_category,
        );

        $this->db->insert('quiz', $data);

        if ($this->db->affected_rows() > 0) {
            // If successful, return the inserted category ID
            return $this->db->insert_id();
        } else {
            // If insertion failed, return false or handle the error as needed
            return false;
        }
    }

    public function get_category_id($quiz_category)
    {
        // Check if a similar category already exists
        $existing_category = $this->db->get_where('category', array('categoryText' => $quiz_category))->row();

        if ($existing_category) {
            // If a similar category exists, return its ID
            return $existing_category->categoryId;
        } else {
            // If no similar category exists, insert the new category
            // $data = array(
            //     'categoryText' => $quiz_category
            // );

            // $this->db->insert('category', $data);

            // if ($this->db->affected_rows() > 0) {
            //     // If successful, return the inserted category ID
            //     return $this->db->insert_id();
            // } else {
            //     // If insertion failed, return false or handle the error as needed
            //     return false;
            // }            
        }
    }

    public function insert_question($quiz_id, $question_text)
    {
        $data = array(
            'quizId' => $quiz_id,
            'question' => $question_text
        );

        $this->db->insert('question', $data);
        return $this->db->insert_id();
    }

    public function insert_answer($question_id, $answer_text, $correct_answer)
    {
        $data = array(
            'questionId' => $question_id,
            'answerText' => $answer_text,
            'correctAnswer' => $correct_answer
        );

        $this->db->insert('answer', $data);
    }
}
