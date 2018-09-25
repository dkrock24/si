<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Menu_model');	
	}

	public function index()
	{	
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['roles'] = $this->Roles_model->getRoles( );
		$data['home'] = 'admin/roles/roles_lista';

		$this->parser->parse('template', $data);
	}

	public function editar_role( $id_role )
	{	
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['roles'] = $this->Roles_model->getRolesById( $id_role );
		$data['home'] = 'admin/roles/roles_editar';

		$this->parser->parse('template', $data);
	}

	public function update_roles()
	{	
		$data['roles'] = $this->Roles_model->setRoles( $_POST );	
		
		redirect(base_url()."admin/roles/index");
	}
	
}
