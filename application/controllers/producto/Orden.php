<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');

		$this->load->model('admin/Menu_model');
		$this->load->model('producto/Producto_model');	
		$this->load->model('admin/Giros_model');	
		$this->load->model('producto/Orden_model');
	}

	public function index()
	{	
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['tipoDocumento'] = $this->Orden_model->get_tipo_documentos();
		$data['sucursales'] = $this->Producto_model->get_sucursales();

		$data['home'] = 'producto/orden/orden_crear';

		$this->parser->parse('template', $data);
	}

	function get_productos_lista(){
		$data['productos'] = $this->Orden_model->get_productos_valor();
		echo json_encode( $data );
	}

	function get_producto_completo($producto_id){
		$data['producto'] = $this->Orden_model->get_producto_completo($producto_id);
		$data['precios'] = $this->Orden_model->get_producto_precios($producto_id);
		echo json_encode( $data );
	}

	
}
