<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->database(); 

		$this->load->library('parser');
		@$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('seguridad/url_helper');

		$this->load->model('admin/Menu_model');	

		$this->load->model('producto/Producto_model');	
		$this->load->model('producto/Bodega_model');	
		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Giros_model');	
		$this->load->model('admin/Sucursal_model');	
	}

	public function index()
	{
		// Seguridad :: Validar URL usuario	
		$menu_session = $this->session->menu;	
		parametros($menu_session);

		$id_rol = $this->session->roles[0];
		$vista_id = 9;

		$data['menu'] = $this->session->menu;
		$data['prod'] = $this->Producto_model->getProd();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['home'] = 'producto/producto/prod_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->roles[0];
		$vista_id = 12;

		$data['menu'] = $this->session->menu;
		$data['categorias'] = $this->Producto_model->get_sub_categorias();
		$data['lineas'] = $this->Producto_model->get_lineas();
		$data['proveedor'] = $this->Producto_model->get_proveedor();
		$data['marcas'] = $this->Producto_model->get_marcas();
		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['empresa'] = $this->Giros_model->get_empresa();

		$data['home'] = 'producto/producto/prod_nuevo';

		$this->parser->parse('template', $data);
	}

	public function show( $id_producto ){

	}

	public function crear(){
		
		$this->Producto_model->nuevo_producto( $_POST , $this->session->usuario );

		redirect(base_url()."producto/producto/index");
	}

	public function sub_categoria_byId($id_categoria){

		$subcategorias = $this->Producto_model->sub_categoria( $id_categoria );
		//var_dump($subcategorias);

		echo json_encode( $subcategorias );
	}

	public function editar( $id_producto ){

		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['producto'] = $this->Producto_model->get_producto( $id_producto );
		$data['precios'] = $this->Producto_model->get_precios( $id_producto );
		$data['atributos'] = $this->Producto_model->get_producto_atributos( $id_producto );
		$data['categorias'] = $this->Producto_model->get_categorias();
		$data['sub_categorias'] = $this->Producto_model->get_sub_categorias();
		$data['empresa'] = $this->Giros_model->get_empresa();
		$data['marcas'] = $this->Producto_model->get_marcas();
		$data['proveedor'] = $this->Producto_model->get_proveedor();
		$data['producto_proveedor'] = $this->Producto_model->get_producto_proveedor( $id_producto  );
		$data['clientes'] = $this->Producto_model->get_clientes();
		$data['sucursal'] = $this->Producto_model->get_sucursales();

		
		$data['home'] = 'producto/producto/prod_editar';

		$this->parser->parse('template', $data);
	}

	function get_productos_lista(){
		$data['productos'] = $this->Producto_model->getProd();
		echo json_encode( $data );
	} 

	public function get_atributos_producto( $prodcuto_id ){
		$data['atributos'] = $this->Producto_model->get_producto_atributos( $prodcuto_id );
		echo json_encode( $data );
	}

	public function get_clientes(){

		$clientes['cliente'] = $this->Producto_model->get_clientes( );
		$clientes['sucursal'] = $this->Producto_model->get_sucursales( );
		$clientes['impuesto'] = $this->Producto_model->get_inpuesto( );

		echo json_encode( $clientes );
	}

	public function get_sucursales(){
		$sucursales = $this->Producto_model->get_sucursales( );
		echo json_encode( $sucursales );
	}

	public function actualizar(){

		$this->Producto_model->actualizar_producto( $_POST );

		redirect(base_url()."producto/producto/index");
	}

	public function get_giros_empresa( $id_empresa ){

		$giros = $this->Giros_model->get_giros_empresa( $id_empresa );

		echo json_encode( $giros );
	}

	public function get_empresa_giro_atributos( $_giro ){

		$data['plantilla'] = $this->Producto_model->get_empresa_giro_atributos( $_giro );

		echo json_encode( $data );
	}

	// PRODUCTO BODEGA

	public function bodega(){

		$id_usuario 	= $this->session->usuario[0]->id_usuario;
		
		if($_POST){
			$producto_id = $_POST['producto'];
			$data['producto_id'] = $producto_id;
			$data['prod_bodega'] = $this->Bodega_model->getProductoByBodega($_POST);
			$data['bodega'] = $this->Bodega_model->getBodegas( $id_usuario );
		}

		
		$data['prod'] = $this->Producto_model->getProd();
		$data['menu'] = $this->session->menu;

		$data['home'] = 'producto/producto/prod_bodega';

		$this->parser->parse('template', $data);
	}

	// Activar / Desactivar - Producto de la Bodega
	public function producto_activar(){

		$this->Producto_model->producto_activar( $_POST );

		redirect(base_url()."producto/producto/bodega");
	}

	// Asociar - Producto de la Bodega
	public function associar_bodega(){

		$this->Producto_model->associar_bodega( $_POST );

		redirect(base_url()."producto/producto/bodega");
	}

	
}
