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

		$model 		= "Linea_model";
		$url_page 	= "producto/linea/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 26) ;
		
		$data['registros'] 		= $this->Linea_model->getLinea( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= 'Lineas';

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] 	= $this->session->menu;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 	= 'producto/linea/linea_nuevo';
		$data['title'] 	= 'Crear Linea';

		echo $this->load->view('producto/linea/linea_nuevo',$data, TRUE);
	}

	public function crear(){
		$data = $this->Linea_model->save_linea( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Linea Fue Creada");
		}else{
			$this->session->set_flashdata('danger', "Linea No Fue Creada : ". $data['message']);
		}

		redirect(base_url()."producto/linea/index");
	}

	public function editar( $linea_id ){

		$id_rol 	= $this->session->roles[0];
		$vista_id 	= 20; // Vista Orden Lista

		$data['title'] 	= 'Editar Linea';
		$data['menu'] 	= $this->session->menu;
		$data['home'] 	= 'producto/linea/linea_editar';
		$data['lineas'] = $this->Linea_model->getLineaId( $linea_id );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$this->general->editar_valido($data['lineas'], "producto/linea/index");

		echo $this->load->view('producto/linea/linea_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."producto/linea/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Linea_model->getLineaId( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."producto/linea/index");
		}

	}

	public function update(){

		$data = $this->Linea_model->update_linea( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Linea Fue Actualizada");
		}else{
			$this->session->set_flashdata('danger', "Linea No Fue Actualizada : ". $data['message']);
		}

		redirect(base_url()."producto/linea/index");
	}

	public function eliminar($id){

		$data = $this->Linea_model->eliminar_linea( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Linea Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Linea No Fue Eliminado : ". $data['message']);
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
			['tipo_producto' => 'Tipo'],
			['descripcion_tipo_producto' => 'Descripcion'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_linea');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Linea Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}