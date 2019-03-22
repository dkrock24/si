<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documento extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');  
		$this->load->library('../controllers/general');

		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Menu_model');	
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Documento_model');
	}

	public function index()
	{	
		//Paginacion
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Documento_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/documento/index");
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


		$id_rol = $this->session->roles[0];

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Documento_model->getDocumento( $config["per_page"], $page );
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function editar( $documento_id )
	{	
		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['documento'] = $this->Documento_model->getDocumentoById( $documento_id );
		$data['home'] = 'admin/documento/d_editar';

		$this->general->editar_valido($data['documento'], "admin/documento/index");

		$this->parser->parse('template', $data);
	}

	public function update()
	{	
		$data['documento'] = $this->Documento_model->setDocumento( $_POST );	
		
		redirect(base_url()."admin/documento/index");
	}

	public function nuevo(){

		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/documento/d_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$this->Documento_model->nuevo_documento( $_POST );
		redirect(base_url()."admin/documento/index");
	}

	public function delete( $id_rol ){
		$this->Roles_model->delete_rol( $id_rol );
		redirect(base_url()."admin/roles/index");
	}

	public function column(){

		$column = array(
			'#','Nombre','Inventario','Iva','Cuentas','Caja','Ventas','Automatico','Emitir','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre','efecto_inventario','efecto_en_iva','efecto_en_cuentas','efecto_en_caja','efecto_en_report_venta','automatico','emitir_a','estado'
		);
		
		$fields['id'] = array('id_tipo_documento');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Tipos Documentos Lista";

		return $fields;
	}

	
}
