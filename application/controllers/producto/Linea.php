<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linea extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');
		
		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Correlativo_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
		$this->load->model('producto/Linea_model');
	}

	public function index()
	{

		$model = "Linea_model";
		$url_page = "producto/linea/index";
		$pag = $this->MyPagination($model, $url_page, $vista = 26) ;
		
		$data['registros'] = $this->Linea_model->getLinea( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['home'] = 'template/lista_template';
		$data['title'] = 'Lineas';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/linea/linea_nuevo';
		$data['title'] = 'Crear Linea';

		$this->parser->parse('template', $data);
	}

	public function save_linea(){
		$data['bodegas'] = $this->Linea_model->save_linea( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Linea Fue Creada");
		}else{
			$this->session->set_flashdata('danger', "Linea No Fue Creada");
		}

		redirect(base_url()."producto/linea/index");
	}

	public function editar( $linea_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['lineas'] = $this->Linea_model->getLineaId( $linea_id );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/linea/linea_editar';
		$data['title'] = 'Editar Linea';

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data['bodegas'] = $this->Linea_model->update_linea( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Linea Fue Actualizada");
		}else{
			$this->session->set_flashdata('danger', "Linea No Fue Actualizada");
		}

		redirect(base_url()."producto/linea/index");
	}

	public function eliminar($id){

		$data['info'] = $data['bodegas'] = $this->Linea_model->eliminar_linea( $id );

		if($data){
			$this->session->set_flashdata('warning', "Linea Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Linea No Fue Eliminado");
		}

		redirect(base_url()."producto/linea/index");
	}

	public function column(){

		$column = array(
			'Tipo','Descripcion','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'tipo_producto','descripcion_tipo_producto','estado'
		);
		
		$fields['id'] = array('id_linea');
		$fields['estado'] = array('estado_linea');
		$fields['titulo'] = "Linea Lista";

		return $fields;
	}
}