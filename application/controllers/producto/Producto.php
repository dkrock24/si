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

		$this->load->model('admin/Menu_model');	

		$this->load->model('producto/Producto_model');	
		$this->load->model('admin/Giros_model');	
	}

	public function index()
	{	
		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['prod'] = $this->Producto_model->getProd( );

		$data['home'] = 'producto/producto/prod_lista';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['categorias'] = $this->Producto_model->get_sub_categorias();
		$data['empresa'] = $this->Giros_model->get_empresa();

		$data['home'] = 'producto/producto/prod_nuevo';

		$this->parser->parse('template', $data);
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

		$id_rol = $this->session->usuario[0]->id_rol;

		$data['menu'] = $this->Menu_model->getMenu( $id_rol );
		$data['producto'] = $this->Producto_model->get_producto( $id_producto );
		$data['categorias'] = $this->Producto_model->get_sub_categorias();
		$data['empresa'] = $this->Giros_model->get_empresa();

		$data['home'] = 'producto/producto/prod_editar';

		$this->parser->parse('template', $data);
	}

	public function actualizar(){

		$this->Producto_model->actualizar_producto( $_POST );

		redirect(base_url()."producto/producto/index");
	}

	public function get_giros_empresa( $id_empresa ){

		$giros = $this->Giros_model->get_giros_empresa( $id_empresa );

		echo json_encode( $giros );
	}
	
}