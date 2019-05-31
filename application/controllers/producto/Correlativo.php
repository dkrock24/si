<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Correlativo extends CI_Controller {

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
		
		$total_row = $this->Correlativo_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "producto/correlativo/index");
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
		//parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 2; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['registros'] = $this->Correlativo_model->getCorrelativos(  $config["per_page"], $page );
		$data['contador_tabla'] = $contador_tabla;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
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
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/correlativo/c_nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$data['bodegas'] = $this->Correlativo_model->save( $_POST );

		redirect(base_url()."producto/correlativo/index");
	}

	public function editar( $correlatiov_id ){

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 20; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['menu'] = $this->session->menu;
		$data['correlativo'] = $this->Correlativo_model->editar( $correlatiov_id );
		$data['sucursal'] = $this->Sucursal_model->getSucursal();
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/correlativo/c_editar';

		$this->general->editar_valido($data['correlativo'], "producto/correlativo/index");

		$this->parser->parse('template', $data);
	}

	public function update(){

		$data['bodegas'] = $this->Correlativo_model->update( $_POST );

		redirect(base_url()."producto/correlativo/index");
	}

	public function column(){

		$column = array(
			'#','Inicial','Final','Siguiente','Prefix','Sucursal','Documento','Serie','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'valor_inical','valor_final','siguiente_valor','prefix','nombre_sucursal','nombre','numero_de_serire','fecha_creacion','estado'
		);
		
		$fields['id'] = array('id_correlativos');
		$fields['estado'] = array('correlativo_estado');
		$fields['titulo'] = "Correlativos Lista";

		return $fields;
	}
}