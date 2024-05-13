<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetCategoryModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database(); // Load the database library for database operations
    }

    // Method to retrieve all categories from the database
    public function get_categories()
    {
        // Perform a SELECT query to retrieve all records from the 'category' table
        $query = $this->db->get('category');
        
        // Return the result of the query as an array of objects representing categories
        return $query->result();
    }
}
