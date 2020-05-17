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
		$this->load->model('producto/Orden_model');
		$this->load->model('admin/Moneda_model');
		$this->load->model('producto/EfectosDocumento_model');
		$this->load->model('admin/Template_model');
		$this->load->model('admin/Terminal_model');

		
	}

	public function index()
	{	
		$model = "Venta_model";
		$url_page = "producto/venta/index";
		$pag = $this->MyPagination($model, $url_page, $vista = 38) ;

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;			

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

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function guardar_venta(){
		
		$form 		= array();
		$id_usuario = $this->session->usuario[0]->id_usuario;

		foreach ($_POST['encabezado'] as $key => $value) {
			$form[$value['name']] = $value['value'];
		}
		$correlativo_documento 	= $_POST['correlativo_documento'];		
		$documento_tipo 		= $this->Documento_model->getDocumentoById($_POST['documento_tipo']);
		$cliente 				= $this->get_clientes_id($_POST['cliente']);
		$check_devol_param 		= $form['check_devolucion'] === 'true'? true: false;

		if($check_devol_param == false){
			$this->EfectosDocumento_model->accion($_POST ,$documento_tipo);
		}else{
			if($documento_tipo[0]->efecto_inventario == 1){

				$this->EfectosDocumento_model->accion($_POST ,$documento_tipo);
			}else{

				$this->EfectosDocumento_model->devolucionNuevoDocumento($_POST ,$documento_tipo);
			}
		}

		$id = $this->Venta_model->guardar_venta( 
			$_POST , 
			$id_usuario ,
			$cliente , 
			$form ,
			$documento_tipo , 
			$_POST['sucursal_origen'] , 
			$correlativo_documento
		);

		$data['msj_title'] = "Venta grabada Correctamente ";
		$data['msj_orden'] = "Número Transacción : ". $id;
		$data['id'] = $id;

		echo json_encode($data);
	}

	function get_clientes_id( $cliente_id ){
		// Obteniendo el cliente by ID desde Model Cliente

		$data = $this->Cliente_model->get_clientes_id( $cliente_id );
		return $data;
	}

	public function ver($id_venta){

		$id_usuario 			= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 		= $this->validar_usuario_terminal( $id_usuario );

		$data['encabezado'] 	= $this->Venta_model->getVentaId( $id_venta );		
		$data['detalle'] 		= $this->Venta_model->getVentaDetalleId( $id_venta );
		$data['cliente'] 		=  $this->Cliente_model->get_clientes_id($data['encabezado'][0]->id_cliente);
		$data['impuestos'] 		= $this->Orden_model->get_impuestos_venta( $data['encabezado'][0]->id );		
		$data['modo_pago'] 		= $this->Venta_model->getVentaPagosId( $id_venta );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['terminal'] 		= $terminal_acceso;
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );//$this->Producto_model->get_sucursales();
		
		$data['temp'] 			= $this->Template_model->printer_venta( 
									$data['detalle'] , 
									$data['encabezado'][0]->id_sucursal , 
									$data['encabezado'][0]->id_tipod, 
									$data['encabezado'][0]->id_condpago
								);

		$name 					= $data['sucursales'][0]->nombre_sucursal.@$data['terminal'][0]->id_terminal;
		$data['file'] 			= $name;
		$data['msj_title'] = "Su orden ha sido grabada satisfactoriamente";
		$data['msj_orden'] = "Su número de transacción es: # ". $data['encabezado'][0]->num_correlativo;

		$this->general->editar_valido($data['encabezado'], "producto/orden/index");			
		$this->generarDocumento( $name , $data['temp'][0]->factura_template );

		$data['menu'] 			= $this->session->menu;
		$data['title'] 			= "Ventas Detalle";
		$data['home'] 			= 'producto/ventas/venta_detalle';

		$this->parser->parse('template', $data);
	}

	public function autoload_venta(){

		$componente_conf = "combo";		
		$impuesto_conf 	 = "impuestos";

		$data['orden_detalle'] 	= $this->Venta_model->get_venta($_POST['id']);
		$data['conf'] 			= $this->Orden_model->getConfg($componente_conf);
		$data['impuesto'] 		= $this->Orden_model->getConfgImpuesto($impuesto_conf);
		
		echo json_encode($data);
	}

	function facturacion($id){

		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario );
		//$data['menu'] 		= $this->session->menu;

		$order_id = $id;
		$data['orden'] 			= $this->Venta_model->getVentaId($order_id);
		$data['detalle'] 		= $this->Venta_model->getVentaDetalleId($order_id);		
		$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente($data['orden'][0]->id_cliente);
		$data['empleado'] 		= $this->Usuario_model->get_empleado( $data['orden'][0]->id_cajero );
		$data['terminal'] 		= $terminal_acceso;
		$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
		$data['impuestos'] 		= $this->Orden_model->get_impuestos( $data['orden'][0]->id );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['title'] 			= "Venta";
		$data['cliente'] 		= $this->get_clientes_id(@$data['orden'][0]->id_cliente);
		$data['temp'] 			= $this->Template_model->printer_venta
									(
										$data['detalle'] ,
										$data['orden'][0]->id_sucursal , 
										$data['orden'][0]->id_tipod, 
										$data['orden'][0]->id_condpago
									);

		$data['home'] 			= 'producto/ventas/facturacion';
		$name 					= $data['sucursales'][0]->nombre_sucursal.$data['terminal'][0]->id_terminal;
		$data['file'] 			= $name;
		$data['msj_title'] = "Su venta ha sido grabada satisfactoriamente";
		$data['msj_orden'] = "Su número de transacción es: # ". $data['orden'][0]->num_correlativo;
		
		$this->generarDocumento( $name , $data['temp'][0]->factura_template );
		$this->parser->parse('template', $data);
	}

	function print_venta($id){
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario );
		//$data['menu'] 		= $this->session->menu;

		$order_id = $id;
		$data['orden'] 			= $this->Venta_model->getVentaId($order_id);
		$data['detalle'] 		= $this->Venta_model->getVentaDetalleId($order_id);		
		$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente($data['orden'][0]->id_cliente);
		$data['empleado'] 		= $this->Usuario_model->get_empleado( $data['orden'][0]->id_cajero );
		$data['terminal'] 		= $terminal_acceso;
		$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
		$data['impuestos'] 		= $this->Orden_model->get_impuestos( $data['orden'][0]->id );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['title'] 			= "Venta";
		$data['cliente'] 		= $this->get_clientes_id(@$data['orden'][0]->id_cliente);
		$data['temp'] 			= $this->Template_model->printer_venta
									(
										$data['detalle'] ,
										$data['orden'][0]->id_sucursal , 
										$data['orden'][0]->id_tipod, 
										$data['orden'][0]->id_condpago
									);

		$data['home'] 			= 'producto/ventas/facturacion';
		$name 					= $data['sucursales'][0]->nombre_sucursal.$data['terminal'][0]->id_terminal;
		$data['file'] 			= $name;
		$data['msj_title'] = "Su venta ha sido grabada satisfactoriamente";
		$data['msj_orden'] = "Su número de transacción es: # ". $data['orden'][0]->num_correlativo;
		
		$this->generarDocumento( $name , $data['temp'][0]->factura_template );
		$this->load->view('producto/print/print', $data);	
	}

	function validar_usuario_terminal( $usuario_id  ){

		$terminal_nombe = $_SERVER['REMOTE_ADDR'];//gethostbyaddr($_SERVER['REMOTE_ADDR']);

		$terminal_datos = $this->Terminal_model->validar_usuario_terminal($usuario_id, $terminal_nombe);
		
		if(!$terminal_datos){
			$terminal_datos == FALSE;
		}

		return $terminal_datos;
	}

	public function column(){

		$column = array(
			'Correlativo','Sucursal','Terminal','Cliente','C Pago','Tipo Doc','Total','Cajero','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'num_correlativo','nombre_sucursal','num_caja','nombre_empresa_o_compania','nombre_modo_pago','tipo_documento','total_doc','nombre_usuario','fecha','orden_estado_nombre'
		);
		
		$fields['id'] = array('id');
		$fields['estado'] = array('orden_estado');
		$fields['titulo'] = "Ventas Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}

}
