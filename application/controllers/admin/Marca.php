<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca extends CI_Controller {

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

		$this->load->model('admin/Menu_model');	
		$this->load->model('admin/Categorias_model');	
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Marca_model');
	}

	public function index()
	{	
		//Paginacion
		$contador_tabla;
		$_SESSION['per_page'] = "";
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Marca_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/marca/index");
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
		$vista_id = 29; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Marca_model->getMarca( $config["per_page"], $page );
		$data['title'] = "Marcas";	
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function editar( $marca_id )
	{	
		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['marca'] = $this->Marca_model->getMarcaById( $marca_id );
		$data['title'] = "Editar Marca";	
		$data['home'] = 'admin/marca/m_editar';

		$this->general->editar_valido($data['marca'], "admin/marca/index");

		$this->parser->parse('template', $data);
	}

	public function update()
	{	
		$data['documento'] = $this->Marca_model->setMarca( $_POST );	

		if($data){
			$this->session->set_flashdata('success', "Marca Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Marca No Fue Actualizado");
		}
		
		redirect(base_url()."admin/marca/index");
	}

	public function nuevo(){

		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['categoria'] = $this->Marca_model->get_marcas();
		$data['marca'] = $this->Marca_model->getAllMarca();
		$data['marca_categoria'] = $this->Marca_model->marca_categoria();
		$data['title'] = "Nueva Marca";	
		$data['home'] = 'admin/marca/m_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$data = $this->Marca_model->nuevo_marca( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Marca Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Marca No Fue Creado");
		}
		redirect(base_url()."admin/marca/index");
	}

	public function save_categoria_marca(){
		$val = $this->Marca_model->save_categoria_marca( $_POST );
		echo json_encode($val);
	}

	public function delete_categoria_marca($id){
		$this->Marca_model->delete_categoria_marca( $id );
	}

	public function eliminar($id){
		$data = $this->Marca_model->eliminar_marca( $id );

		if($data){
			$this->session->set_flashdata('success', "Marca Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Marca No Fue Eliminado");
		}

		redirect(base_url()."admin/marca/index");
	}

	public function delete( $id_rol ){
		$this->Roles_model->delete_rol( $id_rol );
		redirect(base_url()."admin/roles/index");
	}

	public function column(){

		$column = array(
			'Nombre','Descripcion','Creado','Actualizado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_marca','descripcion_marca','fecha_creado_marca','fecha_atualizado_marca','estado'
		);
		
		$fields['id'] = array('id_marca');
		$fields['estado'] = array('estado_marca');
		$fields['titulo'] = "Marcas Lista";

		return $fields;
	}

	
}
