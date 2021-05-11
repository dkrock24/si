<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClienteTipo extends MY_Controller {

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
	}

// Start  **********************************************************************************

	public function index(){

		$model 		= "Cliente_model";
		$url_page 	= "admin/clienteTipo/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 95); //95 Cliente tipo

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->ClienteTipo_model->getAllClientesTipo( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Clientes Tipo";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;
		$data['title'] = "Nuevo Tipo Cliente";
		$data['home'] = 'admin/clienteTipo/clientetipo_nuevo';

		echo $this->load->view('admin/clienteTipo/clientetipo_nuevo',$data, TRUE);
	}

	public function crear(){
		
		$data = $this->ClienteTipo_model->crear_clienteTipo( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Tipo Cliente Fue Creado");
		}else{
			$this->session->set_flashdata('danger', "Tipo Cliente No Fue Creado");
		}	

		redirect(base_url()."admin/ClienteTipo/index");
	}

	public function editar( $cliente_id ){

		$data['menu'] = $this->session->menu;
		$data['cliente'] = $this->ClienteTipo_model->get_clientes_tipo_id( $cliente_id );

		$data['title'] = "Editar Cliente Tipo";
		$data['home'] = 'admin/clienteTipo/clientetipo_editar';

		$this->general->editar_valido($data['cliente'], "admin/cliente/index");

		//$this->parser->parse('template', $data);
		echo $this->load->view('admin/clienteTipo/clientetipo_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/cliente/index");
		}

		$data['title'] = "Ver";

		$data['home'] = 'template/ver_general';

		$data['menu'] = $this->session->menu;		

		$data['data'] = $this->ClienteTipo_model->get_clientes_tipo_id( $id );	
		
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

	public function update(){
		
		$data = $this->ClienteTipo_model->update( $_POST );

		if($data){
			$this->session->set_flashdata('info', "Tipo Cliente Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Tipo Cliente No Fue Actualizado");
		}

		redirect(base_url()."admin/clienteTipo/index");
	}

	public function column(){

		$column = array(
			'Nombre','Codigo','Signo','Porcentaje','Descuento','TP Cliente','Correlativo','CTA Ingreso', 'CTA CXC', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_cliente_tipo' =>'nombre_cliente_tipo'],
			['codigo_cliente_tipo' => 'codigo_cliente_tipo'],
			['signo_cliente_tipo' => 'signo_cliente_tipo'],
			['porcentaje_cliente_tipo' => 'porcentaje_cliente_tipo'],
			['descuento_cliente_tipo' => 'descuento_cliente_tipo'],
			['tp_cliente_tipo' => 'tp_cliente_tipo'],
			['correlativo_cliente_tipo' => 'correlativo_cliente_tipo'],
			['cta_ingreso_cliente_tipo' => 'cta_ingreso_cliente_tipo'],
			['cta_cxc_cliente_tipo' => 'cta_cxc_cliente_tipo'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_cliente_tipo');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Cliente Tipo Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
	

}

?>
