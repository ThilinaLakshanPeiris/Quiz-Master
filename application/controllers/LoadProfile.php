<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoadProfile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load necessary libraries and models here
        $this->load->model('loadProfileData'); // Load model for loading profile data
    }

    // Method to load user profile data
    public function load_profile($id)
    {
        // Call the method from the loadProfileData model to retrieve user info by ID
        $profileData = $this->loadProfileData->get_user_info($id);

        // Prepare data to be passed to the view
        $data['profileData'] = $profileData;

        // Load the 'myProfile' view with profile data
        $this->load->view('Admin/myProfile', $data);
    }
}
