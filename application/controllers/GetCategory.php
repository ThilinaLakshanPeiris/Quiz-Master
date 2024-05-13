<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetCategory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('getCategoryModel'); // Load model for retrieving categories
    }

    // Method to retrieve categories
    public function get_categories()
    {
        // Call the method from the getCategoryModel to retrieve categories
        $categories = $this->getCategoryModel->get_categories();

        // Set the response header to JSON format
        header('Content-Type: application/json');

        // Output categories data as JSON
        echo json_encode($categories);
    }
}
