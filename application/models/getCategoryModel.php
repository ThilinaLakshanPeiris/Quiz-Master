<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetCategoryModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries here
        $this->load->database();
    }

    public function get_categories()
    {
        $query = $this->db->get('category');
        return $query->result();
    }
}
