<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Existencias extends CI_Controller {

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
		$this->load->model('producto/Existencias_model');
		$this->load->model('producto/Orden_model');
		$this->load->model('producto/Codbarra_model');
		
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
		$data['codbarra'] = $this->Codbarra_model->getCodbarra( );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/existencias/codbarra_lista';

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
		$data['home'] = 'producto/existencias/exis_nuevo';

		$this->parser->parse('template', $data);
	}

	function get_productos_lista( $sucursal , $texto ){
		$data['productos'] = $this->Orden_model->get_productos_valor($sucursal , $texto);
		echo json_encode( $data );
	}

	function get_producto_completo($producto_id){
		$data['producto'] = $this->Existencias_model->get_producto_completo($producto_id);
		//$data['precios'] = $this->Orden_model->get_producto_precios($producto_id);
		//$data['prod_precio'] = $this->Orden_model->get_producto_precios( $producto_id );
		echo json_encode( $data );
	}

	public function save(){
		$data['bodegas'] = $this->Codbarra_model->save_Codbarra( $_POST );

		redirect(base_url()."producto/existencias/nuevo");
	}

	public function editar( $codbarra_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['codbarra'] = $this->Codbarra_model->getCodbarraId( $codbarra_id );
		$data['productos'] = $this->Producto_model->get_producto_tabla();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/existencias/codbarra_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data['bodegas'] = $this->Codbarra_model->update_codbarra( $_POST );

		redirect(base_url()."producto/existencias/index");
	}

	public function get_productos_id( $producto_id ){
		$data['productos'] = $this->Producto_model->get_productos_id( $producto_id );
		echo json_encode($data);
	}
}