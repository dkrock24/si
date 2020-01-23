<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Correlativo extends MY_Controller {

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
		$this->load->library('../controllers/general');

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
		$this->load->model('admin/Documento_model');
	}

	public function index()
	{

		$model = "Correlativo_model";
		$url_page = "producto/correlativo/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 28);

		
		$data['registros'] = $this->Correlativo_model->getCorrelativos(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();		
		$data['title'] = "Correlativos";

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] = "Nuevo Correlativo";
		$data['home'] = 'producto/correlativo/c_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$data['bodegas'] = $this->Correlativo_model->save( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Correlativo Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Correlativo No Fue Creado");
		}

		redirect(base_url()."producto/correlativo/index");
	}

	public function editar( $correlatiov_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		
		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['correlativo'] = $this->Correlativo_model->editar( $correlatiov_id );
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] = "Editar Correlativo";
		$data['home'] = 'producto/correlativo/c_editar';

		$this->general->editar_valido($data['correlativo'], "producto/correlativo/index");

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."producto/correlativo/index");
		}

		$data['title'] = "Ver";

		$data['home'] = 'template/ver_general';

		$data['menu'] = $this->session->menu;		

		$data['data'] = $this->Correlativo_model->editar( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."producto/correlativo/index");
		}

	}

	public function update(){

		$data['bodegas'] = $this->Correlativo_model->update( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Correlativo Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Correlativo No Fue Actualizado");
		}

		redirect(base_url()."producto/correlativo/index");
	}

	public function eliminar($id){

		$data['correlativo'] = $this->Correlativo_model->delete( $id );

		if($data){
			$this->session->set_flashdata('warning', "Correlativo Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Correlativo No Fue Eliminado");
		}

		redirect(base_url()."producto/correlativo/index");
	}

	public function column(){

		$column = array(
			'Sucursal','Documento','Inicial','Final','Siguiente','Prefix','Serie','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_sucursal','nombre','valor_inical','valor_final','siguiente_valor','prefix','numero_de_serire','fecha_creacion','estado'
		);
		
		$fields['id'] = array('id_correlativos');
		$fields['estado'] = array('correlativo_estado');
		$fields['titulo'] = "Correlativos Lista";

		return $fields;
	}
	
	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}