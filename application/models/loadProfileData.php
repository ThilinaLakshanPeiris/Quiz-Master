<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadProfileData extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database(); // Load the database library for database operations
    }

    // Method to retrieve user information based on the provided user ID
    public function get_user_info($id)
    {
        // Select the first name of the user with the given ID
        $this->db->select('users.fname');
        $this->db->from('users');
        $this->db->where('users.id', $id);
        $query = $this->db->get();
        $fname = $query->row();

        // Select the last name of the user with the given ID
        $this->db->select('users.lname');
        $this->db->from('users');
        $this->db->where('users.id', $id);
        $query = $this->db->get();
        $lname = $query->row();

        // Count the total number of quizzes created by the user
        $this->db->where('quiz.id', $id);
        $this->db->from('quiz');
        $createdAllQuizzes = $this->db->count_all_results();

        // Count the total number of quizzes participated by the user
        $this->db->where('marks.id', $id);
        $this->db->from('marks');
        $participatedQuizzes = $this->db->count_all_results();

        // Get the maximum mark achieved by the user
        $this->db->select('MAX(marks.markValue) as max_markValue');
        $this->db->from('marks');
        $this->db->where('marks.id', $id);
        $query = $this->db->get();
        $max_mark = $query->row();

        // Get the total sum of marks achieved by the user
        $this->db->select_sum('markValue');
        $this->db->from('marks');
        $this->db->where('marks.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $sum = $result['markValue'];

        // Get the total number of questions attempted by the user
        $this->db->select('marks.totalQuestions');
        $this->db->from('marks');
        $this->db->where('marks.id', $id);
        $query = $this->db->get();
        $total_questions = $query->row();

        // If no total questions are found, set it to 0, otherwise convert to integer
        if ($total_questions == null) {
            $total_questions = 0;
        } else {
            $total_questions = (int)$total_questions->totalQuestions;
        }

        // Construct an array containing user information
        $data = array(
            'fname' => $fname->fname,
            'lname' => $lname->lname,
            'createdQuizzes' => $createdAllQuizzes,
            'participatedQuizzes' => $participatedQuizzes,
            'max_mark' => (int)$max_mark->max_markValue,
            'total_marks' => (int)$sum,
            'totalQuestions' => $total_questions,
        );

        return $data; // Return the array containing user information
    }
}
