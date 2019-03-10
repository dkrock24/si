<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combo extends CI_Controller {

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
		$this->load->model('producto/Combo_model');
		$this->load->model('producto/Linea_model');
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
		$data['column'] = $this->column();
		$data['combos'] = $this->Combo_model->getCombo( );
		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		//$data['home'] = 'producto/combo/combo_lista';
		$data['home'] = 'producto/combo/combo_lista';

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
		$data['productos'] = $this->Producto_model->get_producto_tabla();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/combo/combo_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$data['bodegas'] = $this->Combo_model->save_Combo( $_POST );

		redirect(base_url()."producto/combo/nuevo");
	}

	public function editar( $combo_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['combo'] = $this->Combo_model->getComboId( $combo_id );
		$data['productos'] = $this->Producto_model->get_producto_tabla();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/combo/combo_editar';

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data['bodegas'] = $this->Combo_model->update_combo( $_POST );

		redirect(base_url()."producto/combo/index");
	}

	public function get_productos_id( $producto_id ){
		$data['productos'] = $this->Producto_model->get_productos_id( $producto_id );
		echo json_encode($data);
	}

	public function column(){

		$column = array(
			'#','Producto','Agregados','Cantidad'
		);

		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'uno','dos','cantidad'
		);
		
		$fields['id'] = array('Producto_Combo');
		$fields['estado'] = '';
		$fields['titulo'] = "Combo Lista";

		return $fields;
	}
}