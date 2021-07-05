<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nodo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    $this->load->library('../controllers/general');
		$this->load->helper('url');	
	}

	public function index($key = 0){

		$this->load->view('nodo');
	}
}
