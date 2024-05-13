<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load form validation library
        $this->load->library('form_validation');
    }

    // Method to handle user registration
    public function RegisterUser()
    {
        // Set up form validation rules
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('conpassword', 'Confirm Password', 'required|matches[password]');

        // Run form validation
        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show registration form again with validation errors
            $this->load->view('register');
        } else {
            // Validation passed, process the registration
            $this->load->model('Model_user'); // Load model for user operations
            $response = $this->Model_user->InsertUserData(); // Call method to insert user data

            // Check registration response
            if ($response) {
                // If registration successful, set flash message and redirect to login page
                $this->session->set_flashdata('msg', 'Successfully Registered. Please Login.');
                redirect('Home/login');
            } else {
                // If registration failed, set flash message and redirect back to registration page
                $this->session->set_flashdata('msg', 'Something went wrong!');
                redirect('Home/register');
            }
        }
    }
}
