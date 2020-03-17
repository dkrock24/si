<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends MY_Controller {

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
	}

	public function index()
	{
		$model = "Compras_model";
		$url_page = "producto/compras/index";
		$pag = $this->MyPagination($model, $url_page, $vista = 89) ;

		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Compras_model->getCompras( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['title'] = "Compras";
		$data['home'] = 'template/lista_template';		

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
    }

    public function nuevo(){
        
		$id_usuario 	= $this->session->usuario[0]->id_usuario;	
		$data['menu'] 	= $this->session->menu;		
		$id_usuario 	= $this->session->usuario[0]->id_usuario;	

		$data['tipoDocumento'] 	= $this->Orden_model->get_tipo_documentos();
		$data['vista_doc']		= $this->Vistas_model->get_vista_documento($vista = 89);
		$data['sucursales'] 	= $this->Sucursal_model->getSucursalEmpleado( $id_usuario );
		$data['empleado'] 		= $this->Usuario_model->get_empleado( $id_usuario );			
		$data['bodega'] 		= $this->Orden_model->get_bodega( $id_usuario );
		$data['moneda'] 		= $this->Moneda_model->get_modena_by_user();
		$data['cliente'] 		= $this->Cliente_model->get_cliente();

		if($data['cliente'][0] ){
			$data['modo_pago'] 	= $this->ModoPago_model->get_pagos_by_cliente(current($data['cliente'][0]));
		}

		$data['proveedor']		= $this->Proveedor_model->getAllProveedor();
		$data['title'] 			= "Nueva Compra";
		$data['home'] 			= 'producto/compras/nuevo';

		$this->parser->parse('template', $data);
	}

	public function editar($compra_id){

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
		$data = $this->Compras_model->guardar_compra($_POST);
		echo $data;
	}

	function update_compra(){
		$data = $this->Compras_model->update_compra($_POST);
		echo $data;
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

    public function column(){

		$column = array(
			'Series','Compra','Sucursal','Bodega','Proveedor','Documento','Creado','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			'numero_serie','fecha_compra','nombre_sucursal','nombre_bodega','empresa_proveedor','Documento','fecha_creacion','estado'
		);
		
		$fields['id'] 		= array('id_compras');
		$fields['estado'] 	= array('status_open_close');
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