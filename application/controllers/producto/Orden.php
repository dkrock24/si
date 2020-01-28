<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends MY_Controller {

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
		
	}

	public function index()
	{	

		$model = "Orden_model";
		$url_page = "producto/orden/index";
		$pag = $this->MyPagination($model, $url_page, $vista = 26) ;

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Orden_model->getOrdenes( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] = "Ordenes";
		$data['home'] = 'template/lista_template';

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$this->parser->parse('template', $data);
	}

	public function get_correlativo_by_sucursal($sucursal_id){
		$data['correlativo'] = $this->Correlativo_model->get_by_id($sucursal_id);
		echo json_encode($data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario	
		$terminal_acceso = FALSE;

		$menu_session 	= $this->session->menu;	

		$id_rol 		= $this->session->roles[0];
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$terminal_acceso = $this->validar_usuario_terminal( $id_usuario );

		$data['menu'] 	= $this->session->menu;		

		if($terminal_acceso){
			
			$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
			$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
			$data['empleado'] 		= $this->Usuario_model->get_empleado( $id_usuario );
			$data['terminal'] 		= $terminal_acceso;
			$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
			$data['cliente'] 		= $this->Cliente_model->get_cliente();
			
			if($data['cliente'][0] ){
				$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente(current($data['cliente'][0]));
			}

			$data['title'] 			= "Nueva Orden";
			$data['home'] 			= 'producto/orden/orden_crear';

			$this->parser->parse('template', $data);
		}else{
			$data['home'] = 'producto/orden/orden_denegado';
			$this->parser->parse('template', $data);
		}
		
	}

	public function producto_combo(){
		
		$producto_id = $_POST['producto_id'];
		$id_bodega = $_POST['id_bodega'];
		$id_producto_detalle = $_POST['id_producto_detalle'];

		$data['p_combos'] = $this->Orden_model->producto_combo( $producto_id );
		$data['productos'] = array();

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

		$contador	=0;
		$atributos	= array();

		foreach ($data['producto'] as $key => $value) {
			$atributos += [ $value->nam_atributo => $data['producto'][$contador]->valor ];
			$contador+=1;
		}

		$data['atributos'] 	= $atributos;
		$data['precios'] 	= $this->Orden_model->get_producto_precios($producto_id);
		$data['prod_precio']= $this->Orden_model->get_producto_precios( $producto_id );

		return $data;
	}

	public function editar($order_id){

		// Seguridad :: Validar URL usuario	
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario );
		$data['menu'] 		= $this->session->menu;

		if($terminal_acceso){

			$data['orden'] 			= $this->Orden_model->get_orden($order_id);
			$data['orden_detalle'] 	= $this->Orden_model->get_orden_detalle($order_id);
			$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
			$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );//$this->Producto_model->get_sucursales();
			$data['modo_pago'] 		= $this->ModoPago_model->get_pagos_by_cliente($data['orden'][0]->id_cliente);
			$data['empleado'] 		= $this->Usuario_model->get_empleado( $data['orden'][0]->id_vendedor );
			$data['terminal'] 		= $terminal_acceso;
			$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
			$data['title'] 			= "Editar Orden";
			$data['cliente'] 		= $this->get_clientes_id(@$data['orden'][0]->id_cliente);
			$data['temp'] 			= $this->Template_model->printer( $data['orden_detalle'] , @$data['orden'][0]->id_sucursal , @$data['orden'][0]->id_tipod, @$data['orden'][0]->id_condpago);
	
			$this->general->editar_valido($data['orden'], "producto/orden/index");

			$data['home'] = 'producto/orden/orden_editar';

			$this->parser->parse('template', $data);
		}else{
			$data['home'] = 'producto/orden/orden_editar';
			$data['temp'] = $this->Template_model->printer( $order_id );
			$this->parser->parse('template', $data);
		}
	}

	public function get_correlativo_documento( $documento , $sucursal ){
		
		$data['correlativo'] = $this->Correlativo_model->get_correlativo_sucursal( $documento , $sucursal );
		
		echo json_encode($data);
	}

	public function update_orden(){

		$dataParametros = array();
		
		$id_usuario = $this->session->usuario[0]->id_usuario;

		foreach ($_POST['encabezado'] as $key => $value) {
		
			foreach ($_POST['encabezado'] as $key => $value) {
		
				$dataParametros[$value['name']] = $value['value'];
			}
		}

		// Obteniendo informacion del cliente

		$cliente = $this->get_clientes_id( $dataParametros['cliente_codigo'] );

		$this->Orden_model->update( $_POST , $id_usuario ,$cliente , $dataParametros);

		redirect(base_url()."producto/orden/index");
	}

	public function cerrar_orden(){
		
		if(isset($_POST)){
			
			$correlativo_orden = $_POST['correlativo_orden'];
			
			$this->Orden_model->cerrar_orden( $correlativo_orden );

		}
	}

	public function autoload_orden(){

		$componente_conf = "combo";		
		$impuesto_conf 	 = "impuestos";

		$data['orden_detalle'] 	= $this->Orden_model->get_orden_detalle($_POST['id']);
		$data['conf'] 			= $this->Orden_model->getConfg($componente_conf);
		$data['impuesto'] 		= $this->Orden_model->getConfgImpuesto($impuesto_conf);
		
		echo json_encode($data);
	}

	public function guardar_orden(){

		$dataParametros = array();
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		foreach ($_POST['encabezado'] as $key => $value) {
			
			foreach ($_POST['encabezado'] as $key => $value) {
			
				$dataParametros[$value['name']] = $value['value'];
			
			}
		}

		// Obteniendo informacion del cliente
		$cliente = $this->get_clientes_id($dataParametros['cliente_codigo']);

		$id = $this->Orden_model->guardar_orden( $_POST , $id_usuario ,$cliente , $dataParametros );
		echo $id;

		//redirect(base_url()."producto/orden/nuevo");
	}

	function get_productos_lista(){

		$sucursal = $_POST['sucursal'];
		$bodega = $_POST['bodega'];
		$texto = $_POST['texto'];
		$data['productos'] = $this->Orden_model->get_productos_valor($sucursal ,$bodega, $texto );
		
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

		$data['bodega'] 		= $this->Orden_model->get_bodega_sucursal( $Sucursal );
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
		//$data['producto_imagen'] = $this->Producto_model->get_productos_imagen($producto_id);	
		echo json_encode( $data );
	}

	function validar_usuario_terminal( $usuario_id  ){

		$terminal_nombe = $_SERVER['REMOTE_ADDR'];//gethostbyaddr($_SERVER['REMOTE_ADDR']);

		$terminal_datos = $this->Terminal_model->validar_usuario_terminal($usuario_id, $terminal_nombe);
		
		if(!$terminal_datos){
			$terminal_datos == FALSE;
		}

		return $terminal_datos;
	}

	/************ Venta Rapida *********/
	public function venta_rapida(){

		// Seguridad :: Validar URL usuario	
		$terminal_acceso 	= FALSE;
		$id_usuario 		= $this->session->usuario[0]->id_usuario;
		$terminal_acceso 	= $this->validar_usuario_terminal( $id_usuario );
		$data['menu'] 		= $this->session->menu;

		if($terminal_acceso){
			
			$data['tipoDocumento'] 	= $this->Orden_model->get_doc_suc_pre();
			$data['sucursales'] 	= $this->Producto_model->get_sucursales();
			$data['modo_pago'] 		= $this->ModoPago_model->getAllFormasPago();
			$data['empleado'] 		= $this->Usuario_model->get_empleado( $id_usuario );
			$data['terminal'] 		= $terminal_acceso;
			//$data['correlativo'] = $this->Correlativo_model->get_correlativo_sucursal(  ,$data['empleado'][0]->id_sucursal );
			$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
			$data['cliente'] 		= $this->Cliente_model->get_cliente();
			$data['title']			= "Ventas Rapidas";
		
			$data['home'] = 'producto/orden/venta_rapida';

			$this->load->view('producto/orden/venta_rapida',$data);
		}else{
			$data['home'] = 'producto/orden/orden_denegado';
			$this->parser->parse('template', $data);
		}
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

	public function table(){

		$this->load->view('producto/orden/table.html');
	}

	public function column(){

		$column = array(
			'Correlativo','Sucursal','Terminal','Cliente','F. Pago','Tipo Doc.','Cajero','Creado','Actual','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			'num_correlativo','nombre_sucursal','num_caja','nombre_empresa_o_compania','nombre_modo_pago','tipo_documento','nombre_usuario','fecha','orden_estado_nombre','estado'
		);
		
		$fields['id'] 		= array('num_correlativo');
		$fields['estado'] 	= array('orden_estado');
		$fields['titulo'] 	= "Orden Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
	
}
