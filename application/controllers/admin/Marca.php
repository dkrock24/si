<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marca extends MY_Controller {

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
		$model 		= "Marca_model";
		$url_page 	= "admin/marca/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 29);
		
		$data['registros'] = $this->Marca_model->getMarca($pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );		
		$data['title'] 			= "Marcas";	
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function editar( $marca_id )
	{	
		$data['menu'] 	= $this->session->menu;
		$data['marca'] 	= $this->Marca_model->getMarcaById( $marca_id );
		$data['title'] 	= "Editar Marca";	
		$data['home'] 	= 'admin/marca/m_editar';

		$this->general->editar_valido($data['marca'], "admin/marca/index");
		echo $this->load->view('admin/marca/m_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/marca/index");
		}

		$data['title'] 	= "Ver";
		$data['home'] 	= 'template/ver_general';
		$data['menu'] 	= $this->session->menu;
		$data['data'] 	= $this->Marca_model->getMarcaById( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/marca/index");
		}
	}

	public function update()
	{	
		$data = $this->Marca_model->setMarca( $_POST );	

		if(!$data['code']){
			$this->session->set_flashdata('info', "Marca Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Marca No Fue Actualizado : ". $data['message']);
		}
		
		redirect(base_url()."admin/marca/index");
	}

	public function nuevo(){

		$data['title'] 		= "Nueva Marca";	
		$data['home'] 		= 'admin/marca/m_nuevo';
		$data['menu'] 		= $this->session->menu;
		$data['categoria'] 	= $this->Categorias_model->get_all_categorias();
		$data['marca'] 		= $this->Marca_model->getAllMarca();
		$data['marca_categoria'] = $this->Marca_model->marca_categoria();

		echo $this->load->view('admin/marca/m_nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Marca_model->nuevo_marca( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Marca Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Marca No Fue Creado : ". $data['message']);
		}
		redirect(base_url()."admin/marca/nuevo");
	}

	public function save_categoria_marca(){
		$val = $this->Marca_model->save_categoria_marca( $_POST );
		$data = $this->Marca_model->marca_categoria();
		echo json_encode($data);
	}

	public function delete_categoria_marca($id){
		$this->Marca_model->delete_categoria_marca( $id );
		$data = $this->Marca_model->marca_categoria();
		echo json_encode($data);
	}

	public function eliminar($id){

		$data = $this->Marca_model->eliminar_marca( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Marca Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Marca No Fue Eliminado : ". $data['message']);
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
			['nombre_marca' => 'Nombre'],
			['descripcion_marca' => 'Descripcion'],
			['fecha_creado_marca' => 'Creado'],
			['fecha_atualizado_marca' => 'Actualizado'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_marca');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Marcas Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}

	
}
