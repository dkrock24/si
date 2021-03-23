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
		$model 		= "Roles_model";
		$url_page 	= "admin/roles/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 3);

		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );
		$data['menu'] 		= $this->session->menu;
		$data['links'] 		= $pag['links'];
		$data['filtros'] 	= $pag['field'];		
		$data['column'] 	= $this->column();
		$data['fields'] 	= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records']	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];

		$data['registros'] 	= $this->Roles_model->getRoles( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['home'] 		= 'template/lista_template';
		$data['title'] 		= 'Roles';

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$data = $this->load->view('template/lista_template',$data, TRUE);
		echo $data;
	}

	public function editar( $id_role )
	{	
		$data['menu'] 	= $this->session->menu;		
		$data['roles'] 	= $this->Roles_model->getRolesById( $id_role );		
		$data['home'] 	= 'admin/roles/roles_editar';
		$data['title'] 	= 'Editar Role';

		$this->general->editar_valido($data['roles'], "admin/roles/index");

		$this->parser->parse('template', $data);
	}

	public function update_roles()
	{	
		$data = $this->Roles_model->setRoles( $_POST );	

		if(!$data['code']){
			$this->session->set_flashdata('info', "Rol Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Rol No Fue Actualizado : ". $data['message']);
		}

		redirect(base_url()."admin/roles/index");
	}

	public function copiar_rol(){

		$data['roles'] = $this->Roles_model->createRolCopia( $_POST );	

		if(!$data['code']){
			$this->session->set_flashdata('info', "Rol Fue Copiado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Rol No Fue Copiado : ". $data['message']);
		}
		
		redirect(base_url()."admin/roles/index");
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/roles/roles_nuevo';
		$data['title'] = 'Nuevo Role';

		$this->parser->parse('template', $data);
	}

	public function save_rol(){

		$data = $this->Roles_model->nuevo_rol( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Rol Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Rol No Fue Creado : ". $data['message']);
		}

		redirect(base_url()."admin/roles/index");
	}

	public function eliminar( $id_rol ){

		$data = $this->Roles_model->delete_rol( $id_rol );
		if(!$data['code']){
			$this->session->set_flashdata('warning', "Eliminado Exitosamente");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."admin/roles/index");
	}

	public function column(){

		$column = array(
			'Nombre','Pagina','Creado','Actualizado','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['role' => 'Nombre'],
			['pagina' => 'Pagina'],
			['fecha_creacion' => 'Creacion'],
			['fecha_actualizacion' => 'Actualizacion'],
			['orden_estado_nombre' => 'Estado'],
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_rol');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Roles Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
	
}
