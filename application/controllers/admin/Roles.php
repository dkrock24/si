<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');  
		$this->load->library('../controllers/general');
		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Roles_model');		
		$this->load->model('accion/Accion_model');
	}

	public function index()
	{	
		$model = "Roles_model";
		$url_page = "admin/roles/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 3);

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];

		$data['registros'] = $this->Roles_model->getRoles( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['home'] = 'template/lista_template';
		$data['title'] = 'Roles';

		$this->parser->parse('template', $data);

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];
	}

	public function editar( $id_role )
	{	
		$id_rol = $this->session->roles;

		$data['menu'] 	= $this->session->menu;		
		$data['roles'] 	= $this->Roles_model->getRolesById( $id_role );		
		$data['home'] 	= 'admin/roles/roles_editar';
		$data['title'] 	= 'Editar Role';

		$this->general->editar_valido($data['roles'], "admin/roles/index");

		$this->parser->parse('template', $data);
	}

	public function update_roles()
	{	
		$data['roles'] = $this->Roles_model->setRoles( $_POST );	

		if($data){
			$this->session->set_flashdata('warning', "Rol Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Rol No Fue Actualizado");
		}
		
		redirect(base_url()."admin/roles/index");
	}

	public function copiar_rol(){

		$data['roles'] = $this->Roles_model->createRolCopia( $_POST );	

		if($data){
			$this->session->set_flashdata('warning', "Rol Fue Copiado");
		}else{
			$this->session->set_flashdata('danger', "Rol No Fue Copiado");
		}
		
		redirect(base_url()."admin/roles/index");
	}

	public function nuevo(){

		$id_rol = $this->session->roles;

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/roles/roles_nuevo';
		$data['title'] = 'Nuevo Role';

		$this->parser->parse('template', $data);
	}

	public function save_rol(){

		$data['role'] = $this->Roles_model->nuevo_rol( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Rol Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Rol No Fue Creado");
		}

		redirect(base_url()."admin/roles/index");
	}

	public function eliminar( $id_rol ){

		$data['role'] = $this->Roles_model->delete_rol( $id_rol );

		if($data){
			$this->session->set_flashdata('danger', "Eliminado Exitosamente");
		}else{
			$this->session->set_flashdata('warning', "No Fue Eliminada");
		}

		redirect(base_url()."admin/roles/index");
	}

	public function column(){

		$column = array(
			'Nombre','Pagina','Creacion','Actualizacion','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'role','pagina','fecha_creacion','fecha_actualizacion','estado'
		);
		
		$fields['id'] 		= array('id_rol');
		$fields['estado'] 	= array('estado_rol');
		$fields['titulo'] 	= "Roles Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
	
}
