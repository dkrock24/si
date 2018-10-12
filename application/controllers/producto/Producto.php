<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Menu_model');	

		$this->load->model('producto/Producto_model');	
	}

	public function index()
	{	
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['prod'] = $this->Producto_model->getProd( );

		$data['home'] = 'producto/producto/prod_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );

		$data['home'] = 'producto/producto/prod_nuevo';

		$this->parser->parse('template', $data);
	}
	
}
