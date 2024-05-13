<?php

class Model_user extends CI_Model
{
    function InsertUserData()
    {
        // Function to insert user data into the database

        // Retrieve user input data from POST request
        $data = array(
            'fname' => $this->input->post('fname', TRUE), // First name
            'lname' => $this->input->post('lname', TRUE), // Last name
            'email' => $this->input->post('email', TRUE), // Email
            'password' => sha1($this->input->post('password', TRUE)), // Password (hashed)
            // 'profile_pic' => $this->input->post('profile_pic', TRUE) // Profile picture (if required)
        );

        // Insert user data into the 'users' table in the database
        return $this->db->insert('users', $data); // Returns TRUE on success, FALSE on failure
    }

    function LoginUser()
    {
        /* Function to validate user login credentials */

        // Retrieve email and password from POST request
        $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));

        // Build query to check if the provided email and password match a record in the 'users' table
        $this->db->where('email', $email);
        $this->db->where('password', $password);

        // Execute the query
        $response = $this->db->get('users');

        // Check if the query returned exactly one row (indicating a successful login)
        if ($response->num_rows() == 1) {
            return $response->row(0); // Return the user data
        } else {
            return false; // Return false if login failed
        }
    }
}
