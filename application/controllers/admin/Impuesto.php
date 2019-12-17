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

		$model = "Impuesto_model";
		$url_page = "admin/impuesto/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 25);
	

		$data['acciones'] = $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol']);
		$data['registros'] = $this->Impuesto_model->getImpuesto( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		
		$data['home'] = 'template/lista_template';
		$data['title'] = "Impuestos";

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->roles;

		$data['menu'] = $this->session->menu;
		$data['home'] = 'admin/impuesto/nuevo';
		$data['title'] = "Nuevo Impuesto";
		$this->parser->parse('template', $data);
	}

	public function save(){
		$data = $this->Impuesto_model->nuevo_impuesto( $_POST );
		if($data){
			$this->session->set_flashdata('danger', "Impuesto Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Impuesto No Fue Creado");
		}

		redirect(base_url()."admin/impuesto/index");
	}

	public function editar( $impuesto_id ){
		$id_rol = $this->session->roles;

		$data['menu'] = $this->session->menu;
		$data['impuesto'] = $this->Impuesto_model->getImpuestoById( $impuesto_id );
		$data['home'] = 'admin/impuesto/editar';
		$data['title'] = "Impuestos - Editar";

		$this->general->editar_valido($data['impuesto'], "admin/impuesto/index");

		$this->parser->parse('template', $data);
	}

	public function update(){	

		$data['impuesto'] = $this->Impuesto_model->updateImpuesto( $_POST );

		if($data){
			$this->session->set_flashdata('danger', "Impuesto Fue Actualizado");
		}else{
			$this->session->set_flashdata('warning', "Impuesto No Fue Actualizado");
		}	
		
		redirect(base_url()."admin/impuesto/index");
	}

	public function eliminar($id){
		$data['impuesto'] = $this->Impuesto_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('danger', "Impuesto Fue Eliminado");
		}else{
			$this->session->set_flashdata('warning', "Impuesto No Fue Eliminado");
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
			'nombre','porcentage','suma_resta_nada','aplicar_a_producto','aplicar_a_cliente','aplicar_a_proveedor','aplicar_a_grab_brut_exent','especial','excluyente','condicion','condicion_valor','estado'
		);
		
		$fields['id'] = array('id_tipos_impuestos');
		$fields['estado'] = array('imp_estado');
		$fields['titulo'] = "Tipos Impuestos Lista";

		return $fields;
	}

	public function config(){

		$id_rol = $this->session->roles;

		$data['menu'] = $this->session->menu;
		$data['impuesto'] = $this->Impuesto_model->getAllImpuesto();
		$data['categoria'] = $this->Categorias_model->get_categorias_padres();
		$data['clientes'] = $this->Cliente_model->getCliente();
		$data['documentos'] = $this->Documento_model->getAllDocumento();
		$data['proveedor'] = $this->Proveedor_model->getAllProveedor();
		$data['home'] = 'admin/impuesto/config';
		$data['title'] = "Impuestos - Config";

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