<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
	}

	public function index()
	{
		$model = "Producto_model";
		$url_page = "producto/producto/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 9);

		$data['registros'] 		= $this->Producto_model->getProd(
										$pag['config']["per_page"], 
										$pag['page'],
										$_SESSION['filters'] 
								);
		
		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];		
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();		
		$data['title'] 			= "Productos";
		$data['home'] 			= 'template/lista_template';
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol 			= $this->session->userdata['usuario'][0]->id_rol;
		$vista_id 			= 12;
		$data['menu'] 		= $this->session->menu;
		$data['categorias'] = $this->Producto_model->get_sub_categorias();
		$data['lineas'] 	= $this->Producto_model->get_lineas();
		$data['proveedor'] 	= $this->Producto_model->get_proveedor();
		$data['marcas'] 	= $this->Producto_model->get_marcas();
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] 		= "Nuevo Producto";
		$data['empresa'] 	= $this->Giros_model->get_empresa();
		$data['home'] 		= 'producto/producto/prod_nuevo';

		$this->parser->parse('template', $data);
	}

	public function show( $id_producto ){

	}

	public function crear(){
		
		$producto_id = $this->Producto_model->nuevo_producto( $_POST , $this->session->usuario );

		$this->save_producto_bodega($producto_id);

		if($producto_id){
			$this->session->set_flashdata('success', "Producto Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Producto No Fue Creado");
		}

		redirect(base_url()."producto/producto/index");

	}

	public function save_producto_bodega( $producto_id ){
		
		$id_rol = $this->session->roles[0];
		$data 	= $this->Bodega_model->getBodegaProducto();

		$this->Producto_model->save_producto_bodega( $producto_id , $data );

	}

	public function sub_categoria_byId($id_categoria){

		$data['subcategorias'] 	= $this->Producto_model->sub_categoria( $id_categoria );
		$data['marcas'] 		= $this->Marca_model->get_marca_categoria( $id_categoria );
		echo json_encode( $data );
	}

	public function editar( $id_producto ){

		$id_rol = $this->session->roles;
		$vista_id = 12;

		$data['menu'] 		= $this->session->menu;
		$data['producto'] 	= $this->Producto_model->get_producto( $id_producto );
		$data['precios'] 	= $this->Producto_model->get_precios( $id_producto );
		$data['atributos'] 	= $this->Producto_model->get_producto_atributos( $id_producto );
		$data['categorias'] = $this->Producto_model->get_categorias();
		$data['sub_categorias'] = $this->Producto_model->get_sub_categorias();
		$data['empresa'] 	= $this->Giros_model->get_empresa();
		$data['empresa_giro'] = $this->Giros_model->get_empresa_giro2();
		$data['marcas'] 	= $this->Producto_model->get_marcas();
		$data['proveedor'] 	= $this->Producto_model->get_proveedor();
		$data['producto_proveedor'] = $this->Producto_model->get_producto_proveedor( $id_producto  );
		$data['clientes'] 	= $this->Producto_model->get_clientes();
		$data['sucursal'] 	= $this->Producto_model->get_sucursal_producto();
		$data['acciones'] 	= $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['title'] 		= "Editar Producto";
		$data['home'] 		= 'producto/producto/prod_editar';

		$this->general->editar_valido($data['producto'], "producto/producto/index");

		$this->parser->parse('template', $data);
	}

	public function eliminar( $producto_id ){

		if($producto_id ){
			
			$producto_id = $this->Producto_model->eliminar( $producto_id );

			if($producto_id){
				$this->session->set_flashdata('warning', "Producto Fue Eliminado");
			}else{
				$this->session->set_flashdata('danger', "Producto No Fue Eliminado");
			}
	
			redirect(base_url()."producto/producto/index");

		}
	}

	function get_productos_lista(){

		$data['productos'] = $this->Producto_model->getAllProducto();
		echo json_encode( $data );
	} 

	public function get_atributos_producto( $prodcuto_id ){

		$data['atributos'] = $this->Producto_model->get_producto_atributos( $prodcuto_id );
		echo json_encode( $data );
	}

	public function get_clientes(){

		$clientes['cliente'] 	= $this->Producto_model->get_clientes2( );
		$clientes['sucursal'] 	= $this->Producto_model->get_sucursal_producto( );
		$clientes['impuesto'] 	= $this->Producto_model->get_inpuesto( );

		echo json_encode( $clientes );
	}

	public function get_sucursales(){

		$sucursales = $this->Producto_model->get_sucursales( );
		echo json_encode( $sucursales );
	}

	public function actualizar(){

		$data = $this->Producto_model->actualizar_producto( $_POST );

		if($data){
			$this->session->set_flashdata('info', "Producto Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Producto No Fue Actualizado");
		}

		redirect(base_url()."producto/producto/index");
	}

	public function get_giros_empresa( $id_empresa ){

		$giros = $this->Giros_model->get_giros_empresa( $id_empresa );

		echo json_encode( $giros );
	}

	public function get_categorias_empresa( $id_empresa ){

		$giros = $this->Categorias_model->get_categorias_empresa( $id_empresa );

		echo json_encode( $giros );
	}

	public function get_empresa_giro_atributos( $_giro ){

		$data['plantilla'] = $this->Producto_model->get_empresa_giro_atributos( $_giro );

		echo json_encode( $data );
	}

	// PRODUCTO BODEGA

	public function bodega(){

		$id_usuario 	  = $this->session->usuario[0]->id_usuario;
		$data['producto'] = "";

		if($_POST){
			
			$data['prod_bodega'] = $this->Bodega_model->getProductoByBodega($_POST);

			if( $data['prod_bodega'] ){

				$data['producto_id']= $data['prod_bodega'][0]->id_entidad;
				$data['bodega'] 	= $this->Bodega_model->getAllBodegas( $id_usuario );
				$data['producto'] 	= $_POST['producto'];
			}
			
		}

		$data['menu'] = $this->session->menu;		

		$data['home'] = 'producto/producto/prod_bodega';

		$this->parser->parse('template', $data);
	}
	
	public function producto_activar(){ // Activar / Desactivar - Producto de la Bodega

		$this->Producto_model->producto_activar( $_POST );

		$data['producto'] = $_POST['producto'];

		$data['home'] = 'producto/producto/prod_bodega';

		$this->parser->parse('template', $data);
	}

	public function associar_bodega(){ // Asociar - Producto de la Bodega

		$this->Producto_model->associar_bodega( $_POST );

		redirect(base_url()."producto/producto/bodega");
	}

	public function filtrar(){
		
		$flag = false;

		$filtro = "";

		foreach ($_POST as $key => $field) {
			
			if($field){
				$filtro .= " and ". $key ." like '%$field%' ";
			}
		}
		
		$this->index($filtro);
	}

	public function column(){

		$column = array(
			'Codigo','Producto','Sub Categoria','Marca','Giro','Precio','Costo','Existencias','Creado','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			'codigo_barras','name_entidad','nombre_categoria','nombre_marca',
			'nombre_giro','precio_venta','costo','prodCantidad','creado_producto','estado'
		);

		$moneda_simbolo = $this->return_modena();

		$fields['reglas'] = array(
			'precio_venta' => array(
				'valor' => $moneda_simbolo[0]->moneda_simbolo .' ',
				'aplicar' => 'precio_venta'
			),
			'costo' => array(
				'valor' => $moneda_simbolo[0]->moneda_simbolo .' ',
				'aplicar' => 'costo'
			),
		);
		
		$fields['id'] = array('id_entidad');
		$fields['estado'] = array('producto_estado');
		$fields['titulo'] = "Producto Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();
		
		$this->xls( $_SESSION['registros'] , $_SESSION['Vista'] ,$column, $fields  );

	}

	public function demo(){
		$this->load->view('producto/producto/demo.php');
	}

	
}
