<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impuesto extends MY_Controller {

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
		$this->load->model('admin/Categorias_model');		
		$this->load->model('admin/Impuesto_model');	
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Documento_model');
		$this->load->model('admin/Proveedor_model');
		
	}

	public function index()
	{

		$model 		= "Impuesto_model";
		$url_page 	= "admin/impuesto/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 25);	

		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol']);
		$data['registros'] 		= $this->Impuesto_model->getImpuesto( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];		
		$data['home'] 			= 'template/lista_template';
		$data['title'] 			= "Impuestos";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){
		$data['menu'] 	= $this->session->menu;
		$data['home'] 	= 'admin/impuesto/nuevo';
		$data['title'] 	= "Nuevo Impuesto";
		$this->parser->parse('template', $data);
	}

	public function save(){

		$data = $this->Impuesto_model->nuevo_impuesto( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Impuesto Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Impuesto No Fue Creado : ". $data['message']);
		}

		redirect(base_url()."admin/impuesto/index");
	}

	public function editar( $impuesto_id ){

		$data['menu'] 		= $this->session->menu;
		$data['home'] 		= 'admin/impuesto/editar';
		$data['title'] 		= "Impuestos - Editar";
		$data['impuesto'] 	= $this->Impuesto_model->getImpuestoById( $impuesto_id );

		$this->general->editar_valido($data['impuesto'], "admin/impuesto/index");

		$this->parser->parse('template', $data);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/impuesto/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Impuesto_model->getImpuestoById( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/impuesto/index");
		}

	}

	public function update(){	

		$data = $this->Impuesto_model->updateImpuesto( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Impuesto Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Impuesto No Fue Actualizado : ". $data['message']);
		}	
		
		redirect(base_url()."admin/impuesto/index");
	}

	public function eliminar($id){
		
		$data = $this->Impuesto_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Impuesto Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Impuesto No Fue Eliminado : ". $data['message']);
		}	
		
		redirect(base_url()."admin/impuesto/index");
	}

	public function column(){

		$column = array(
			'Nombre','Porcentaje','SRN','A_producto','A_cliente','A_proveedor','A_G_B_E','Es','Ex','Co','Valor','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			['nombre' => 'Nombre'],
			['porcentage' => 'Porcentaje'],
			['suma_resta_nada' => 'SRN'],
			['aplicar_a_producto' => 'A_producto'],
			['aplicar_a_cliente' => 'A_cliente'],
			['aplicar_a_proveedor' => 'A_proveedor'],
			['aplicar_a_grab_brut_exent' => 'A_G_B_E'],
			['especial' => 'Es'],
			['excluyente' => 'Ex'],
			['condicion' => 'Co'],
			['condicion_valor' => 'Valor'],
			['orden_estado_nombre'  => 'Estado']
		);
		
		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);

		$fields['id'] 		= array('id_tipos_impuestos');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Tipos Impuestos Lista";

		return $fields;
	}

	public function config(){

		$data['menu'] 		= $this->session->menu;
		$data['clientes'] 	= $this->Cliente_model->getCliente();
		$data['impuesto'] 	= $this->Impuesto_model->getAllImpuesto();
		$data['documentos'] = $this->Documento_model->getAllDocumento();
		$data['proveedor'] 	= $this->Proveedor_model->getAllProveedor();
		$data['categoria'] 	= $this->Categorias_model->get_categorias_padres();
		$data['home'] 		= 'admin/impuesto/config';
		$data['title'] 		= "Impuestos - Config";

		$this->parser->parse('template', $data);
	}

	public function asociar(){
		$this->Impuesto_model->asociar($_GET);
	}

	public function deleteImpuesto(){
		$this->Impuesto_model->deleteImpuesto($_GET);
	}

	public function updateImpuesto(){
		$this->Impuesto_model->updateImpuesto2($_GET);	
	}

	public function get_sub_categoria($id_categoria){
		
		$data['subcategoria'] = $this->Categorias_model->get_categorias_hija($id_categoria);

		echo json_encode($data);
	}

	public function getImpuestoDatos($table_intermedia, $tabla_destino , $columna1, $columna2 ,$columna3, $field){

		$data['impuesto_option'] = $this->Impuesto_model->getImpuestoDatos($table_intermedia, $tabla_destino , $columna1, $columna2 , $columna3 ,$field);
		echo json_encode($data);
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}