<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('../controllers/general');

		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('producto/Venta_model');
		$this->load->model('admin/Documento_model');
		
	}

	public function index()
	{	

		//Paginacion
		$_SESSION['per_page'] = "";
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Venta_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "producto/venta/index");
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
		$vista_id = 8; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['registros'] = $this->Venta_model->getVentas( $config["per_page"], $page );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['fields'] = $this->fields();
		$data['column'] = $this->column();
		$data['title'] = "Ventas";
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function guardar_venta(){

		$form = array();

		$id_usuario = $this->session->usuario[0]->id_usuario;

		foreach ($_POST['encabezado'] as $key => $value) {
			$form[$value['name']] = $value['value'];
		}

		$documento_tipo = $this->Documento_model->getDocumentoById($form['id_tipo_documento']);

		$cliente = $this->get_clientes_id($form['cliente_codigo']);

		$this->Venta_model->guardar_venta( $_POST , $id_usuario ,$cliente , $form ,$documento_tipo );

		//redirect(base_url()."producto/orden/nuevo");
	}

	function get_clientes_id( $cliente_id ){
		// Obteniendo el cliente by ID desde Model Cliente

		$data = $this->Cliente_model->get_clientes_id( $cliente_id );
		return $data;
	}

	public function column(){

		$column = array(
			'Correlativo','Sucursal','Terminal','Cliente','F. Pago','Tipo Doc.','Cajero','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'num_correlativo','nombre_sucursal','num_caja','nombre_empresa_o_compania','nombre_modo_pago','tipo_documento','nombre_usuario','fecha','orden_estado_nombre'
		);
		
		$fields['id'] = array('id');
		$fields['estado'] = array('orden_estado');
		$fields['titulo'] = "Ventas Lista";

		return $fields;
	}

}
