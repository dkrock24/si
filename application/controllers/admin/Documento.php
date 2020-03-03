<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documento extends MY_Controller {

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

		$model = "Documento_model";
		$url_page = "admin/documento/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 27);

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] = $this->Documento_model->getDocumento($pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		
		$data['title'] = "Documentos";	
		$data['home'] = 'template/lista_template';

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$this->parser->parse('template', $data);
	}

	public function editar( $documento_id )
	{	
		$id_rol = $this->session->roles;

		$data['menu'] 		= $this->session->menu;
		$data['documento'] 	= $this->Documento_model->getDocumentoById( $documento_id );
		$data['vistas'] 	= $this->Vistas_model->get_all_vistas();
		$data['vistas_doc'] = $this->Vistas_model->get_vista_doc($documento_id);
		$data['title'] 		= "Editar Documento";
		$data['home'] 		= 'admin/documento/d_editar';

		$this->general->editar_valido($data['documento'], "admin/documento/index");

		$this->parser->parse('template', $data);
	}

	public function asociar($documento , $vista){
		$data['vistas'] 	= $this->Vistas_model->asociar($documento , $vista);
		echo 1;
	}

	public function remover($documento , $vista){
		$data['vistas'] 	= $this->Vistas_model->remover($documento , $vista);
		echo 1;
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/documento/index");
		}

		$data['title'] = "Ver";

		$data['home'] = 'template/ver_general';

		$data['menu'] = $this->session->menu;		

		$data['data'] = $this->Documento_model->getDocumentoById( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/documento/index");
		}

	}

	public function update()
	{	
		$data['documento'] = $this->Documento_model->setDocumento( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Documento Fue Actializado");
		}else{
			$this->session->set_flashdata('danger', "Documento No Fue Actializado");
		}	
		
		redirect(base_url()."admin/documento/index");
	}

	public function nuevo(){

		$id_rol = $this->session->roles;

		$data['menu'] = $this->session->menu;
		$data['title'] = "Nuevo Documento";	
		$data['home'] = 'admin/documento/d_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$data = $this->Documento_model->nuevo_documento( $_POST );

		if($data){
			$this->session->set_flashdata('warning', "Documento Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Documento No Fue Creado");
		}

		redirect(base_url()."admin/documento/index");
	}

	public function eliminar( $id ){
		$data = $this->Documento_model->delete_documento( $id );

		if($data){
			$this->session->set_flashdata('warning', "Documento Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Documento No Fue Eliminado");
		}
		redirect(base_url()."admin/documento/index");
	}

	public function column(){

		$column = array(
			'Nombre','Inventario','Iva','Cuentas','Caja','Ventas','Automatico','Emitir','Estado'
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

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}

	
}
