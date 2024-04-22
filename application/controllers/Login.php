<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }


    public function LoginUser()
    {
        // Set up form validation rules
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');


        // Run form validation
        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show form again with validation errors
            // You can load a view to display the form with errors here
            $this->load->view('login');
            //echo "Validation failed!";
        } else {
            // Validation passed, process the form submission
            // You can access form data using $this->input->post() method
            // Example: $fname = $this->input->post('fname');
            // Here, you can process user registration, save data to database, etc.
            //echo "Validation passed!";
            //die();
            $this->load->model('Model_user');
            $result = $this->Model_user->LoginUser();
            if ($result != false) {
                //session
                $user_data = array(
                    'user_id' => $result->id,
                    'fname' => $result->fname,
                    'lname' => $result->lname,
                    'email' => $result->email,
                    'logedIn' => TRUE

                );
                $this->session->set_userdata($user_data);
                //print_r($_SESSION);
                $this->session->set_flashdata('welcome', 'Welcome');
                redirect('Admin/index');


            } else {
                //error
                $this->session->set_flashdata('errmsg', 'Wrong Username or password!');
                redirect('Home/login');
            }
        }
    }

    public function LogoutUser(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('fname');
        $this->session->unset_userdata('lname');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('logedIn');
        redirect('Home/Login');
    }
}