<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

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
	}

// Start  **********************************************************************************

	public function index(){

		$model = "Cliente_model";
		$url_page = "admin/cliente/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 21);


		$data['menu'] = $this->session->menu;
		$data['links'] = $pag['links'];
		$data['filtros'] = $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] = $this->column();
		$data['fields'] = $this->fields();
		$data['total_pagina'] = $pag['config']["per_page"];
		$data['total_records'] 	= $pag['total_records'];

		$data['acciones'] = $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] = $this->Cliente_model->getAllClientes( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['title'] = "Clientes";
		$data['home'] = 'template/lista_template';

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  = $data['title'];

		$this->parser->parse('template', $data);
	}

	public function nuevo(){

		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['clienteTipo'] = $this->ClienteTipo_model->get_cliente_tipo();
		$data['menu'] = $this->session->menu;		
		//	$data['empresa'] = $this->Empresa_model->getEmpresas();
		$data['documento'] = $this->Documento_model->getAllDocumento();
		$data['pago'] = $this->Pagos_model->getTipoPago();
		$data['persona'] = $this->Persona_model->getAllPersona();
		$data['title'] = "Nuevo Cliente";
		$data['home'] = 'admin/cliente/cliente_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert Nuevo Cliente
		
		$data = $this->Cliente_model->crear_cliente( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Cliente Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Cliente No Fue Creado");
		}	

		redirect(base_url()."admin/cliente/index");
	}

	public function editar( $cliente_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

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
		$this->parser->parse('template', $data);
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

		if($data){
			$this->session->set_flashdata('success', "Cliente Fue Eliminado");
		}else{
			$this->session->set_flashdata('warning', "Cliente No Fue Eliminado");
		}

		redirect(base_url()."admin/cliente/index");
	}

	public function update(){
		// Actualizar Giro 
		$data = $this->Cliente_model->update( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Cliente Fue Actualizado");
		}else{
			$this->session->set_flashdata('warning', "Cliente No Fue Actualizado");
		}

		redirect(base_url()."admin/cliente/index");
	}

	public function column(){

		$column = array(
			'Nombre','Nombre','Apellido','NRC','NIT','Clase','T. Pago','T. Documento', 'Descuento', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			'nombre_empresa_o_compania','primer_nombre_persona','primer_apellido_persona','nrc_cli','nit_cliente','clase_cli','codigo_modo_pago','nombre','porcentage_descuentos','estado'
		);
		
		$fields['id'] = array('id_cliente');
		$fields['estado'] = array('estado_cliente');
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
