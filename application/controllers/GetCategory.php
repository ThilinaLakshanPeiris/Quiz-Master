<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetCategory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('getCategoryModel');
    }

    public function get_categories()
    {

        $categories = $this->getCategoryModel->get_categories();

        header('Content-Type: application/json');
        echo json_encode($categories);
    }
}
