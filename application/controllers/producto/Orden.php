<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;

class Orden extends MY_Controller {

	var $vista_id = 13;

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
		$this->load->model('admin/Terminal_model');
		$this->load->model('admin/Giros_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('admin/ModoPago_model');
		$this->load->model('admin/Correlativo_model');
		$this->load->model('producto/Producto_model');				
		$this->load->model('producto/Orden_model');
		$this->load->model('admin/Moneda_model');
		$this->load->model('admin/Template_model');
		$this->load->model('admin/Impuesto_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('producto/Venta_model');
		$this->load->model('producto/Estados_model');
		
	}

	public function index()
	{
		$model 		= "Orden_model";
		$url_page 	= "producto/orden/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 8) ;

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['registros'] 		= $this->Orden_model->getOrdenes( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] 			= "Ordenes";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
		//$this->parser->parse('template', $data);
	}

	public function get_correlativo_by_sucursal($sucursal_id){
		$data['correlativo'] = $this->Correlativo_model->get_by_id($sucursal_id);
		echo json_encode($data);
	}

	public function nuevo(){
		// Seguridad :: Validar URL usuario	
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario, $_POST);
		$data['menu'] 		= $this->session->menu;

		if ($terminal_acceso == 3) {
			//usuario_datos
			$data['home'] = 'producto/orden/crear_terminal';
			$this->parser->parse('template', $data);
			return;
		}

		if($terminal_acceso){
			$data['terminal'] 		= $terminal_acceso;
			$data['tipoDocumento'] 	= $this->Vistas_model->get_vista_documento($this->vista_id);
			$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
			$data['empleado'] 		= $this->Usuario_model->get_empleado_oren( $id_usuario );
			$data['empleados'] 		= $this->Usuario_model->get_empleados_by_sucursal($data['empleado'][0]->id_sucursal);
			$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
			$data['cliente'] 		= $this->Cliente_model->get_cliente();
			$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);
			$data['configuracion']  = $this->Orden_model->getConfg('orden_exitencias_alerta');
			$data['lista_documento'] = $this->Documento_model->getAllDocumento();
			$data['vista_id']		= 13;
			
			if ($data['cliente'][0]) {
				$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente(current($data['cliente'][0]));
			}

			$data['title'] 			= "Nueva Orden";
			$data['home'] 			= 'producto/orden/orden_crear';

			$this->parser->parse('template', $data);
			//echo $this->load->view('producto/orden/orden_crear',$data, TRUE);
		}else{
			$data['home'] = 'producto/orden/orden_denegado';
			$data['terminal'] = "Terminal Inactiva";
			if($terminal_acceso != false) {
				$data['terminal'] = "Usuario no registrado !";
			}
			//echo $this->load->view('producto/orden/orden_denegado',$data, TRUE);
			$this->parser->parse('template', $data);
		}
	}

	public function producto_combo(){
		
		$producto_id 	= $_POST['producto_id'];
		$id_bodega 		= $_POST['id_bodega'];
		$id_producto_detalle = $_POST['id_producto_detalle'];

		$data['p_combos'] 	= $this->Orden_model->producto_combo( $producto_id );
		$data['productos'] 	= array();

		$cnt = 0;
		foreach ($data['p_combos'] as $key => $value) {
			
			$data['productos'][$cnt] = $this->get_producto_completo2($value->producto_a_descargar_Combo , $id_bodega );
			$data['productos'][$cnt]['combo_cantidad'] = $value->cantidad;
			$cnt +=1;
		}

		echo json_encode($data['productos']);		
	}

	function get_producto_completo2( $producto_id, $id_bodega ){

		$data['producto'] = $this->Orden_model->get_producto_completo3($producto_id, $id_bodega);

		$atributos	= array();
		/*
		$contador	=0;
		foreach ($data['producto'] as $key => $value) {
			//$atributos += [ $value->nam_atributo => $data['producto'][$contador]->valor ];
			$contador+=1;
		}
		*/
		$data['atributos'] 	= $atributos;
		$data['precios'] 	= $this->Orden_model->get_producto_precios($producto_id);
		$data['prod_precio']= $this->Orden_model->get_producto_precios( $producto_id );

		return $data;
	}

	public function editar($order_id = null){

		if($order_id == null){
			redirect(base_url()."producto/orden/nuevo");
		}

		// Seguridad :: Validar URL usuario	
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario , $pos=null );
		$data['menu'] 		= $this->session->menu;

		if($terminal_acceso){
			
			$data['orden'] 	= $this->Orden_model->get_orden($order_id);
			if($data['orden']){
				$data['detalle'] 		= $this->Orden_model->get_orden_detalle($order_id);
				$data['tipoDocumento'] 	= $this->Vistas_model->get_vista_documento(13); //$this->Orden_model->get_tipo_documentos();
				$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );//$this->Producto_model->get_sucursales();
				$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente($data['orden'][0]->id_cliente);
				$data['empleado'] 		= $this->Usuario_model->get_empleado_oren( $data['orden'][0]->id_usuario );
				$data['empleados'] 		= $this->Usuario_model->get_empleados_by_sucursal($data['empleado'][0]->id_sucursal);
				$data['terminal'] 		= $terminal_acceso;
				$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);
				$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
				$data['impuestos'] 		= $this->Orden_model->get_impuestos( $data['orden'][0]->id );
				$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
				$data['title'] 			= "Editar Orden";
				$data['cliente'] 		= $this->get_clientes_id(@$data['orden'][0]->id_cliente);
				$data['temp'] 			= $this->Template_model->printer( $data['detalle'] , @$data['orden'][0]->id_sucursal , @$data['orden'][0]->id_tipod, @$data['orden'][0]->id_condpago);
				$data['vista_id']		= 13;
				$data['configuracion']  = $this->Orden_model->getConfg('orden_exitencias_alerta');
				$data['home'] 			= 'producto/orden/orden_editar';
				$name 					= $data['sucursales'][0]->nombre_sucursal.$data['terminal'][0]->id_terminal;
				$data['file'] 			= $name;
				$data['msj_title'] = "Su orden ha sido grabada satisfactoriamente";
				$data['msj_orden'] = "Su número de transacción es: # ". $data['orden'][0]->num_correlativo;
				$data['lista_documento'] = $this->Documento_model->getAllDocumento();
				
				$this->generarDocumento( $name , $data['temp'][0]->factura_template );
				$this->parser->parse('template', $data);
				$data['numero_orden'] = $order_id;
				//echo $this->load->view('producto/orden/orden_editar',$data, TRUE);
			}else{
				$this->general->editar_valido($data['orden'], "producto/orden/nuevo");
			}
				
		}else{

			$data['home'] = 'producto/orden/orden_editar';
			$data['temp'] = $this->Template_model->printer( $order_id );
			echo $this->load->view('producto/orden/orden_editar',$data, TRUE);
		}
	}

	public function print_orden($order_id){

		if($order_id == null){
			redirect(base_url()."producto/orden/nuevo");
		}
		// Seguridad :: Validar URL usuario	
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario , $pos=null);
		$data['menu'] 		= $this->session->menu;

		if($terminal_acceso){

			$data['orden'] 	= $this->Orden_model->get_orden($order_id);
			if($data['orden']){
				$data['detalle'] 		= $this->Orden_model->get_orden_detalle($order_id);
				$data['tipoDocumento'] 	= $this->Vistas_model->get_vista_documento(13); //$this->Orden_model->get_tipo_documentos();
				$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );//$this->Producto_model->get_sucursales();
				$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente($data['orden'][0]->id_cliente);
				$data['empleado'] 		= $this->Usuario_model->get_empleado_oren( $data['orden'][0]->id_usuario );
				$data['terminal'] 		= $terminal_acceso;
				$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);
				$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
				$data['impuestos'] 		= $this->Orden_model->get_impuestos( $data['orden'][0]->id );
				$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
				$data['title'] 			= "Editar Orden";
				$data['cliente'] 		= $this->get_clientes_id(@$data['orden'][0]->id_cliente);
				$data['temp'] 			= $this->Template_model->printer( $data['detalle'] , @$data['orden'][0]->id_sucursal , @$data['orden'][0]->id_tipod, @$data['orden'][0]->id_condpago);
				$data['vista_id']		= 13;
				$data['home'] 			= 'producto/orden/orden_impresion';
				$name 					= $data['sucursales'][0]->nombre_sucursal.$data['terminal'][0]->id_terminal;
				$data['file'] 			= $name;
				$data['msj_title'] = "Su orden ha sido grabada satisfactoriamente";
				$data['msj_orden'] = "Su número de transacción es: # ". $data['orden'][0]->num_correlativo;
				
				$this->generarDocumento( $name , $data['temp'][0]->factura_template );
				echo $this->load->view('producto/orden/orden_impresion',$data, TRUE);
			}else{
				$this->general->editar_valido($data['orden'], "producto/orden/nuevo");
			}				
		} else {
			$data['home'] = 'producto/orden/orden_editar';
			$data['temp'] = $this->Template_model->printer( $order_id );
			echo $this->load->view('producto/orden/orden_editar',$data, TRUE);
		}
	}

	public function get_correlativo_documento( $documento , $sucursal , $totalProductos){
		
		$data['correlativo'] = $this->Correlativo_model->get_correlativo_sucursal( $documento , $sucursal );

		$correlativos = [];
		$template = $this->Template_model->get_template_sucursal_documento( $sucursal, $documento);

		if ($template) {
			$totalDocumentos = $this->totalDocumentos($template, $totalProductos);
			
			if($totalDocumentos > 1){
				$numCorrelativos = $data['correlativo'][0]->siguiente_valor;
				
				for ($int = 1; $int <= $totalDocumentos; $int++) {
					$correlativos[] = $numCorrelativos++;
				}
			}

			$data['numeros_correlativos'] = $correlativos;
			$data['cantidad_por_documento'] = $template[0]->factura_lineas;
		}		
		echo json_encode($data);
	}

	private function totalDocumentos($template , $totalProductos){
		if ($totalProductos > 0) {

			$productosEnDocumento = ((int) ($totalProductos / $template[0]->factura_lineas));
			
			$isEntero = (int) ($totalProductos % $template[0]->factura_lineas);
			
			if ($isEntero != 0) {
				$productosEnDocumento += 1;
			}

			return $productosEnDocumento;
		}
	}

	public function limite_documento($documento)
	{
		$data = $this->Correlativo_model->get_documento_limite($documento);
		echo $data[0]->monto_limite;
	}

	public function update_orden(){

		$dataParametros = array();
		
		$id_usuario = $this->session->usuario[0]->id_usuario;

		foreach ($_POST['encabezado'] as $key => $value) {
		
			foreach ($_POST['encabezado'] as $key => $value) {

				if(isset($value['value'])){
					$dataParametros[$value['name']] = $value['value'];
				}
			}
		}

		// Obteniendo informacion del cliente

		$cliente = $this->get_clientes_id( $dataParametros['cliente_codigo'] );

		$data = $this->Orden_model->update( $_POST , $id_usuario ,$cliente , $dataParametros);

		echo json_encode($data);
	}

	public function cerrar_orden(){
		
		if(isset($_POST)){
			
			$correlativo_orden = $_POST['correlativo_orden'];
			
			$this->Orden_model->cerrar_orden( $correlativo_orden );

		}
	}

	public function autoload_orden(){
		$id_orden_load = $_POST['id'];
		$componente_conf = "combo";		
		$impuesto_conf 	 = "impuestos";

		$data['orden_detalle'] 	= $this->Orden_model->get_orden_detalle($id_orden_load);
		$data['conf'] 			= $this->Orden_model->getConfg($componente_conf);
		$data['impuesto'] 		= $this->Orden_model->getConfgImpuesto($impuesto_conf);

		echo json_encode($data);
	}

	public function guardar_orden(){

		$dataParametros = array();
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		foreach ($_POST['encabezado'] as $key => $value) {
			if(!isset($value['value'])){
				$dataParametros[$value['name']] = "";
			}else{
				$dataParametros[$value['name']] = $value['value'];
			}
		}

		// Obteniendo informacion del cliente
		$cliente = $this->get_clientes_id($dataParametros['cliente_codigo']);

		$id = $this->Orden_model->guardar_orden( $_POST , $id_usuario ,$cliente , $dataParametros );
		echo $id;
		//redirect(base_url()."producto/orden/editar/". $id);
	}

	function get_productos_lista(){

		$sucursal = $_POST['sucursal'];
		$bodega = $_POST['bodega'];
		$texto = $_POST['texto'];
		$data['productos'] = $this->Orden_model->get_productos_valor($sucursal ,$bodega, $texto);
		$data['moneda'] = $this->Moneda_model->get_modena_by_user();
		unset($data['moneda'][0]->logo_empresa);

		echo json_encode( $data );
	}

	function get_impuestos_lista(){

		$data['impuesto_categoria'] = $this->Impuesto_model->getAllImpCat();
		$data['impuesto_cliente'] 	= $this->Impuesto_model->getAllImpCli();
		$data['impuesto_documento'] = $this->Impuesto_model->getAllImpDoc();
		$data['impuesto_proveedor'] = $this->Impuesto_model->getAllImpProv();

		echo json_encode( $data );
	}

	function get_bodega( ){

		$id_usuario 	= $this->session->usuario[0]->id_usuario;
		$data['bodega'] = $this->Orden_model->get_bodega( $id_usuario );

		echo json_encode( $data );
	}

	function get_bodega_sucursal( $Sucursal ){

		$data['bodega'] 		= $this->Bodega_model->get_bodega_sucursal( $Sucursal );
		$data['correlativo'] 	= $this->Correlativo_model->get_by_id($Sucursal);

		echo json_encode( $data );
	}

	function get_clientes_lista($cliente_texto){

		// Obteniendo Lista Cliente desde Model Cliente
		$data['clientes'] = $this->Cliente_model->get_cliente_filtro($cliente_texto);

		echo json_encode( $data );
	}

	function get_clientes_documento($id){

		$data['clienteDocumento'] 	= $this->Cliente_model->get_cliente_by_id2($id);
		$data['cliente_tipo_pago'] 	= $this->ModoPago_model->get_pagos_by_cliente($id);
		$data['tipoDocumento'] 		= $this->Orden_model->get_tipo_documentos();
		$data['tipoPago'] 			= $this->ModoPago_model->get_pagos_by_cliente($id);

		echo json_encode( $data );
	}

	function get_clientes_id( $cliente_id ){

		// Obteniendo el cliente by ID desde Model Cliente
		$data = $this->Cliente_model->get_clientes_id( $cliente_id );
		return $data;
	}

	function get_empleados_by_sucursal($sucursal){

		$data['empleados'] = $this->Usuario_model->get_empleados_by_sucursal($sucursal);		
		echo json_encode( $data );
	}

	function get_producto_completo($id_producto_detalle, $id_bodega ){

		$combo_conf 		= "combo";
		$impuesto_conf 		= "impuestos";
		$descuento_conf		= "descuentos";
		
		$data['producto'] 	= $this->Orden_model->get_producto_completo($id_producto_detalle, $id_bodega);		
		$producto_id 		= $data['producto'][0]->id_entidad;		
		$contador			= 0;
		$atributos			= array();
		
		foreach ($data['producto'] as $key => $value) {

			//$atributos += [ $value->nam_atributo => $data['producto'][$contador]->valor ];
			$contador+=1;
		}

		$data['atributos'] 		= $atributos;
		$data['precios'] 		= $this->Orden_model->get_producto_precios($producto_id);
		$data['prod_precio'] 	= $this->Orden_model->get_producto_precios( $producto_id );
		$data['conf'] 			= $this->Orden_model->getConfg($combo_conf);
		$data['impuesto'] 		= $this->Orden_model->getConfgImpuesto($impuesto_conf);
		$data['descuentos'] 	= $this->Orden_model->getConfgDescuento($descuento_conf);
		//$data['producto_imagen'] = $this->Producto_model->get_productos_imagen($producto_id);	
		echo json_encode( $data );
	}

	function validar_usuario_terminal( $usuario_id, $usuario_datos){

		$terminal_nombe = $_SERVER['HTTP_USER_AGENT'];//gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$_unique_uuid = $this->session->uuid;

		$terminal_dato = $this->Terminal_model->get_terminal_registrada($usuario_id, $_unique_uuid);
		if ($terminal_dato) {

			/**
			 * Estados de la terminal
			 * 0 = Inactivar
			 * 1 = Activa
			 * 3 = Invitado
			 */

			if ($terminal_dato[0]->estado_terminal == 1 ||  $terminal_dato[0]->estado_terminal == 3) {
				return $terminal_dato;
			} else {
				return 0;
			}
		} else {
			/** Insertar Usuario Terminal Para Solicitar Permiso a ordenes */
			$caracteres = array("/"," ",",",";",".","(",")");
			$dispositivo_info = $this->array_terminal_nombre($caracteres,"",$terminal_nombe);
			if (!empty($usuario_datos)) {
				$this->Terminal_model->crear_terminal_dispositivo($usuario_id, $_unique_uuid, $dispositivo_info, $usuario_datos);
			} else {
				return 3;
			}
		}
		return false;
	}

	/**
	 * Limpiar el nombre de la terminal de caracteres raros
	 *
	 * @return string
	 */
	public function limpiar_terminal_nombre($caracteres,$remplazo,$cadena){
		
		$str = $cadena;
		foreach ($caracteres as $caracter) {
			$str = str_replace($caracter, $remplazo, $str);
		}

		return $str;
	}

	/**
	 * Limpiar el nombre de la terminal de caracteres raros
	 *
	 * @return string
	 */
	public function array_terminal_nombre($caracteres,$remplazo,$cadena){
		
		$str = $cadena;
		$_info = array();
		foreach ($caracteres as $caracter) {
			$str = str_replace($caracter, $remplazo, $str);
		}

		$_info['general'] = $str;

		if (strpos($str, 'Linux') !== false) {
			$_info['so'] = 'Linux';
			$_info['device'] = 'Pc';
		} else if (strpos($str, 'Window') !== false) {
			$_info['so'] = 'Window';
			$_info['device'] = 'Pc';
		} else if (strpos($str, 'Android') !== false) {
			$_info['so'] = 'Android';
			$_info['device'] = 'Movil/Tablet';
		}

		if (strpos($str, 'Firefox') !== false) {
			$_info['browser'] = 'Firefox';
		} else if (strpos($str, 'Chrome') !== false) {
			$_info['browser'] = 'Chrome';
		} else if (strpos($str, 'Opera') !== false) {
			$_info['browser'] = 'Opera';
		} else if (strpos($str, 'Safari') !== false) {
			$_info['browser'] = 'Safari';
		}

		return $_info;
	}

	/************ Venta Rapida *********/
	public function venta_rapida(){

		// Seguridad :: Validar URL usuario	
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario, $pos=null );
		$data['menu'] 		= $this->session->menu;
		$this->vista_id		= 38;

		if($terminal_acceso){
			
			$data['tipoDocumento'] 	= $this->Vistas_model->get_vista_documento($this->vista_id);
			$data['sucursales'] 	= $this->Sucursal_model->getSucursal();
			$data['modo_pago'] 		= $this->ModoPago_model->getAllFormasPago();
			$data['empleado'] 		= $this->Usuario_model->get_empleado_oren( $id_usuario );
			$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);
			$data['terminal'] 		= $terminal_acceso;
			//$data['correlativo'] = $this->Correlativo_model->get_correlativo_sucursal(  ,$data['empleado'][0]->id_sucursal );
			$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
			$data['cliente'] 		= $this->Cliente_model->get_cliente();
			$data['configuracion']  = $this->Orden_model->getConfg('orden_exitencias_alerta');
			$data['title']			= "Ventas Rapidas";
			$data['vista_id']		= 38;
		
			$data['home'] = 'producto/orden/venta_rapida';

			echo $this->load->view('producto/orden/venta_rapida',$data, TRUE);
		}else{
			$data['home'] = 'producto/orden/orden_denegado';
			echo $this->load->view('producto/orden/orden_denegado',$data, TRUE);
		}
	}

	function venta($id_venta){

		$id_usuario 			= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 		= $this->validar_usuario_terminal( $id_usuario , $pos=null);

		$data['encabezado'] 	= $this->Venta_model->getVentaId( $id_venta );
		$data['detalle'] 		= $this->Venta_model->getVentaDetalleId( $id_venta );
		$data['venta_pagos'] 	= $this->Venta_model->getVentaPagosId( $id_venta );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['terminal'] 		= $terminal_acceso;
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['temp'] 			= $this->Template_model->printer_venta( $data['venta_detalle'] , @$data['venta'][0]->id_sucursal , @$data['venta'][0]->id_tipod, @$data['venta'][0]->id_condpago);
		$data['configuracion']  = $this->Orden_model->getConfg('orden_exitencias_alerta');
		$name 					= $data['sucursales'][0]->nombre_sucursal.$data['terminal'][0]->id_terminal;
		$data['file'] 			= $name;
		$data['msj_title'] = "Su orden ha sido grabada satisfactoriamente";
		$data['msj_orden'] = "Su número de transacción es: # ". $data['orden'][0]->num_correlativo;

						
		$this->generarDocumento( $name , $data['temp'][0]->factura_template );

		$data['title'] 			= "Ventas Detalle";
		$data['home'] = 'producto/ventas/venta_detalle2';

		//$this->parser->parse('template', $data);
		$this->load->view('producto/ventas/venta_detalle2', $data);
		echo $this->load->view('producto/ventas/venta_detalle2',$data, TRUE);
	}

	public function unload(){

		$termnal 	= $_POST['terminal'];
		$estado 	= $_POST['estado'];

		$this->Terminal_model->unload( $termnal , $estado );
	}

	public function get_form_pago( $id_cliente ,$tipo_documento , $sucursal_id ){

		$data['metodo_pago'] 	= $this->ModoPago_model->get_pagos_by_cliente( $id_cliente );
		$data['metodo_pago_doc'] = $this->ModoPago_model->get_pagos_by_doc( $tipo_documento , $sucursal_id );

		echo json_encode($data);
	}

	public function get_productos_imagen($producto_id){

		if($producto_id){

			$data['producto_imagen']= $this->Producto_model->get_productos_imagen($producto_id);
			$info['imagen'] 		= base64_encode($data['producto_imagen'][0]->producto_img_blob);
			$info['type'] 			= $data['producto_imagen'][0]->imageType;
			echo json_encode($info);
		}
	}

	public function autenticar_usuario_descuento(){

		$data = $this->Usuario_model->autenticar_usuario_descuento($_POST);

		echo json_encode($data);
	}

	public function table(){

		$this->load->view('producto/orden/table.html');
	}

	public function column(){

		$column = array(
			'Correlativo','Sucursal','Cliente','Usuario','Vendedor','Metodo Pago','Documento','Monto','Creado','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			['num_correlativo' => 'Correlativo'],
			['nombre_sucursal' => 'Sucursal'],
			['nombre_empresa_o_compania' => 'Cliente'],
			['nombre_usuario' => 'Usuario'],
			['vendedor' => 'Vendedor'],
			['nombre_modo_pago' => 'Metodo Pago'],
			['tipo_documento' => 'Documento'],
			['monto_orden' => 'Monto'],
			['fecha' => 'Creado'],
			['orden_estado_nombre' => 'Actual'],
		);

		$fields['filtro_estado'] = $this->get_estados();

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('num_correlativo');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Orden Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
	
}
