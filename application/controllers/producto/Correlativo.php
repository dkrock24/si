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

		$model 		= "Correlativo_model";
		$url_page 	= "producto/correlativo/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 28);
		
		$data['registros'] 		= $this->Correlativo_model->getCorrelativos(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();		
		$data['title'] 			= "Correlativos";

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];
		$data['home'] 			= 'template/lista_template';

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] 		= $this->session->menu;
		$data['sucursal'] 	= $this->Sucursal_model->getAllSucursalEmpresa();
		$data['documento'] 	= $this->Documento_model->getAllDocumento();
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] 		= "Nuevo Correlativo";
		$data['home'] 		= 'producto/correlativo/c_nuevo';

		echo $this->load->view('producto/correlativo/c_nuevo',$data, TRUE);
	}

	public function save(){
		$data = $this->Correlativo_model->save( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Correlativo Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Correlativo No Fue Creado :". $data['message']);
		}

		redirect(base_url()."producto/correlativo/index");
	}

	public function editar( $correlatiov_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		
		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista

		$data['menu'] 		= $this->session->menu;
		$data['home'] 		= 'producto/correlativo/c_editar';
		$data['title'] 		= "Editar Correlativo";
		$data['sucursal'] 	= $this->Sucursal_model->getAllSucursalEmpresa();
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['documento'] 	= $this->Documento_model->getAllDocumento();
		$data['correlativo']= $this->Correlativo_model->editar( $correlatiov_id );

		$this->general->editar_valido($data['correlativo'], "producto/correlativo/index");

		echo $this->load->view('producto/correlativo/c_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."producto/correlativo/index");
		}

		$data['title']= "Ver";
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

		$data = $this->Correlativo_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Correlativo Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Correlativo No Fue Actualizado :". $data['message']);
		}

		redirect(base_url()."producto/correlativo/index");
	}

	public function eliminar($id){

		$data = $this->Correlativo_model->delete( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Correlativo Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Correlativo No Fue Eliminado :". $data['message']);
		}

		redirect(base_url()."producto/correlativo/index");
	}

	public function column(){

		$column = array(
			'Sucursal','Documento','N° Inicial','N° Final','N° Siguiente','Prefix','Serie','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_sucursal' => 'Sucursal'],
			['nombre' => 'Documento'],
			['valor_inical' => 'N° Inicial'],
			['valor_final' => 'N° Final'],
			['siguiente_valor' => 'N° Siguiente'],
			['prefix' => 'Prefix'],
			['numero_de_serire' => 'Serie'],
			['fecha_creacion' => 'Creado'],
			['orden_estado_nombre'=> 'Estado'],
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_correlativos');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Correlativos Lista";

		return $fields;
	}
	
	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
}