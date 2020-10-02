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
		$model 		= "Venta_model";
		$url_page 	= "producto/venta/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 38) ;

		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;			

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['moneda'] 		= $this->return_modena();
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['registros'] 		= $this->Venta_model->getVentas( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] 			= "Ventas";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

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

		$template = $this->Template_model->get_template_sucursal_documento( $_POST['sucursal_origen'], $_POST['documento_tipo']);

		$totalDocumentos = $this->totalDocumentos($template, count($_POST['orden']));

		$id = $this->Venta_model->guardar_venta( 
			$_POST,
			$id_usuario,
			$cliente,
			$form,
			$documento_tipo,
			$_POST['sucursal_origen'],
			$correlativo_documento,
			$totalDocumentos,
			$template[0]->factura_lineas
		);

		if($id['code']){
			$data['code'] = $id['code'];
		}else{

			if($check_devol_param == false){

				$this->EfectosDocumento_model->accion($_POST ,$documento_tipo);
			}else{
				if($documento_tipo[0]->efecto_inventario == 1){
	
					$this->EfectosDocumento_model->accion($_POST ,$documento_tipo);
				}else{
					$this->EfectosDocumento_model->devolucionNuevoDocumento($_POST ,$documento_tipo);
				}
			}

			$data['msj_title'] = "Venta grabada Correctamente ";
			$data['msj_orden'] = "Número Transacción : ". $id;
			$data['id'] = $id;
		}

		echo json_encode($data);
	}

	private function totalDocumentos($template , $totalProductos){
		if ($totalProductos > 0) {
			$productosEnDocumento = ((int) ($totalProductos / $template[0]->factura_lineas) +1);
			
			return $productosEnDocumento;
		}
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
		$data['cliente'] 		= $this->Cliente_model->get_clientes_id($data['encabezado'][0]->id_cliente);
		$data['impuestos'] 		= $this->Orden_model->get_impuestos_venta( $data['encabezado'][0]->id );		
		$data['modo_pago'] 		= $this->Venta_model->getVentaPagosId( $id_venta );
		$data['moneda'] 		= $this->return_modena();
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

	public function anular_venta(){

		$_result = false;
		// Set venta to anulada
		$result = $this->setVentaToAnulada($_POST);
		
		// Get venta and return to bodega
		if($result){
			$data['orden'] 	= $this->Venta_model->get_venta_by_id($_POST['id']);

			$documento_tipo[0] = (object) array('efecto_inventario' => 1);

			$this->EfectosDocumento_model->accion($data ,$documento_tipo);

			$_result = true;

			$this->session->set_flashdata('info', "Orden Fue Anulada");
		}
		else{
			$this->session->set_flashdata('danger', "Orden No Fue Anulada : ");
		}
		
		return $_result;
	}

	private function setVentaToAnulada($venta_data){
		$result = $this->Venta_model->setVentaToAnulada($venta_data);
		return $result;
	}

	function facturacion($id){

		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario );
		//$data['menu'] 		= $this->session->menu;

		$order_id = $id;
		$data['orden'] 			= $this->Venta_model->getVentaId($order_id);
		//var_dump($data['orden'][0]);die;
		$data['detalle'] 		= $this->Venta_model->getVentaDetalleId($order_id);		
		$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente($data['orden'][0]->id_cliente);
		$data['empleado'] 		= $this->Usuario_model->get_empleado( $data['orden'][0]->id_cajero );
		$data['terminal'] 		= $terminal_acceso;
		$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
		$data['impuestos'] 		= $this->Orden_model->get_impuestos( $data['orden'][0]->id );
		$data['moneda'] 		= $this->return_modena();
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
		$data['moneda'] 		= $this->return_modena();
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
			'Correlativo','Sucursal','Terminal','Cliente','Cajero','C Pago','Tipo Doc','Descuento','Total','Creado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['num_correlativo' => 'Correlativo'],
			['nombre_sucursal' => 'Sucursal'],
			['num_caja' => 'Terminal'],
			['nombre_empresa_o_compania' => 'Cliente'],
			['nombre_usuario' => 'Cajero'],
			['nombre_modo_pago' => 'C Pago'],
			['tipo_documento' => 'Tipo Doc'],
			['desc_val' => 'Descuento'],
			['total_doc' => 'Total'],
			['fecha' => 'Creado'],
			['orden_estado_nombre' => 'Estado'],
		);

		$moneda_simbolo = $this->return_modena();

		$fields['reglas'] = array(
			'total_doc' => array(
				'valor' => $moneda_simbolo[0]->moneda_simbolo .' ',
				'aplicar' => 'total_doc'
			),
			'desc_val' => array(
				'valor' => $moneda_simbolo[0]->moneda_simbolo .' ',
				'aplicar' => 'desc_val'
			),
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Ventas Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}

	public function format_status(){
		return 1;
	}

}
