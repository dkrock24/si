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
		$this->load->library('pagination');
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
		$this->load->model('admin/Moneda_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Combo_model');
		$this->load->model('producto/Orden_model');
		$this->load->model('producto/Linea_model');

	}

	public function index()
	{

		//Paginacion
		$contador_tabla;
		$_SESSION['per_page'] = "";
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Combo_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "producto/combo/index");
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
		$vista_id = 2; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		
		
		
		$param = ['combo'=>1];
		$data['combos'] = $this->Combo_model->get_producto_combo( $param );

		//$data['home'] = 'producto/combo/combo_lista';
		$data['title'] = "Combos";
		$data['home'] = 'producto/combo/combo_lista';

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['contador_tabla'] = $contador_tabla;
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['registros'] = $this->Combo_model->getAllCombo( $config["per_page"], $page );
		$data['title'] = "Terminales";
		$data['home'] = 'template/lista_template';

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
		$param1 = ['combo'=>1];
		$param2 = ['combo'=>0];
		$data['productos_combo'] = $this->Producto_model->get_producto_tabla($param1);
		$data['productos'] = $this->Producto_model->get_producto_tabla($param2);
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] = "Nuevo Combo";
		$data['home'] = 'producto/combo/combo_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$data['bodegas'] = $this->Combo_model->save_Combo( $_POST );

		redirect(base_url()."producto/combo/nuevo");
	}

	public function editar( $combo_id ){

		$param1 = ['combo'=>1];

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['combo'] = $this->Combo_model->getComboId( $combo_id );
		$data['productos'] = $this->Producto_model->get_producto_tabla( $param1 );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] = "Editar Combo";
		$data['home'] = 'producto/combo/combo_editar';

		$this->parser->parse('template', $data);
	}

	public function ver($combo_id){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 2; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['column'] = $this->column();
		$data['combos'] = $this->Combo_model->getComboId( $combo_id );
		$data['precio'] = $this->Orden_model->get_producto_precios( $combo_id );
		$data['moneda'] = $this->Moneda_model->get_modena_by_user();
		

		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		//$data['home'] = 'producto/combo/combo_lista';
		$data['home'] = 'producto/combo/combo_ver';

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
			'Producto Combo','Productos Agregados','Combo Cantidad'
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