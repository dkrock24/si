<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta extends MY_Controller {

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

		$model = "Venta_model";
		$url_page = "producto/venta/index";
		$pag = $this->MyPagination($model, $url_page, $vista = 38) ;

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['registros'] = $this->Venta_model->getVentas( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['fields'] = $this->fields();
		$data['column'] = $this->column();
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		
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
		$correlativo_documento = $_POST['correlativo_documento'];
		
		$documento_tipo = $this->Documento_model->getDocumentoById($_POST['documento_tipo']);

		$cliente = $this->get_clientes_id($_POST['cliente']);

		$this->Venta_model->guardar_venta( $_POST , $id_usuario ,$cliente , $form ,$documento_tipo , $_POST['sucursal_origen'] , $correlativo_documento);

		redirect(base_url()."producto/orden/nuevo");
	}

	function get_clientes_id( $cliente_id ){
		// Obteniendo el cliente by ID desde Model Cliente

		$data = $this->Cliente_model->get_clientes_id( $cliente_id );
		return $data;
	}

	public function ver($id_venta){
		$data['venta'] = $this->Venta_model->getVentaId( $id_venta );
		$data['venta_detalle'] = $this->Venta_model->getVentaDetalleId( $id_venta );
		$data['venta_pagos'] = $this->Venta_model->getVentaPagosId( $id_venta );

		$data['menu'] = $this->session->menu;
		$data['title'] = "Ventas Detalle";
		$data['home'] = 'producto/ventas/venta_detalle';

		$this->parser->parse('template', $data);
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
