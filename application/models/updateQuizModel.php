<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UpdateQuizModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    public function check_update_quiz_id($quizId)
    {
        // Check if the quiz ID exists in the database
        $query = $this->db->get_where('quiz', array('quizId' => $quizId));
        return $query->num_rows() > 0;
    }

    public function update_quiz($quizId, $quiz_name, $quiz_category)
    {
        // Update quiz details in the database
        $this->db->trans_start();

        $data = array(
            'quiz_title' => $quiz_name,
            'categoryId' => $quiz_category,
        );

        // Execute the update query within a transaction
        try {
            $this->db->where('quizId', $quizId);
            $this->db->update('quiz', $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function update_question($quizId, $question_id, $question_text)
    {
        // Update question text in the database
        $this->db->trans_start();

        $data = array(
            'question' => $question_text
        );

        // Execute the update query within a transaction
        try {
            $this->db->where('questionId', $question_id);
            $this->db->update('question', $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function update_answer($questionId, $answerid, $answer_text, $correct_answer)
    {
        // Update answer text and correctness in the database
        $this->db->trans_start();

        $data = array(
            'answerText' => $answer_text,
            'correctAnswer' => $correct_answer
        );

        // Execute the update query within a transaction
        try {
            $this->db->where('answerId', $answerid);
            $this->db->update('answer', $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }
}
