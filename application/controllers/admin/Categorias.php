<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    @$this->load->library('session');	
	    $this->load->library('pagination');
	    $this->load->library('../controllers/general');    

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Categorias_model');
		$this->load->model('admin/Marca_model');
		$this->load->model('admin/Empresa_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Giros_model');
	}

	public function index(){

		$model 		= "Categorias_model";
		$url_page 	= "admin/categorias/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 11);

		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 	= $this->Categorias_model->get_categorias(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= "Categorias";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){
		$data['title'] 		= "Crear Categoria";
		$data['menu'] 		= $this->session->menu;
		$data['marcas'] 	= $this->Marca_model->getAllMarca();
		$data['giros'] 		= $this->Giros_model->getAllgiros();
		$data['home'] 		= 'admin/categorias/categorias_nuevo';
		$data['categorias']	= $this->Categorias_model->get_categorias_padres();

		echo $this->load->view('admin/categorias/categorias_nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Categorias_model->crear_categoria( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Categoria Fue Creada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Categoria No Fue Creada :". $data['message']);
		}

		redirect(base_url()."admin/categorias/index");
	}

	public function editar( $id_categoria ){

		$data['menu'] 		= $this->session->menu;
		$data['categorias'] = $this->Categorias_model->get_categoria_id( $id_categoria );
		$data['categorias_padres']	= $this->Categorias_model->get_categorias_padres();
		$data['giros'] 		= $this->Giros_model->getAllgiros();
		$data['home'] 		= 'admin/categorias/categorias_editar';
		$data['title'] 		= "Editar Categoria";

		$this->general->editar_valido($data['categorias'], "admin/categorias/index");

		echo $this->load->view('admin/categorias/categorias_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/categorias/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Categorias_model->get_categoria_id( $id );
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/categorias/index");
		}
	}

	public function update(){
		$data = $this->Categorias_model->actualizar_categoria( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Categoria Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Categoria No Fue Actualizada :". $data['message']);
		}

		redirect(base_url()."admin/categorias/index");
	}

	public function eliminar($id){
		
		$data =$this->Categorias_model->delete_categoria( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Categoria Fue Eliminada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Categoria No Fue Eliminada :". $data['message']);
		}
		redirect(base_url()."admin/categorias/index");
	}

	public function column(){

		$column = array(
			'Categoria','Sub Categoria','Giro','Empresa','Creado', 'Actualizado', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_categoria' => 'Categoria'],
			['cat_padre' => 'Sub Categoria'],
			['nombre_giro' => 'Giro'],
			['nombre_comercial' => 'Empresa'],
			['creado_categoria' => 'Creado'],
			['actualizado_categoria' => 'Actualizado'],
			['orden_estado_nombre' => 'Estado'],
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_categoria');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Categoria Lista";

		return $fields;
	}

	function export(){
		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );
	}
	
}

?>