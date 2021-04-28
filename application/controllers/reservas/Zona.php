<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zona extends MY_Controller {

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
		$this->load->model('reservas/Zona_model');
	}

	public function index(){

		$model 		= "Zona_model";
		$url_page 	= "reservas/zona/index";
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
		$data['registros'] 		= $this->Zona_model->get_all_articulos( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Zona";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nueva Zona";
		$data['home'] = 'reservas/estado/c_nuevo';

		echo $this->load->view('reservas/zonas/nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Zona_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Zona Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Zona No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."reservas/zona/index");
	}

	public function editar($zona){

		$data['menu'] = $this->session->menu;
		$data['zona'] =  $this->Zona_model->get_articulo( $zona );
		$data['home'] = 'reservas/estado/editar';
		$data['title'] = "Editar Zona";

		echo $this->load->view('reservas/zonas/editar',$data, TRUE);
	}

	public function update(){

		$data = $this->Zona_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Zona Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Zona No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/zona/index");
	}

	public function eliminar($id){
		
		$data = $this->Zona_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Zona Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Zona No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."reservas/zona/index");
	}

	public function column(){

		$column = array(
			'Nombre','Descripcion','Ubicacion','Capacidad','Precio','Codigo','Sucursal','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_zona' => 'Nombre'],
			['descripcion_zona'=> 'Descripcion'],
			['ubicacion_zona'=> 'ubicacion'],
			['capacidad_zona'=> 'Capacidad'],
			['precio_zona'=> 'Precio'],
			['codigo_zona'=> 'Codigo'],
			['Sucursal'=> 'Sucursal'],
			['estado_zona' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva_zona');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Zona Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}