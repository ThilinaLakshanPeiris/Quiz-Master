<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadQuizModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database(); // Load the database library for database operations
    }

    // Method to retrieve all quizzes with their average ratings
    public function get_quizzes()
    {
        // Select quiz details along with the category text and average rating
        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText, ROUND(AVG(quizrating.rateValue)) AS average_rating');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $this->db->join('quizrating', 'quiz.quizId = quizrating.quizId');
        $this->db->group_by('quiz.quizId'); // Group by quizId to calculate average rating for each quiz
        $query = $this->db->get();
        return $query->result_array(); // Return the result as an array
    }

    // Method to retrieve quizzes created by a specific user
    public function get_user_quizzes($id)
    {
        // Select quiz details along with the category text created by the user with the given ID
        $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText');
        $this->db->from('quiz');
        $this->db->join('category', 'quiz.categoryId = category.categoryId');
        $this->db->where('quiz.id', $id); // Filter quizzes by the user ID
        $query = $this->db->get();
        return $query->result_array(); // Return the result as an array
    }

    // Method to retrieve quizzes participated by a specific user
    public function get_participated_quizzes($id)
    {
        // Select quiz ID, maximum mark achieved, and total number of questions attempted by the user with the given ID
        $this->db->select('marks.quizId, MAX(marks.markValue) as max_markValue, marks.totalQuestions');
        $this->db->from('marks');
        $this->db->where('marks.id', $id); // Filter marks by the user ID
        $this->db->group_by('marks.quizId'); // Group by quizId to aggregate data for each quiz
        $query = $this->db->get();

        // Initialize an array to store the final query results
        $queryArr = array();

        // Iterate through the query result to fetch additional quiz details and merge with existing data
        foreach ($query->result_array() as $quiz) {
            $this->db->select('quiz.quizId, quiz.quiz_title, category.categoryText');
            $this->db->from('quiz');
            $this->db->join('category', 'quiz.categoryId = category.categoryId');
            $this->db->where('quiz.quizId', $quiz['quizId']); // Filter quizzes by the quiz ID
            $query = $this->db->get();
            $result = $query->row_array();

            // Merge additional data with existing quiz details
            $result['max_markValue'] = $quiz['max_markValue'];
            $result['totalQuestions'] = $quiz['totalQuestions'];

            // Add the merged data to the final result array
            $queryArr[] = $result;
        }

        return $queryArr; // Return the final result array
    }
}
