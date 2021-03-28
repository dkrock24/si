<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Param extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database(); 
		$this->load->helper('url');
		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->model('admin/Param_model');
	}

	public function index( $index = 1 ){
		$data['menu'] 	= $this->session->menu;
		$data['modulo'] = $this->Param_model->get_modulos();
		$data['config'] = $this->Param_model->get_modulos_conf( $index );
		$data['total'] 	= $this->Param_model->record_count();
		$data['title'] 	= "Parametros";
		$data['home'] 	= 'admin/param/vParam';

		echo $this->load->view('admin/param/vParam',$data, TRUE);
	}

	public function nuevo_config(){
		$this->Param_model->save_params($_POST);
		redirect(base_url()."admin/param/index");
	}

	public function update(){
		$this->Param_model->update_params($_POST);
		redirect(base_url()."admin/param/index");
	}

	public function delete_params(){
		$this->Param_model->delete_params($_POST);
		redirect(base_url()."admin/param/index");
	}

	public function get_params(){
		$data['conf'] 	= $this->Param_model->get_params($_POST['id']);
		$data['modulo'] = $this->Param_model->get_modulos();
		echo json_encode($data);
	}

	public function nuevo_modulo(){
		$this->Param_model->save_modulo($_POST);
		redirect(base_url()."admin/param/index");
	}

	public function get_modulo(){
		$data['modulo'] = $this->Param_model->get_modulos_id($_POST['id']);
		echo json_encode($data);
	}

	public function update_modulo(){
		$this->Param_model->update_modulo($_POST);
		redirect(base_url()."admin/param/index");
	}
	
}