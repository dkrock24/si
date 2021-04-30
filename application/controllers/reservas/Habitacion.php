<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Habitacion extends MY_Controller {

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
		$this->load->model('reservas/Habitacion_model');
		$this->load->model('reservas/Articulo_model');
	}

	public function index(){

		$model 		= "Habitacion_model";
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
		$data['registros'] 		= $this->Habitacion_model->get_all_articulos( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Habitacion";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

		$data['menu'] = $this->session->menu;	
		$data['title'] = "Nueva Habitacion";
		$data['home'] = 'reservas/estado/c_nuevo';

		$data['articulos'] = $this->Articulo_model->get_articulos();

		echo $this->load->view('reservas/habitacion/nuevo',$data, TRUE);
	}

	public function crear(){

		$data = $this->Habitacion_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Habitacion Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Habitacion No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."reservas/habitacion/index");
	}

	public function editar($habitacion){

		$data['menu'] = $this->session->menu;
		$data['habitacion'] =  $this->Habitacion_model->get_habitacion( $habitacion );
		$data['home'] = 'reservas/estado/editar';
		$data['title'] = "Editar Habitacion";

		$data['articulos'] = $this->Articulo_model->get_articulos();
		$data['habitacion_articulos'] = $this->Habitacion_model->get_habitacion_articulos($habitacion);

		echo $this->load->view('reservas/habitacion/editar',$data, TRUE);
	}

	public function update(){

		$data = $this->Habitacion_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Habitacion Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Habitacion No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/habitacion/index");
	}

	public function eliminar($id){
		
		$data = $this->Habitacion_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Habitacion Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Habitacion No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."reservas/habitacion/index");
	}

	public function column(){

		$column = array(
			'Nombre','Descripcion','Precio Base','Precio Estimado','Precio Tiempo','Tamaño','Capacidad','Codigo','Sucursal','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
			['nombre_habitacion' => 'Nombre'],
			['descripcion_habitacion'=> 'Descripcion'],
			['precio_base_habitacion'=> 'Precio Base'],
			['precio_estimado_habitacion'=> 'Precio Estimado'],
            ['precio_tiempo_habitacion'=> 'Precio Tiempo'],
            ['tamano_habitacion'=> 'Tamaño'],
            ['capacidad_habitacion'=> 'Capacidad'],
			['codigo_habitacion'=> 'Codigo'],
			['Sucursal'=> 'Sucursal'],
			['nombre_reserva_estados' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva_habitacion');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "habitacion Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}