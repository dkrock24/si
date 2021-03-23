<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bodega extends MY_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('../controllers/general');
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
		$this->load->model('producto/Bodega_model');
	}

	public function index()
	{
		$model 		= "Bodega_model";
		$url_page 	= "producto/bodega/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 20) ;

		$data['registros'] 		= $this->Bodega_model->getBodegas( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
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
		$data['title'] 			= "Bodegas";

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$data = $this->load->view('template/lista_template',$data, TRUE);
		echo $data;
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['sucursal'] = $this->Sucursal_model->getAllSucursalEmpresa();
		$data['home'] = 'producto/bodega/bodega_nuevo';
		$data['title'] = "Nueva Bodega";

		$this->parser->parse('template', $data);
	}

	public function save_bodega(){

		$data['bodegas'] = $this->Bodega_model->saveBodegas( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Bodega Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Bodega No Fue Creado : ". $data['message']);
		}

		redirect(base_url()."producto/bodega/index");
	}

	public function editar($bodega_id){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;

		$data['menu'] = $this->session->menu;
		//$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['bodega'] = $this->Bodega_model->getBodegaById($bodega_id);
		$data['sucursal'] = $this->Sucursal_model->getAllSucursalEmpresa();
		$data['home'] = 'producto/bodega/bodega_editar';
		$data['title'] = "Editar Bodega";

		$this->general->editar_valido($data['bodega'], "producto/bodega/index");

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."producto/bodega/index");
		}

		$data['title'] = "Ver";

		$data['home'] = 'template/ver_general';

		$data['menu'] = $this->session->menu;		

		$data['data'] = $this->Bodega_model->getBodegaById( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."producto/bodega/index");
		}

	}

	public function update_bodega(){

		$data['bodegas'] = $this->Bodega_model->update_bodega( $_POST );

		if($data){
			$this->session->set_flashdata('info', "Bodega Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Bodega No Fue Actualizado : ". $data['message']);
		}

		redirect(base_url()."producto/bodega/index");
	}

	public function eliminar($id){
		$data = $this->Bodega_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Eliminado Exitosamente");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "No Fue Eliminada : ". $data['message']);
		}
		redirect(base_url()."producto/bodega/index");
	}

	public function column(){

		$column = array(
			'Empresa', 'Sucursal','Nombre Bodega','Direccion','Encargado','Predefinida', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_comercial' => 'Empresa'],
			['nombre_sucursal' => 'Sucursal'],
			['nombre_bodega' => 'Nombre'],
			['direccion_bodega' => 'Direccion'],
			['encargado_bodega' => 'Encargado'],
			['predeterminada_bodega' => 'Predefinida'],
			['orden_estado_nombre' => 'Estado'],
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_bodega');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Bodega Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}