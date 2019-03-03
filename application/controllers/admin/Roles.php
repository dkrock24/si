<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Menu_model');	
		$this->load->model('accion/Accion_model');
	}

	public function index()
	{	
		$id_rol = $this->session->roles[0];

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Roles_model->getRoles( );
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function editar_role( $id_role )
	{	
		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['roles'] = $this->Roles_model->getRolesById( $id_role );
		$data['home'] = 'admin/roles/roles_editar';

		$this->parser->parse('template', $data);
	}

	public function update_roles()
	{	
		$data['roles'] = $this->Roles_model->setRoles( $_POST );	
		
		redirect(base_url()."admin/roles/index");
	}

	public function nuevo(){

		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
						//$this->Roles_model->nuevo_rol( $_POST );
		$data['home'] = 'admin/roles/roles_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save_rol(){
		$this->Roles_model->nuevo_rol( $_POST );
		redirect(base_url()."admin/roles/index");
	}

	public function delete( $id_rol ){
		$this->Roles_model->delete_rol( $id_rol );
		redirect(base_url()."admin/roles/index");
	}

	public function column(){

		$column = array(
			'#','Nombre','Pagina','Creacion','Actualizacion','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'role','pagina','fecha_creacion','fecha_actualizacion','estado'
		);
		
		$fields['id'] = array('id_rol');
		$fields['estado'] = array('estado_rol');
		$fields['titulo'] = "Roles Lista";

		return $fields;
	}

	
}
