<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codigo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    $this->load->library('../controllers/general');
		$this->load->helper('url');
	}

	public function index($code = 0){
        $this->load->view('codigo');
	}
}