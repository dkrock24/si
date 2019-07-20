<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impuesto extends CI_Controller {

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

		$this->load->model('admin/Menu_model');		
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Categorias_model');
		$this->load->model('admin/Sucursal_model');	
		$this->load->model('admin/Impuesto_model');	
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/Documento_model');
		$this->load->model('admin/Proveedor_model');
		
	}

	public function index()
	{
		//Paginacion
		$contador_tabla;
		if( isset( $_POST['total_pagina'] )){
			$per_page = $_POST['total_pagina'];
			$_SESSION['per_page'] = $per_page;
		}else{
			if($_SESSION['per_page'] == ''){
				$_SESSION['per_page'] = 10;
			}			
		}
		
		$total_row = $this->Impuesto_model->record_count();
		$config = paginacion($total_row, $_SESSION['per_page'] , "admin/impuesto/index");
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

		$id_rol = $this->session->roles[0];

		$id_rol = $this->session->roles[0];
		$vista_id = 2; // Vista Orden Lista
		$id_usuario 	= $this->session->usuario[0]->id_usuario;

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $vista_id , $id_rol );
		$data['menu'] = $this->session->menu;
		$data['contador_tabla'] = $contador_tabla;
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['registros'] = $this->Impuesto_model->getImpuesto( $config["per_page"], $page );
		$data['home'] = 'template/lista_template';

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/impuesto/nuevo';

		$this->parser->parse('template', $data);
	}

	public function save(){
		$this->Impuesto_model->nuevo_impuesto( $_POST );
		redirect(base_url()."admin/impuesto/index");
	}

	public function editar( $impuesto_id ){
		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['impuesto'] = $this->Impuesto_model->getImpuestoById( $impuesto_id );
		$data['home'] = 'admin/impuesto/editar';

		$this->general->editar_valido($data['impuesto'], "admin/impuesto/index");

		$this->parser->parse('template', $data);
	}

	public function update(){	

		$data['impuesto'] = $this->Impuesto_model->updateImpuesto( $_POST );	
		
		redirect(base_url()."admin/impuesto/index");
	}

	public function column(){

		$column = array(
			'#','Nombre','Porcentaje','SRN','A_producto','A_cliente','A_proveedor','A_G_B_E','Es','Ex','Co','Valor','Estado'
		);
		return $column;
	}

	public function fields(){

		$fields['field'] = array(
			'nombre','porcentage','suma_resta_nada','aplicar_a_producto','aplicar_a_cliente','aplicar_a_proveedor','aplicar_a_grab_brut_exent','especial','excluyente','condicion','condicion_valor','estado'
		);
		
		$fields['id'] = array('id_tipos_impuestos');
		$fields['estado'] = array('imp_estado');
		$fields['titulo'] = "Tipos Impuestos Lista";

		return $fields;
	}

	public function config(){

		$id_rol = $this->session->roles[0];

		$data['menu'] = $this->session->menu;
		$data['impuesto'] = $this->Impuesto_model->getAllImpuesto();
		$data['categoria'] = $this->Categorias_model->get_categorias_padres();
		$data['clientes'] = $this->Cliente_model->getCliente();
		$data['documentos'] = $this->Documento_model->getAllDocumento();
		$data['proveedor'] = $this->Proveedor_model->getAllProveedor();
		$data['home'] = 'admin/impuesto/config';

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
}