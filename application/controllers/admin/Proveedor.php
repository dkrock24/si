<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends MY_Controller {


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

		$this->load->model('accion/Accion_model');	
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Proveedor_model');
		$this->load->model('producto/Linea_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model = "Proveedor_model";
		$url_page = "admin/proveedor/index";
		$pag = $this->MyPagination($model, $url_page , $vista = 32);

		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Proveedor_model->get_proveedor( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']  );
		$data['title'] 			= "Proveedores";
		$data['home'] 			= 'template/lista_template';

		//$this->parser->parse('template', $data);

		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] 		= $this->session->menu;		
		$data['linea'] 		= $this->Linea_model->getAllLinea();
		$data['persona'] 	= $this->Persona_model->getAllPersona($is_proveedor=1);
		$data['title'] 		= "Nuevo Proveedor";
		$data['home'] 		= 'admin/proveedor/proveedor_nuevo';

		echo $this->load->view('admin/proveedor/proveedor_nuevo',$data, TRUE);
	}

	public function crear(){
		
		$data = $this->Proveedor_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Proveedor Fue Creado");
		}else{
			$this->session->set_flashdata('warning', "Proveedor No Fue Creado : ". $data['message']);
		}

		redirect(base_url()."admin/proveedor/index");
	}

	public function editar( $proveedor_id ){
		
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] 		= $this->session->menu;		
		$data['proveedor'] 	= $this->Proveedor_model->get_proveedor_id( $proveedor_id );
		$data['linea'] 		= $this->Linea_model->getAllLinea();
		$data['persona'] 	= $this->Persona_model->getAllPersona($is_proveedor=1);
		$data['title'] 		= "Editar Proveedor";
		$data['home'] 		= 'admin/proveedor/proveedor_editar';

		$this->general->editar_valido($data['proveedor'], "admin/proveedor/index");

		echo $this->load->view('admin/proveedor/proveedor_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/proveedor/index");
		}

		$data['title']= "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;
		$data['data'] = $this->Proveedor_model->get_proveedor_id( $id );	
		
		if($data['data']){

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			echo $this->load->view('template/ver_general',$data, TRUE);

		}else{
			redirect(base_url()."admin/proveedor/index");
		}
	}

	public function update(){
		
		$data = $this->Proveedor_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Proveedor Fue Actualizado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Proveedor No Fue Actualizado : ". $data['message']);
		}

		redirect(base_url()."admin/proveedor/index");
	}

	public function eliminar($proveedor){

		$data = $this->Proveedor_model->eliminar( $proveedor );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Proveedor Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Proveedor No Fue Eliminado : ". $data['message']);
		}

		redirect(base_url()."admin/proveedor/index");
	}

	public function column(){

		$column = array(
			'Codigo','Empresa','Titular','NRC','Giro','Tel','Cel', 'Linea','Nombre','Apellido', 'Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['codigo_proveedor' => 'Codigo'],
			['empresa_proveedor' => 'Empresa'],
			['titular_proveedor' => 'Titular'],
			['nrc' => 'NRC'],
			['giro' => 'Giro'],
			['tel_empresa' => 'Tel'],
			['cel_empresa' => 'Cel'],
			['tipo_producto' => 'Linea'],
			['primer_nombre_persona' => 'Nombre'],
			['primer_apellido_persona' => 'Apellido'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] 		= array('id_proveedor');
		$fields['estado'] 	= array('orden_estado_nombre');
		$fields['titulo'] 	= "Proveedor Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}
?>
