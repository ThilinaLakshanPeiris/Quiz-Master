<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }


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
            // Validation failed, show form again with validation errors
            // You can load a view to display the form with errors here
            $this->load->view('register');
            //echo "Validation failed!";
        } else {
            // Validation passed, process the form submission
            // You can access form data using $this->input->post() method
            // Example: $fname = $this->input->post('fname');
            // Here, you can process user registration, save data to database, etc.
            //echo "Validation passed!";
            //die();
            $this->load->model('Model_user');
            $response = $this->Model_user->InsertUserData();
            if ($response) {
                $this->session->set_flashdata('msg', 'Successfuly Registerd. Please Login.');
                redirect('Home/login');
            } else {
                $this->session->set_flashdata('msg', 'Something went wrong!');
                redirect('Home/register');
            }
        }
    }
}