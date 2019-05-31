<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {

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
		
	}

	public function index()
	{	

		//Paginacion
		$_SESSION['per_page']='';
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Orden_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "producto/orden/index");
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
		$vista_id = 2; // Vista Orden Lista

		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['registros'] = $this->Orden_model->getOrdenes( $config["per_page"], $page );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['fields'] = $this->fields();
		$data['column'] = $this->column();
		$data['home'] = 'template/lista_template';

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
		parametros($menu_session);

		$id_rol 		= $this->session->roles[0];
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$terminal_acceso = $this->validar_usuario_terminal( $id_usuario );

		$data['menu'] 	= $this->session->menu;

		if($terminal_acceso){
			
			$data['tipoDocumento'] = $this->Orden_model->get_tipo_documentos();
			$data['sucursales'] = $this->Producto_model->get_sucursales();
			$data['modo_pago'] = $this->ModoPago_model->get_formas_pago();
			$data['empleado'] = $this->Usuario_model->get_empleado( $id_usuario );
			$data['terminal'] = $terminal_acceso;
			$data['correlativo'] = $this->Correlativo_model->get_correlativo_sucursal();
			$data['bodega'] = $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] = $this->Moneda_model->get_modena_by_user();
		
			$data['home'] = 'producto/orden/orden_crear';

			$this->parser->parse('template', $data);
		}else{
			$data['home'] = 'producto/orden/orden_denegado';
			$this->parser->parse('template', $data);
		}
		
	}

	public function producto_combo(){
		
		$producto_id = $_POST['producto_id'];
		$id_bodega = $_POST['id_bodega'];

		$data['p_combos'] = $this->Orden_model->producto_combo( $producto_id );
		$data['productos'] = array();

		$cnt = 0;
		foreach ($data['p_combos'] as $key => $value) {
			
			$data['productos'][$cnt] = $this->get_producto_completo2($value->producto_a_descargar_Combo , $id_bodega );
			$data['productos'][$cnt]['combo_cantidad'] = $value->cantidad;
			$cnt +=1;
		}
		//$data['productos'][0] += $data['p_combos'];
		//var_dump($data['productos']);

		echo json_encode($data['productos']);
		
	}

	function get_producto_completo2( $producto_id, $id_bodega ){
		$data['producto'] = $this->Orden_model->get_producto_completo($producto_id, $id_bodega);

		$contador=0;
		$atributos= array();
		foreach ($data['producto'] as $key => $value) {
			$atributos += [ $value->nam_atributo => $data['producto'][$contador]->valor ];
			$contador+=1;
		}

		$data['atributos'] = $atributos;
		$data['precios'] = $this->Orden_model->get_producto_precios($producto_id);
		$data['prod_precio'] = $this->Orden_model->get_producto_precios( $producto_id );

		return $data;
		//echo json_encode( $data );
	}

	public function editar($order_id){

		// Seguridad :: Validar URL usuario	
		$terminal_acceso = FALSE;

		$menu_session 	= $this->session->menu;	
		parametros($menu_session);

		$id_rol 		= $this->session->roles[0];
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$terminal_acceso = $this->validar_usuario_terminal( $id_usuario );

		$data['menu'] 	= $this->session->menu;

		if($terminal_acceso){

			$data['orden'] = $this->Orden_model->get_orden($order_id);
			$data['orden_detalle'] = $this->Orden_model->get_orden_detalle($order_id);
			
			$data['tipoDocumento'] = $this->Orden_model->get_tipo_documentos();
			$data['sucursales'] = $this->Producto_model->get_sucursales();
			$data['modo_pago'] = $this->ModoPago_model->get_formas_pago();
			$data['empleado'] = $this->Usuario_model->get_empleado( $id_usuario );
			$data['terminal'] = $terminal_acceso;
			$data['correlativo'] = $this->Correlativo_model->get_correlativo_sucursal();
			$data['bodega'] = $this->Orden_model->get_bodega( $id_usuario );
			$data['moneda'] = $this->Moneda_model->get_modena_by_user();

			$data['cliente'] = $this->get_clientes_id($data['orden'][0]->id_cliente);

			$data['temp'] = $this->Template_model->printer( $order_id , $data['orden'][0]->id_sucursal , $data['orden'][0]->id_tipod);

			$this->general->editar_valido($data['orden'], "producto/orden/index");

			$data['home'] = 'producto/orden/orden_editar';

			$this->parser->parse('template', $data);
		}else{
			$data['home'] = 'producto/orden/orden_editar';
			$data['temp'] = $this->Template_model->printer( $orden_id );
			$this->parser->parse('template', $data);
		}
	}

	public function update(){
		$id_usuario = $this->session->usuario[0]->id_usuario;

		// Obteniendo informacion del cliente
		$cliente = $this->get_clientes_id($_POST['encabezado'][7]['value']);

		$this->Orden_model->update( $_POST , $id_usuario ,$cliente );

		redirect(base_url()."producto/orden/index");
	}

	public function autoload_orden($order_id){
		$componente_conf = "combo";

		$data['orden_detalle'] = $this->Orden_model->get_orden_detalle($order_id);
		$data['conf'] = $this->Orden_model->getConfg($componente_conf);
		
		echo json_encode($data);
	}

	public function guardar_orden(){

		$id_usuario = $this->session->usuario[0]->id_usuario;

		// Obteniendo informacion del cliente
		$cliente = $this->get_clientes_id($_POST['encabezado'][6]['value']);

		$this->Orden_model->guardar_orden( $_POST , $id_usuario ,$cliente );

		redirect(base_url()."producto/orden/nuevo");
	}

	function get_productos_lista( $sucursal ,$bodega, $texto ){
		$data['productos'] = $this->Orden_model->get_productos_valor($sucursal ,$bodega, $texto);
		echo json_encode( $data );
	}

	function get_bodega( ){
		$id_usuario = $this->session->usuario[0]->id_usuario;
		$data['bodega'] = $this->Orden_model->get_bodega( $id_usuario );
		echo json_encode( $data );
	}

	function get_bodega_sucursal( $Sucursal ){
		$data['bodega'] = $this->Orden_model->get_bodega_sucursal( $Sucursal );
		$data['correlativo'] = $this->Correlativo_model->get_by_id($Sucursal);
		echo json_encode( $data );
	}

	function get_clientes_lista(){
		// Obteniendo Lista Cliente desde Model Cliente

		$data['clientes'] = $this->Cliente_model->get_cliente();
		echo json_encode( $data );
	}

	function get_clientes_documento($id){
		$data['cliente_tipo_pago'] = $this->Cliente_model->get_cliente_by_id2($id);
		$data['tipoDocumento'] = $this->Orden_model->get_tipo_documentos();
		$data['tipoPago'] = $this->Cliente_model->getTipoPago();

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

	function get_producto_completo($producto_id, $id_bodega ){

		$componente_conf = "combo";

		$data['producto'] = $this->Orden_model->get_producto_completo($producto_id, $id_bodega);

		$contador=0;
		$atributos= array();
		foreach ($data['producto'] as $key => $value) {
			$atributos += [ $value->nam_atributo => $data['producto'][$contador]->valor ];
			$contador+=1;
		}

		$data['atributos'] = $atributos;
		$data['precios'] = $this->Orden_model->get_producto_precios($producto_id);
		$data['prod_precio'] = $this->Orden_model->get_producto_precios( $producto_id );
		$data['conf'] = $this->Orden_model->getConfg($componente_conf);
		echo json_encode( $data );
	}

	function validar_usuario_terminal( $usuario_id  ){

		$terminal_nombe = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		
		$terminal_datos = $this->Terminal_model->validar_usuario_terminal($usuario_id, $terminal_nombe);
		
		if(!$terminal_datos){
			$terminal_datos == FALSE;
		}

		return $terminal_datos;
	}

	public function column(){

		$column = array(
			'#','Correlativo','Sucursal','Terminal','Cliente','F. Pago','Tipo Doc.','Cajero','Creado','Actual','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'num_correlativo','nombre_sucursal','num_caja','nombre_empresa_o_compania','nombre_modo_pago','tipo_documento','nombre_usuario','fecha','orden_estado_nombre','estado'
		);
		
		$fields['id'] = array('id');
		$fields['estado'] = array('orden_estado');
		$fields['titulo'] = "Orden Lista";

		return $fields;
	}

	
}
