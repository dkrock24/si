<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    @$this->load->library('session');	
	    $this->load->library('pagination');  
	    $this->load->library('../controllers/general');  
		$this->load->helper('url');
		$this->load->helper('paginacion/paginacion_helper');

		$this->load->model('admin/Giros_model');  
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Sucursal_model');
		$this->load->model('admin/Empresa_model');
		$this->load->model('admin/Ciudad_model');
		$this->load->model('admin/Cliente_model');
		$this->load->model('admin/ClienteTipo_model');
		$this->load->model('admin/Pagos_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Documento_model');
		$this->load->model('admin/Empleado_model');
		
	}

// Start  **********************************************************************************

	public function index(){

		$model 		= "Cliente_model";
		$url_page 	= "admin/cliente/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 21);

		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Cliente_model->getAllClientes( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['title'] 			= "Clientes";
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['clienteTipo'] = $this->ClienteTipo_model->get_cliente_tipo();
		$data['menu'] = $this->session->menu;		
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['pago'] = $this->Pagos_model->getTipoPago();
		$data['persona'] = $this->Persona_model->getAllPersona();
		$data['title'] = "Nuevo Cliente";
		$data['home'] = 'admin/cliente/cliente_nuevo';

		echo $this->load->view('admin/cliente/cliente_nuevo',$data, TRUE);
	}

	function get_empleado(){
		$data['empleado'] = $this->Persona_model->getAllPersona();
		echo json_encode($data);
	}

	public function crear(){
		$data = $this->Cliente_model->crear_cliente( $_POST );
		
		if(!$data['code']){
			$this->session->set_flashdata('success', "Cliente Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Cliente No Fue Creado : ". $data['message']);
		}	

		redirect(base_url()."admin/cliente/index");
	}

	public function editar( $cliente_id ){
		
		$data['clienteTipo'] = $this->ClienteTipo_model->get_cliente_tipo();
		$data['menu'] = $this->session->menu;
		$data['cliente'] = $this->Cliente_model->get_clientes_id( $cliente_id );
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['pagoCliente'] = $this->Pagos_model->getPagosClientes($cliente_id);
		$data['pago'] = $this->Pagos_model->getTipoPago();
		$data['persona'] = $this->Persona_model->getAllPersona();
		$data['title'] = "Editar Cliente";
		$data['home'] = 'admin/cliente/cliente_editar';

		$this->general->editar_valido($data['cliente'], "admin/cliente/index");
		echo $this->load->view('admin/cliente/cliente_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/cliente/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Cliente_model->get_clientes_id( $id );
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {
			
				$vars = get_object_vars ( $value );
				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/cliente/index");
		}

	}

	public function eliminar( $cliente_id ){

		$data = $this->Cliente_model->eliminar( $cliente_id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Cliente Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Cliente No Fue Eliminado : ". $data['message']);
		}

		redirect(base_url()."admin/cliente/index");
	}

	public function update(){
		$data = $this->Cliente_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Cliente Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Cliente No Fue Actualizado : ". $data['message']);
		}

		redirect(base_url()."admin/cliente/index");
	}

	public function column(){

		$column = array(
			'Empresa','Codigo','Nombre','Apellido','NRC','NIT','Clase','T. Pago','Saldos','T. Documento', 'Descuento', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_empresa_o_compania'=> 'Nombre'],
			['codigo_cliente' => 'Codigo'],
			['primer_nombre_persona'=> 'Nombre'],
			['primer_apellido_persona'=> 'Apellido'],
			['nrc_cli'=> 'NRC'],
			['nit_cliente'=> 'NIT'],
			['clase_cli' => 'Clase'],
			['codigo_modo_pago' => 'Tipo Pago'],
			['saldos' => 'Saldos'],
			['nombre'=> 'T. Documento'],
			['porcentage_descuentos'=> 'Descuento'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_cliente');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Cliente Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}	

}

?>
