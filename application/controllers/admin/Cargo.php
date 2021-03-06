<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cargo extends MY_Controller {

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

		$this->load->model('admin/Cargos_model');  
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('admin/Usuario_model');
		$this->load->model('accion/Accion_model');
		$this->load->model('admin/Roles_model');
		$this->load->model('admin/Persona_model');
		$this->load->model('admin/Empleado_model');
	}

// Start  **********************************************************************************

	public function index(){

		$model 		= "Cargos_model";
		$url_page 	= "admin/cargo/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 30);
		
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
		$data['registros'] 		= $this->Cargos_model->get_all_cargo( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters']);
		$data['title'] 			= "Cargos Laborales";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['registros']  = $data['registros'];
		$_SESSION['Vista']  	= $data['title'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nuevo Cargo Laboral";
		$data['home'] = 'admin/cargo/c_nuevo';

		echo $this->load->view('admin/cargo/c_nuevo',$data, TRUE);
	}

	public function crear(){
		$data = $this->Cargos_model->crear_cargo( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Cargo Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Cargo No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."admin/cargo/index");
	}

	public function editar( $cargo_id ){
		
		$data['menu'] = $this->session->menu;	
		
		$data['cargo'] = $this->Cargos_model->get_cargo_id( $cargo_id );
		$data['title'] = "Editar Cargo Laboral";
		$data['home'] = 'admin/cargo/c_editar';

		$this->general->editar_valido($data['cargo'], "admin/cargo/index");

		echo $this->load->view('admin/cargo/c_editar',$data, TRUE);
	}

	public function ver( $id = 0){

		if( $id ==0 ){
			redirect(base_url()."admin/cargo/index");
		}

		$data['title'] = "Ver";
		$data['home'] = 'template/ver_general';
		$data['menu'] = $this->session->menu;		
		$data['data'] = $this->Cargos_model->get_cargo_id( $id );	

		if ($data['data']) {

			foreach ($data['data']  as $key => $value) {			
				$vars = get_object_vars ( $value );				
				continue;
			}
	
			$data['columns'] = $vars;
	
			$this->parser->parse('template', $data);

		}else{
			redirect(base_url()."admin/cargo/index");
		}
	}

	public function update(){
		if (isset($_POST)) {
			$data = $this->Cargos_model->update( $_POST );
			
			if (!$data['code']) {
				$this->session->set_flashdata('info', "Cargo Fue Actualizado");
			} else {
				$data = $this->db_error_format($data);
				$this->session->set_flashdata('danger', "Cargo No Fue Actualizado : ". $data['message']);
			}
		}
		redirect(base_url()."admin/cargo/index");
	}

	public function eliminar($id){
		
		$data = $this->Cargos_model->eliminar( $id );

		if (!$data['code']) {
			$this->session->set_flashdata('warning', "Cargo Fue Eliminado");
		} else {
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Cargo Fue Eliminado : ". $data['message']);
		}

		redirect(base_url()."admin/cargo/index");
	}

	public function column(){

		$column = array(
			'Cargo','Descripcion','Salario','Estado'
		);
		return $column;
	}

	public function fields(){
		
		$fields['field'] = array(
			['cargo_laboral' => 'Cargo'],
			['descripcion_cargo_laboral' => 'Descripcion'],
			['salario_mensual_cargo_laboral' => 'Salario'],
			['orden_estado_nombre' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);

		$fields['id'] 	  = array('id_cargo_laboral');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Cargos Laborales Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] , $_SESSION['Vista']  ,$column, $fields  );

	}
}

?>
