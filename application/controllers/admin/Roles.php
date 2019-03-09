<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');  

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Menu_model');	
		$this->load->model('accion/Accion_model');
	}

	public function index()
	{	
		//Paginacion
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Roles_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/roles/index");
		$this->pagination->initialize($config);
		if($this->uri->segment(4)){
			if($_SESSION['per_page']!=0){
				$page = ($this->uri->segment(4) - 1 ) * $_SESSION['per_page'];
				$contador_tabla = $page+1;
			}else{
				$page = 0;
				$contador_tabla =1;
			}
		}else{
			$page = 0;
			$contador_tabla =1;
		}

		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );

		// paginacion End


		$id_rol = $this->session->roles[0];

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Roles_model->getRoles( $config["per_page"], $page );
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
