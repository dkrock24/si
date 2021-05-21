<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paquete extends MY_Controller {

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
		$this->load->model('reservas/Paquete_model');
	}

	public function index(){

		$model 		= "Paquete_model";
		$url_page 	= "reservas/paquete/index";
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
		$data['registros'] 		= $this->Paquete_model->get_all_articulos( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Reserva Paquetes";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nuevo Paquete";
		$data['home'] = 'reservas/estado/c_nuevo';

		echo $this->load->view('reservas/paquete/nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Paquete_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Paquete Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Paquete No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."reservas/paquete/index");
	}

	public function editar($paquete){

		$data['menu'] = $this->session->menu;
		$data['paquete'] =  $this->Paquete_model->get_paquete( $paquete );
		$data['home'] = 'reservas/estado/editar';
		$data['title'] = "Editar Estado";	

		echo $this->load->view('reservas/paquete/editar',$data, TRUE);
	}


	public function update(){

		$data = $this->Paquete_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Paquete Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Paquete No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/paquete/index");
	}

	public function eliminar($paquete){
		
		$data = $this->Paquete_model->eliminar( $paquete );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Paquete Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Paquete No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."reservas/paquete/index");
	}

	public function column(){

		$column = array(
			'Nombre','Precio','Habitacion','Estadia','Comida','Descripcion','Limite','Mostrar Solo Imagen','Sucursal','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_paquete' => 'Nombre'],
			['precio_paquete'=> 'Precio'],
			['habitacion'=> 'Habitacion'],
			['estadia_paquete'=> 'Estadia'],
			['comida_paquete'=> 'Comida'],
			['descripcion_paquete'=> 'Descripcion'],
			['limite_personas'=> 'Limite'],
			['solo_imagen'=> 'SoloImagen'],
			['Sucursal'=> 'Sucursal'],
			['nombre_reserva_estados' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva_paquete');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Paquetes Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}