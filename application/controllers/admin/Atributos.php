<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atributos extends MY_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    @$this->load->library('session');	  
	    $this->load->library('pagination');
	    $this->load->helper('url');

		$this->load->helper('paginacion/paginacion_helper');
		$this->load->model('admin/Atributos_model');  
		$this->load->model('admin/Menu_model');
		$this->load->model('accion/Accion_model');
	}

// Start PAIS **********************************************************************************

	public function index(){

		$model 		= "Atributos_model";
		$url_page 	= "admin/atributos/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 10);
		
		$data['acciones'] 		= $this->Accion_model->get_vistas_acciones( $pag['vista_id'] , $pag['id_rol'] );
		$data['registros'] 		= $this->Atributos_model->get_atributos(  $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['menu'] 			= $this->session->menu;
		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['title'] 			= "Atributos";
		$data['home'] 			= 'template/lista_template';

		$data = $this->load->view('template/lista_template',$data, TRUE);
		echo $data;
	}

	public function nuevo(){
		// GET PAIS
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nuevo Atributo";	
		$data['home'] = 'admin/atributos/atributos_nuevo';

		$this->parser->parse('template', $data);
	}

	public function crear(){
		// Insert pais
		$this->Atributos_model->crear_atributo( $_POST );

		redirect(base_url()."admin/atributos/index");
	}

	public function editar( $id_prod_atributo ){
		$id_rol = $this->session->userdata['usuario'][0]->id_rol;

		$data['menu'] = $this->session->menu;		
		$data['atributo'] = $this->Atributos_model->get_atributo_id( $id_prod_atributo );
		$data['title'] = "Editar Atributo";	
		$data['home'] = 'admin/atributos/atributos_editar';

		$this->parser->parse('template', $data);
	}

	public function eliminar($id){
		$data['atributo'] = $this->Atributos_model->eliminar( $id );

		if($data){
			$this->session->set_flashdata('warning', "Atributo Fue Eliminado");
		}else{
			$this->session->set_flashdata('danger', "Atributo No Fue Eliminado");
		}	
		redirect(base_url()."admin/atributos/index");
	}

	public function actualizar(){
		// Insert pais
		$data['atributos'] = $this->Atributos_model->actualizar_atributo( $_POST );

		if($data){
			$this->session->set_flashdata('success', "Atributo Fue Actualizado");
		}else{
			$this->session->set_flashdata('danger', "Atributo No Fue Actualizado");
		}

		redirect(base_url()."admin/atributos/index");
	}

	public function column(){

		$column = array(
			'Nombre','Tipo','Creado','Actualizado','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nam_atributo' => 'Nombre'],
			['tipo_atributo' => 'Tipo'],
			['creado_atributo' => 'Creado'],
			['actualizado_atributo' => 'Actualizado'],
			['orden_estado_nombre'=> 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_prod_atributo');
		$fields['estado'] = array('orden_estado_nombre');
		$fields['titulo'] = "Atributos Lista";

		return $fields;
	}

}

?>
