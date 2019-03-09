<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bodega extends CI_Controller {

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
		$this->load->model('producto/Bodega_model');
	}

	public function index()
	{
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

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
		
		$total_row = $this->Bodega_model->record_count($id_usuario);
		
		$config = paginacion($total_row, $_SESSION['per_page'] , "producto/bodega/index");
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

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);
		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['registros'] = $this->Bodega_model->getBodegas( $id_usuario ,$config["per_page"], $page);
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['home'] = 'producto/bodega/bodega_nuevo';

		$this->parser->parse('template', $data);
	}

	function save_bodega(){

		$data['bodegas'] = $this->Bodega_model->saveBodegas( $_POST );

		redirect(base_url()."producto/bodega/index");
	}

	function editar($bodega_id){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		//$id_rol = $this->session->roles[0];
		//$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		//$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['bodega'] = $this->Bodega_model->getBodegaById($bodega_id);
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['home'] = 'producto/bodega/bodega_editar';

		$this->parser->parse('template', $data);
	}

	function update_bodega(){

		$data['bodegas'] = $this->Bodega_model->update_bodega( $_POST );

		redirect(base_url()."producto/bodega/index");
	}

	public function column(){

		$column = array(
			'#','Nombre','Direccion','Encargado','Predefinida','Empresa', 'Sucursal', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_bodega','direccion_bodega','encargado_bodega','predeterminada_bodega','nombre_comercial','nombre_sucursal','estado'
		);
		
		$fields['id'] = array('id_bodega');
		$fields['estado'] = array('bodega_estado');
		$fields['titulo'] = "Bodega Lista";

		return $fields;
	}
}