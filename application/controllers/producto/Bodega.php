<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bodega extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
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
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['bodegas'] = $this->Bodega_model->getBodegas( $id_usuario );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/bodega/bodega_lista';

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
}