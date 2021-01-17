<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database();    
	}

	public function index()
	{
		// Construir Menu
		$id_rol = $_SESSION['usuario']['login'][0]->rol;	

		$this->load->model('admin/Menu_model');
		$this->load->model('Login_model');

		$data['user'] = $this->Login_model->usuarios();
		$data['menu'] = $this->session->menu;

		$this->load->view('home', $data);
	}
}