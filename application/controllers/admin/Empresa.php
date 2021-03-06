<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends MY_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('../controllers/general');
		$this->load->helper('seguridad/url_helper');
		$this->load->model('accion/Accion_model');		
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Moneda_model');
	}

// Start Empresa **********************************************************************************

	public function index(){

		$model 		= "Empresa_model";
		$url_page 	= "admin/empresa/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 37);

		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol']  );

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['registros'] 		= $this->Empresa_model->getEmpresas( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= 'Lista Empresas';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];
		
		//$this->parser->parse('template', $data);
		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){
		
		$id_rol 	= $this->session->roles;
		$vista_id 	= 2; // Vista Orden Lista

		$data['menu'] 	= $this->session->menu;
		$data['moneda'] = $this->Moneda_model->getAllMoneda();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] 	= 'admin/empresa/empresa_nuevo';
		$data['title'] 	= 'Crear Empresa';

		echo $this->load->view('admin/empresa/empresa_nuevo',$data, TRUE);
	}

	public function crear(){

		if (isset($_POST)) {

			$data = $this->Empresa_model->save($_POST);

			if(!$data['code']){
				$this->session->set_flashdata('success', "Empresa Fue Creada");
			}else{
				$data = $this->db_error_format($data);
				$this->session->set_flashdata('danger', "Empresa No Fue Creada  : ". $data['message']);
			}
		}
		redirect(base_url()."admin/Empresa/index");
	}

	public function editar( $empresa_id ){

		if(isset($empresa_id)){

			// Seguridad :: Validar URL usuario	
			$menu_session = $this->session->menu;

			$id_rol = $this->session->roles;
			$vista_id = 8; // Vista Orden Lista

			$data['menu'] 		= $this->session->menu;
			$data['empresa'] 	= $this->Empresa_model->getEmpresaId( $empresa_id );
			$data['moneda'] 	= $this->Moneda_model->getAllMoneda();
			$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
			$data['home'] 		= 'admin/empresa/empresa_editar';
			$data['title'] 		= 'Editar Empresas';

			$this->general->editar_valido($data['empresa'], "admin/empresa/index");

			echo $this->load->view('admin/empresa/empresa_editar',$data, TRUE);

		}else{
			redirect(base_url()."admin/Empresa/index");
		}
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/empresa/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] =  $this->Empresa_model->getEmpresaId( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			echo $this->load->view('template/ver_general',$data, TRUE);

		}else{
			redirect(base_url()."admin/empresa/index");
		}
	}

	public function update(){

		if (isset($_POST)) {

			$data = $this->Empresa_model->update($_POST);

			if(!$data['code']){
				$this->session->set_flashdata('info', "Empresa Fue Actualizada");
			}else{
				$data = $this->db_error_format($data);
				$this->session->set_flashdata('danger', "Empresa No Fue Actualizada  : ". $data['message']);
			}
		}
		redirect(base_url()."admin/Empresa/index");
	}

	public function eliminar($id){

		if (isset($_POST)) {

			$data = $this->Empresa_model->eliminar($id);

			if(!$data['code']){
				$this->session->set_flashdata('warning', "Empresa Fue Eliminada");
			}else{
				$data = $this->db_error_format($data);
				$this->session->set_flashdata('danger', "Empresa No Fue Eliminada  : ". $data['message']);
			}
		}
		redirect(base_url()."admin/Empresa/index");
	}

	public function column(){

		$column = array(
			'NOMBRE','NRC','NIT','GIRO','TEL','MONEDA','CODIGO','CREADO','ESTADO'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			['nombre_razon_social' => 'Nombre'],
			['nrc' => 'NRC'],
			['nit' => 'NIT'],
			['giro' => 'GIRO'],
			['tel' => 'TEL'],
			['moneda_nombre' => 'MONEDA'],
			['codigo' => 'CODIGO'],
			['empresa_creado' => 'CREADO'],
			['orden_estado_nombre' =>'ESTADO']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_empresa');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Empresa Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}