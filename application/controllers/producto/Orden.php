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
		$this->load->helper('seguridad/url_helper');
		$this->load->model('accion/Accion_model');	

		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Correlativo_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
	}

	public function index()
	{	
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['prod'] = $this->Producto_model->getProd( );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/orden/orden_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$id_usuario = $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['tipoDocumento'] = $this->Orden_model->get_tipo_documentos();
		$data['sucursales'] = $this->Producto_model->get_sucursales();
		$data['modo_pago'] = $this->ModoPago_model->get_formas_pago();
		$data['empleado'] = $this->Usuario_model->get_empleado( $id_usuario );
		$data['correlativo'] = $this->Correlativo_model->get_correlativo_by_sucursal( $id_usuario);

		$data['home'] = 'producto/orden/orden_crear';

		$this->parser->parse('template', $data);
	}

	function get_productos_lista( $sucursal ){
		$data['productos'] = $this->Orden_model->get_productos_valor($sucursal);
		echo json_encode( $data );
	}

	function get_clientes_lista(){
		$data['clientes'] = $this->Cliente_model->get_cliente();
		echo json_encode( $data );
	}

	function get_empleados_by_sucursal($sucursal){
		$data['empleados'] = $this->Usuario_model->get_empleados_by_sucursal($sucursal);
		echo json_encode( $data );
	}

	function get_producto_completo($producto_id){
		$data['producto'] = $this->Orden_model->get_producto_completo($producto_id);
		$data['precios'] = $this->Orden_model->get_producto_precios($producto_id);
		$data['prod_precio'] = $this->Orden_model->get_producto_precios( $producto_id );
		echo json_encode( $data );
	}

	
}
