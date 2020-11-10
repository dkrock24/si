<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traslado extends MY_Controller {

	var $vista_id = 88;

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
		$this->load->model('producto/Estados_model');

	}

	public function index()
	{
		$model 		= "Traslado_model";
		$url_page 	= "producto/traslado/index";
		$pag 		= $this->MyPagination($model, $url_page, $this->vista_id) ;

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['registros'] 		= $this->Traslado_model->getTraslado( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] 			= "Traslados";
		$data['home'] 			= 'template/lista_template';		

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		// Seguridad :: Validar URL usuario			
		$id_usuario 	    = $this->session->usuario[0]->id_usuario;		
		$data['menu'] 	    = $this->session->menu;			

		$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
		$data['vista_doc']		= $this->Vistas_model->get_vista_documento($this->vista_id);
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['empleado'] 		= $this->Usuario_model->get_empleado( $id_usuario );			
		$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 		= $this->Cliente_model->get_cliente();
		$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);
		$data['title'] 			= "Nuevo Traslado";
		$data['home'] 			= 'producto/traslado/nuevo';

		$this->parser->parse('template', $data);
		
		
	}

	public function save_traslado(){

		$registros = array();

		$encabezado = $_POST['encabezado'];
		foreach ($encabezado as $key => $value) {
			$registros[$value['name']] = $encabezado[$key]['value'];
		}
		$data = $this->Traslado_model->save_traslado($_POST['productos'] , $_POST['encabezado']);
		
		$documento 	= $this->Documento_model->getDocumentoById($registros['documento']);
		
		$_POST['productos'][0]['id_bodega'] = $registros['bodega_origen'];
		
		$traslado['orden']  = $_POST['productos'];

		$this->EfectosDocumento_model->accion($traslado , $documento );

		echo $data;
	}

	public function editar($traslado_id){

		$id_usuario 	    = $this->session->usuario[0]->id_usuario;		
		$data['menu'] 	    = $this->session->menu;	
		$data['traslado'] 	= $this->Traslado_model->editar_traslado($traslado_id);
		$data['detalle'] 	= $this->Traslado_model->get_traslado_detalle($traslado_id);
		$data['empleado'] 	= $this->Usuario_model->get_empleado( $id_usuario );
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal(  );
		$data['bodega'] 	= $this->Bodega_model->get_bodega_sucursal( $data['traslado'][0]->sucursal_origin );
		$data['bodega2'] 	= $this->Bodega_model->get_bodega_sucursal( $data['traslado'][0]->sucursal_destino );
		$data['moneda'] 	= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 	= $this->Cliente_model->get_cliente();
		$data['estados']	= $this->Estados_model->get_estados_vistas($this->vista_id);

		$data['temp'] 		= $this->Traslado_model->printer( $data['traslado'] );
		$name 				= $data['traslado'][0]->sucursal_origin.$data['traslado'][0]->Empresa;
		$data['file'] 		= $name;

		$data['msj_title'] = "Traslado Creado Correctamente";
		$data['msj_orden'] = "Transación: # ". $data['traslado'][0]->correlativo_tras ;

		$this->generarDocumento( $name , $data['temp'][0]->factura_template );

		
		$data['home'] = 'producto/traslado/traslado_editar';
		$this->parser->parse('template', $data);
	}

	public function print_traslado($traslado_id){
		$id_usuario 	    = $this->session->usuario[0]->id_usuario;		
		
		$data['traslado'] 	= $this->Traslado_model->editar_traslado($traslado_id);
		$data['detalle'] 	= $this->Traslado_model->get_traslado_detalle($traslado_id);
		$data['empleado'] 	= $this->Usuario_model->get_empleado( $id_usuario );
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal();
		$data['bodega'] 	= $this->Bodega_model->get_bodega_sucursal( $data['traslado'][0]->sucursal_destino );
		$data['moneda'] 	= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 	= $this->Cliente_model->get_cliente();	

		$data['temp'] 		= $this->Traslado_model->printer( $data['traslado'] );
		$name 				= $data['traslado'][0]->sucursal_origin.$data['traslado'][0]->Empresa;
		$data['file'] 		= $name;

		$data['home'] = 'producto/print/print';
		$this->load->view('producto/print/print', $data);		

	}

	public function ver($traslado_id){

		$id_usuario 	    = $this->session->usuario[0]->id_usuario;		
		$data['menu'] 	    = $this->session->menu;	
		$data['traslado'] 	= $this->Traslado_model->editar_traslado($traslado_id);
		$data['detalle'] 	= $this->Traslado_model->get_traslado_detalle($traslado_id);
		$data['empleado'] 	= $this->Usuario_model->get_empleado( $id_usuario );
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal();
		$data['bodega'] 	= $this->Bodega_model->get_bodega_sucursal( $data['traslado'][0]->sucursal_destino );
		$data['moneda'] 	= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 	= $this->Cliente_model->get_cliente();

		$data['home'] = 'producto/traslado/traslado_detalle';
		$this->parser->parse('template', $data);

		
	}

	public function aceptar(){
		
		if(isset($_POST)){
			$data = $this->Traslado_model->aceptar_traslado($_POST);

			if(!$data['code']){
				$this->session->set_flashdata('success', "Traslado Fue Ingresado En Sucursal Destino");
			}else{
				$this->session->set_flashdata('danger', "Traslado No Fue Ingresado");
			}

		}
		redirect(base_url()."producto/traslado/index");
		
	}

	public function autoload_traslado(){
		$id = $_POST['id'];
		$componente_conf = "combo";		
		$impuesto_conf 	 = "impuestos";

		$data['traslado'] 	= $this->Traslado_model->get_traslado_detalle($id);
		$data['conf'] 		= $this->Orden_model->getConfg($componente_conf);
		$data['impuesto'] 	= $this->Orden_model->getConfgImpuesto($impuesto_conf);

		echo json_encode($data);
	}

	public function update_traslado(){

		$data = $this->Traslado_model->update( $_POST['productos'] , $_POST['encabezado'] );

		if($data){
			$this->session->set_flashdata('info', "Traslado Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Traslado No Fue Actualizado");
		}

		redirect(base_url()."producto/orden/index");
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

		$data['bodega'] 		= $this->Orden_model->get_bodega_sucursal_traslados( $Sucursal );

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
		$data['descuentos'] 		= $this->Orden_model->getConfgDescuento($descuento_conf);
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



	public function table(){

		$this->load->view('producto/orden/table.html');
	}

	public function column(){

		$column = array(
			'Correlativo','Firma Salida','Firma Llegada','Salida','Llegada','Total','Origen','Destino','Creado','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			['correlativo_tras' => 'Correlativo'],
			['envia' => 'Firma Salida'],
			['recibe' => 'Firma Llegada'],
			['fecha_salida' => 'Salida'],
			['fecha_llegada' => 'Llegada'],
			['total_productos_tras' => 'Total'],
			['origen' => 'Origen'],
			['destino' => 'Destino'],
			['creado_tras' => 'Creado'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_tras');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Traslados Lista";
		//$fields['estado_alterno'] 	= "Completado";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}
	
}
