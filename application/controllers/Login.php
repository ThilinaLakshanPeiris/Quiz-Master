<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load form validation library
        $this->load->library('form_validation');
    }

    // Method to handle user login
    public function LoginUser()
    {
        // Set up form validation rules
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Run form validation
        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show login form again with validation errors
            $this->load->view('login');
        } else {
            // Validation passed, process the login
            $this->load->model('Model_user'); // Load model for user operations
            $result = $this->Model_user->LoginUser(); // Call method to authenticate user

            if ($result != false) {
                // If login successful, set session data and redirect to admin dashboard
                $user_data = array(
                    'user_id' => $result->id,
                    'fname' => $result->fname,
                    'lname' => $result->lname,
                    'email' => $result->email,
                    'logedIn' => TRUE
                );
                $this->session->set_userdata($user_data); // Set session data
                $this->session->set_flashdata('welcome', 'Welcome'); // Set flashdata
                redirect('Admin/index'); // Redirect to admin dashboard
            } else {
                // If login failed, redirect to login page with error message
                $this->session->set_flashdata('errmsg', 'Wrong Username or password!');
                redirect('Home/login');
            }
        }
    }

    // Method to handle user logout
    public function LogoutUser(){
        // Unset user session data and redirect to login page
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('fname');
        $this->session->unset_userdata('lname');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logedIn');
        redirect('Home/Login');
    }
}
