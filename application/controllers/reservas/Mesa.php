<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesa extends MY_Controller {

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
		$this->load->model('reservas/Mesa_model');
	}

	public function index(){

		$model 		= "Mesa_model";
		$url_page 	= "reservas/mesa/index";
		$pag 		= $this->MyPagination($model, $url_page , $vista = 35);

		$data['links'] 			= $pag['links'];
		$data['filtros'] 		= $pag['field'];
		$data['contador_tabla'] = $pag['contador_tabla'];
		$data['column'] 		= $this->column();
		$data['fields'] 		= $this->fields();
		$data['total_pagina'] 	= $pag['config']["per_page"];
		$data['x_total']		= $pag['config']['x_total'];
		$data['total_records'] 	= $pag['total_records'];
		$data['acciones']		= $this->Accion_model->get_vistas_acciones(  $pag['vista_id'] , $pag['id_rol']);
		$data['registros'] 		= $this->Mesa_model->get_all_articulos( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Mesa";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nueva Mesa";
		$data['home'] = 'reservas/mesa/uevo';

		echo $this->load->view('reservas/mesa/nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Mesa_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Mesa Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Mesa No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."reservas/mesa/index");
	}

	public function editar($mesa){

		$data['menu'] = $this->session->menu;
		$data['mesa'] =  $this->Mesa_model->get_mesa( $mesa );
		$data['home'] = 'reservas/estado/editar';
		$data['title'] = "Editar Mesa";

		echo $this->load->view('reservas/mesa/editar',$data, TRUE);
	}

	public function update(){

		$data = $this->Mesa_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Mesa Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Mesa No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/mesa/index");
	}

	public function eliminar($id){
		
		$data = $this->Mesa_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Mesa Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Mesa No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."reservas/mesa/index");
	}

	public function column(){

		$column = array(
			'Nombre','Descripcion','Capacidad','Codigo','Sucursal','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_mesa' => 'Nombre'],
			['descripcion_mesa'=> 'Descripcion'],
            ['capacidad_mesa'=> 'Capacidad'],
			['codigo_mesa'=> 'Codigo'],
			['Sucursal'=> 'Sucursal'],
			['estado_mesa' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva_mesa');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Mesas Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}