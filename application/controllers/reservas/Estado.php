<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado extends MY_Controller {

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
		$this->load->model('reservas/Estado_model');
	}

	public function index(){

		$model 		= "Estado_model";
		$url_page 	= "reservas/estado/index";
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
		$data['registros'] 		= $this->Estado_model->get_all_estados( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Reserva Estados";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nuevo Estado";
		$data['home'] = 'reservas/estado/c_nuevo';

		echo $this->load->view('reservas/estados/nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Estado_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Estado Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Estado No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."reservas/estado/index");
	}

	public function editar($estado){

		$data['menu'] = $this->session->menu;
		$data['estados'] =  $this->Estado_model->get_estado( $estado );
		$data['home'] = 'reservas/estado/editar';
		$data['title'] = "Editar Estado";

		echo $this->load->view('reservas/estados/editar',$data, TRUE);
	}


	public function update(){

		$data = $this->Estado_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Estado Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Estado No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/estado/index");
	}

	public function eliminar($id){
		
		$data = $this->Estado_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Estado Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Estado No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."reservas/estado/index");
	}

	public function column(){

		$column = array(
			'Nombre','Empresa','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_reserva_estados' => 'Nombre'],
			['nombre_razon_social'=> 'Nombre'],
			['estado' => 'Actual']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva_estados');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Estados Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}