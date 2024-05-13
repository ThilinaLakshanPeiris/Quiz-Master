<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    // Constructor method
	public function __construct()
	{
		parent::__construct();
		// Load necessary libraries and models here (not shown in this example)
	}

    // Method to load the home view
	public function index()
	{
		$this->load->view('home'); // Load the 'home' view
	}

    // Method to load the login view
	public function login()
	{
		$this->load->view('login'); // Load the 'login' view
	}

    // Method to load the register view
	public function register()
	{
		$this->load->view('register'); // Load the 'register' view
	}
}
