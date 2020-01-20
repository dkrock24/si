<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combo extends MY_Controller {

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

		$model = "Combo_model";
		$url_page = "producto/combo/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 39);

		$param = ['combo'=>1];
		$data['combos'] = $this->Combo_model->get_producto_combo( $param );

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']);
		$data['registros'] = $this->Combo_model->getAllCombo( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
		$data['title'] = "Combos Lista";
		$data['home'] = 'template/lista_template';

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		
		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista

		$data['menu'] 	= $this->session->menu;
		$param1 		= ['combo'=>1];
		$param2 		= ['combo'=>0];
		$data['productos_combo'] = $this->Producto_model->get_producto_tabla($param1);
		$data['productos'] 	= $this->Producto_model->get_producto_tabla($param2);
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] 		= "Nuevo Combo";
		$data['home'] 		= 'producto/combo/combo_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){

		$data = $this->Combo_model->save_Combo( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Combo Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Combo No Fue Creado");
		}

		redirect(base_url()."producto/combo/nuevo");
	}

	public function editar( $combo_id ){

		$param1 = ['combo'=>1];

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;
		
		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['combo'] = $this->Combo_model->getComboId( $combo_id );
		$data['productos'] = $this->Producto_model->get_producto_tabla( $param1 );
		$data['productos_2'] = $this->Producto_model->get_producto_tabla2( $param1 );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] = "Editar Combo";
		$data['home'] = 'producto/combo/combo_editar';

		$this->parser->parse('template', $data);
	}

	public function ver($combo_id){
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		
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

		$data = $this->Combo_model->update_combo( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Combo Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Combo No Fue Actualizado");
		}

		redirect(base_url()."producto/combo/index");
	}

	public function get_productos_id( $producto_id ){
		$data['productos'] = $this->Producto_model->get_productos_id( $producto_id );
		echo json_encode($data);
	}

	public function get_productos_codigo( $producto_codigo ){

		$data['productos'] = $this->Producto_model->get_productos_codigo( $producto_codigo );
		echo json_encode($data);
	}

	

	public function eliminar($id){

		$data = $this->Combo_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('success', "Combo Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Combo No Fue Eliminado");
		}

		redirect(base_url()."producto/combo/index");

	}

	public function column(){

		$column = array(
			'Producto Combo','Combo Cantidad'
		);

		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'name_entidad','total'
		);
		
		$fields['id'] = array('Producto_Combo');
		$fields['estado'] = '';
		$fields['titulo'] = "Combo Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}