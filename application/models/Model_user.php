<?php

class Model_user extends CI_Model
{
    function InsertUserData()
    {
        //echo "Model_user";
        //die();

        $data = array(

            'fname' => $this->input->post('fname', TRUE),
            'lname' => $this->input->post('lname', TRUE),
            'email' => $this->input->post('email', TRUE),
            'password' => sha1($this->input->post('password', TRUE))
        );
        // print_r($data);
        // die();

        return $this->db->insert('users', $data);
        //return false;
    }

    function LoginUser()
    {
        /* database email and paaaword check
         if exist->session create
         else error 
        */

        //query string
        $email = $this->input->post('email');
        $password = sha1($this->input->post('password'));

        $this->db->where('email',$email);
        $this->db->where('password',$password);

        $respond = $this->db->get('users');
        if($respond->num_rows()==1){
            //print_r($respond->row(0));
            return $respond->row(0);
        }
        else{
            //echo "error";
            //die();
            return false;
        }

    }
}