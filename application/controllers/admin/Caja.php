<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caja extends MY_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    @$this->load->library('session');	
	    $this->load->library('pagination');    
	    $this->load->library('../controllers/general');
		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Terminal_model');  
		$this->load->model('admin/Caja_model');  
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Documento_model');
		$this->load->model('admin/Sucursal_model');
	}

	public function index(){

		$model 		= "Caja_model";
		$url_page 	= "admin/caja/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 35);

		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones']		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol']);
		$data['registros'] 		= $this->Caja_model->get_all_caja( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Caja";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		//$this->parser->parse('template', $data);
		$data = $this->load->view('template/lista_template',$data, TRUE);
		echo $data;
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['doc'] = $this->Documento_model->getDocTemplate();
		$data['suc'] = $this->Sucursal_model->getSucursalEmpresa($this->session->empresa[0]->id_empresa);
		$data['title'] = "Nueva Caja";
		$data['home'] = 'admin/caja/c_nuevo';

		echo $this->load->view('admin/caja/c_nuevo',$data, TRUE);
	}

	public function crear(){
		// Insert Nuevo Usuario
		$data = $this->Caja_model->crear_caja( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Caja Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Caja No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."admin/caja/index");
	}

	public function editar($caja_id){
		
		$menu_session = $this->session->menu;	

		$id_rol = $this->session->roles;
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['doc'] = $this->Documento_model->getDocTemplate();
		$data['suc'] = $this->Sucursal_model->getAllSucursalEmpresa();
		$data['caja'] = $this->Caja_model->get_caja( $caja_id );
		$this->general->editar_valido($data['caja'], "admin/caja/index");
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'admin/caja/c_editar';
		$data['title'] = "Editar Caja";

		echo $this->load->view('admin/caja/c_editar',$data, TRUE);
	}

	public function ver( $id = 0 ){
		
		if( $id ==0 ){
			redirect(base_url()."admin/caja/index");
		}

		$data['title'] = "Ver";

		$data['home'] = 'template/ver_general';

		$data['menu'] = $this->session->menu;		

		$data['data'] = $this->Caja_model->get_caja( $id );
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/cargo/index");
		}

	}

	public function update(){

		$data = $this->Caja_model->update_caja( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Caja Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Caja No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."admin/caja/index");
	}

	public function eliminar($id){
		
		$data = $this->Caja_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Caja Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Caja No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."admin/caja/index");
	}

	public function column(){

		$column = array(
			'Sucursal','Nombre','Codigo','Doc','Template','Resolucion','RNTicket','Cajero','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_sucursal' => 'Sucursal'],
			['nombre_caja'=> 'Nombre'],
			['cod_interno_caja'=> 'Codigo'],
			['nombre'=> 'Documento'],
			['factura_nombre'=> 'Template'],
			['resol_num_caja'=> 'Resolucion'],
			['resol_num_tiq_caja'=> 'RNTicket'],
			['pred_cod_cajr'=> 'Cajero'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_caja');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Caja Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}