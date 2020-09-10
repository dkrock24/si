<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends MY_Controller {

	var $vista_id = 0;

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
		$this->load->model('admin/Empleado_model');		
	}

	public function index()
	{
		$model 		= "Compras_model";
		$url_page 	= "producto/compras/index";
		$pag 		= $this->MyPagination($model, $url_page, $vista = 89) ;

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['registros'] 		= $this->Compras_model->getCompras( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] 			= "Compras";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
    }

    public function nuevo(){

		$this->vista_id = 89;
        
		$id_usuario 	= $this->session->usuario[0]->id_usuario;	
		$data['menu'] 	= $this->session->menu;		
		$id_usuario 	= $this->session->usuario[0]->id_usuario;	

		$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
		$data['vista_doc']		= $this->Vistas_model->get_vista_documento($this->vista_id);
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['empleado'] 		= $this->Usuario_model->get_empleado_oren( $id_usuario );			
		$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 		= $this->Cliente_model->get_cliente();
		$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);

		if($data['cliente'][0] ){
			$data['modo_pago'] 	= $this->ModoPago_model->get_pagos_by_cliente(current($data['cliente'][0]));
		}

		$data['proveedor']		= $this->Proveedor_model->getAllProveedor();
		$data['title'] 			= "Nueva Compra";
		$data['home'] 			= 'producto/compras/nuevo';

		$this->parser->parse('template', $data);
	}

	public function editar($compra_id){

		$this->vista_id = 89;

		$id_usuario 	    = $this->session->usuario[0]->id_usuario;		
		$data['menu'] 	    = $this->session->menu;	
		$data['compra'] 	= $this->Compras_model->editar_compra($compra_id);
		$data['detalle'] 	= $this->Compras_model->get_compra_detalle($compra_id);
		$data['empleado'] 	= $this->Empleado_model->getEmpleadoId( $data['compra'][0]->Empleado );
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal();
		$data['vista_doc']	= $this->Vistas_model->get_vista_documento($this->vista_id);
		$data['proveedor']	= $this->Proveedor_model->get_proveedor_id( $data['compra'][0]->Proveedor  );
		$data['bodega'] 	= $this->Bodega_model->get_bodega_sucursal( $data['compra'][0]->Sucursal );
		$data['moneda'] 	= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 	= $this->Cliente_model->get_cliente();
		$data['estados']		= $this->Estados_model->get_estados_vistas($this->vista_id);

		if($data['cliente'][0] ){
			$data['modo_pago'] 	= $this->ModoPago_model->get_pagos_by_cliente(current($data['cliente'][0]));
		}

		$data['temp'] 		= $this->Compras_model->printer( $data['compra'] );
		$name 				= $data['compra'][0]->Tipo_Documento.'_'.$data['compra'][0]->Sucursal.'_'.$data['compra'][0]->Empresa;
		$data['file'] 		= $name;

		$data['msj_title'] = "Compra Creada Correctamente";
		$data['msj_orden'] = "Transación: # ". $data['compra'][0]->numero_serie ;

		$this->generarDocumento( $name , $data['temp'][0]->factura_template );
		
		$data['home'] = 'producto/compras/compra_editar';
		$this->parser->parse('template', $data);
	}

	public function autoload_traslado(){
		$id 				= $_POST['id'];
		$componente_conf 	= "combo";		
		$impuesto_conf 	 	= "impuestos";

		$data['traslado'] 	= $this->Compras_model->get_compra_detalle($id);
		$data['conf'] 		= $this->Orden_model->getConfg($componente_conf);
		$data['impuesto'] 	= $this->Orden_model->getConfgImpuesto($impuesto_conf);

		echo json_encode($data);
	}

	function get_bodega_sucursal( $Sucursal ){

		$data['bodega']	= $this->Orden_model->get_bodega_sucursal_traslados( $Sucursal );

		echo json_encode( $data );
	}

	function guardar_compra(){

		foreach ($_POST['encabezado'] as $key => $value) {
			$compra[$value['name']] = $value['value'];
		}

		$data 		= $this->Compras_model->guardar_compra($_POST , $compra);
		$documento 	= $this->Documento_model->getDocumentoById($compra['id_tipo_documento']);
		
		if(!$data['code']){
			$this->EfectosDocumento_model->accion($_POST , $documento );

			$this->session->set_flashdata('success', "Compra Fue Creada");

			$data =  ['id' => $data];

		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Compra No Fue Creada :". $data['message']);
		}

		echo json_encode( $data );
	}

	function update_compra(){

		foreach ($_POST['encabezado'] as $key => $value) {
			$compra[$value['name']] = $value['value'];
		}

		/*
		* obteniendo la compra
		*/
		$_compra['compra'] 	= $this->Compras_model->editar_compra($compra['id_compras']);
		$productos['orden'] = $this->Compras_model->get_compra_detalle($compra['id_compras']);
		$data 				= $this->Compras_model->update_compra($_POST , $compra);
		
		$productos['orden'][0]->id_bodega 	= $_compra['compra'][0]->Bodega;
		$productos['orden'][0]->producto_id = $productos['orden'][0]->id_producto;
		
		if(!isset($data['code'])){

			/*
			* Guardando los valores del reintegro de la compra a su bodega correspondiente
			*/		
			$documento[0] 		= (object) array('efecto_inventario' => '2'); 
			$productos['orden'] = json_decode(json_encode($productos['orden']), true);
			$productos['orden'][0]['cantidad'] = $productos['orden'][0]['cantidad_pro_compra'];		
			$this->EfectosDocumento_model->accion($productos , $documento );
			
			/*
			* Guardando los valores nuevo de la compra
			*/
			$documento[0] 	= (object) array('efecto_inventario' => '1');
			$documento 		= $this->Documento_model->getDocumentoById($compra['id_tipo_documento']);
			$_POST['orden'][0]['id_bodega'] = $compra['bodega'];
			$this->EfectosDocumento_model->accion($_POST , $documento );

			$this->session->set_flashdata('info', "Compra Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Compra No Fue Actualizada :". $data['message']);
		}

		echo json_encode($data);
	}
	
	function get_impuestos_lista(){

		$data['impuesto_categoria'] = $this->Impuesto_model->getAllImpCat();
		$data['impuesto_cliente'] 	= $this->Impuesto_model->getAllImpCli();
		$data['impuesto_documento'] = $this->Impuesto_model->getAllImpDoc();
		$data['impuesto_proveedor'] = $this->Impuesto_model->getAllImpProv();

		echo json_encode( $data );
	}

	function get_productos_lista(){
		$texto = $_POST['texto'];
		$data['productos'] = $this->Compras_model->get_productos_valor($texto);		
		
		echo json_encode( $data );
	}

	function get_producto_completo($id_producto_detalle ){

		$combo_conf 		= "combo";
		$impuesto_conf 		= "impuestos";
		$descuento_conf		= "descuentos";
		
		$data['producto'] 	= $this->Compras_model->get_producto_completo($id_producto_detalle);		
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

	function get_proveedor_lista($proveedor_texto){
		
		$data['clientes'] = $this->Proveedor_model->get_proveedor_filtro($proveedor_texto);

		echo json_encode( $data );
	}

	public function print_compra($compra_id){

		$id_usuario 	    = $this->session->usuario[0]->id_usuario;		
		$data['menu'] 	    = $this->session->menu;	
		$data['compra'] 	= $this->Compras_model->editar_compra($compra_id);
		$data['detalle'] 	= $this->Compras_model->get_compra_detalle($compra_id);
		$data['empleado'] 	= $this->Usuario_model->get_empleado( $id_usuario );
		$data['sucursal'] 	= $this->Sucursal_model->getSucursal();
		$data['vista_doc']	= $this->Vistas_model->get_vista_documento($vista = 89);
		$data['proveedor']	= $this->Proveedor_model->get_proveedor_id( $data['compra'][0]->Proveedor  );
		$data['bodega'] 	= $this->Bodega_model->get_bodega_sucursal( $data['compra'][0]->Sucursal );
		$data['moneda'] 	= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 	= $this->Cliente_model->get_cliente();

		if($data['cliente'][0] ){
			$data['modo_pago'] 	= $this->ModoPago_model->get_pagos_by_cliente(current($data['cliente'][0]));
		}

		$data['temp'] 		= $this->Compras_model->printer( $data['compra'] );
		$name 				= $data['compra'][0]->Tipo_Documento.'_'.$data['compra'][0]->Sucursal.'_'.$data['compra'][0]->Empresa;
		$data['file'] 		= $name;

		$data['msj_title'] = "Compra Creado Correctamente";
		$data['msj_orden'] = "Transación: # ". $data['compra'][0]->numero_serie ;

		$data['home'] = 'producto/print/print';
		$this->load->view('producto/print/print', $data);		

	}

	public function eliminar($compra_id){

		$data['compra'] 	= $this->Compras_model->editar_compra($compra_id);
		$data['detalle'] 	= $this->Compras_model->get_compra_detalle($compra_id);
		$bodega 			= $data['compra'][0]->Bodega;
		$orden['orden'] 	= (object) $data['detalle'];
		$flag = false;

		foreach ($orden['orden'] as $key => $productos) {
			// Restar en inventarios
			$this->EfectosDocumento_model->anulacionCompra(
				$productos->id_producto , 
				$bodega,
				$productos->cantidad_pro_compra
			);
			$flag = true;
		}

		//Eliminar Encbezado
		$data = $this->Compras_model->eliminar($compra_id);

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Compra Fue Eliminada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Compra No Fue Eliminada :". $data['message']);
		}

		redirect(base_url()."producto/compras/index");
	}

    public function column(){

		$column = array(
			'Referencia','Serie','Sucursal','Bodega','Proveedor','Documento','Compra','Creado','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			['documento_referencia' => 'Referencia'],
			['numero_serie' => 'Serie'],
			['nombre_sucursal' => 'Sucursal'],
			['nombre_bodega' => 'Bodega'],
			['empresa_proveedor' => 'Proveedor'],
			['Documento' => 'Documento'],
			['fecha_compra' => 'Compra'],
			['fecha_creacion' => 'Creado'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_compras');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Compras Lista";
		$fields['estado_alterno'] 	= "Completado";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

    }
    
}