<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends MY_Controller {

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
        $this->load->model('reservas/Reserva_model');
        $this->load->model('admin/Cliente_model');
        $this->load->model('admin/Pagos_model');
	}

	public function index(){

		$model 		= "Reserva_model";
		$url_page 	= "reservas/reserva/index";
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
		$data['registros'] 		= $this->Reserva_model->get_all_reservas( $pag['config']["per_page"], $pag['page']  ,$_SESSION['filters'] );
		$data['title'] 			= "Reserva";
		$data['home'] 			= 'template/lista_template';
		$_SESSION['Vista']  	= $data['title'];
		$_SESSION['registros']  = $data['registros'];

		echo $this->load->view('template/lista_template',$data, TRUE);
	}

	public function nuevo(){

        $data['cliente']    = $this->Cliente_model->getCliente();
        $data['pago']       = $this->Pagos_model->getTipoPago();
        $data['reservas_proceso']   = $this->Reserva_model->get_reservas_activas(1);
        $data['reservas_reservadas']   = $this->Reserva_model->get_reservas_activas(2);
        $data['habitacion_reservadas']   = $this->Reserva_model->get_habitacion_reserva(array(1,2));
        
        $data['habitacion']   = $this->Reserva_model->get_habitacion(array(1));
        $data['habitacion_limpieza']   = $this->Reserva_model->get_habitacion(array(8)); //8 limpieza
        $data['habitacion_mantenimiento']   = $this->Reserva_model->get_habitacion(array(9)); //9 mantenimiento

		$data['menu'] = $this->session->menu;
		$data['title'] = "Nueva Reserva";
		$data['home'] = 'reservas/mesa/uevo';

		echo $this->load->view('reservas/reserva/nuevo',$data, TRUE);
	}

    public function get_reservacion_habiatacion(){
        $data = $this->Reserva_model->get_reservacion_habiatacion($_POST);
        echo json_encode($data);
    }

    public function reservaciones(){
        $data = array();
        $reservas = $this->Reserva_model->get_reservaciones_calendar_data();
        foreach($reservas as $row)
        {
            $data[] = array(
            'title'   => $row->title,
            'start'   => $row->start,
            'end'   => $row->end
            );
        }
        //$abc = '[{"title":"Rafael Tejada","start":"2021-04-28 14:12:39","end":"2021-04-29 14:12:40"},{"title":"Esteban Alvarenga","start":"2021-04-28 14:12:39","end":"2021-04-28 14:12:40"}]';
        echo json_encode($data);
    }

	public function crear(){

		$data = $this->Reserva_model->crear( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('success', "Reserva Fue Creado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Reserva No Fue Creado : ". $data['message']);
		}	
		redirect(base_url()."reservas/mesa/index");
	}

	public function editar($reserva){

		$data['menu'] = $this->session->menu;
		$data['mesa'] =  $this->Reserva_model->get_reserva( $reserva );
		$data['home'] = 'reservas/reserva/editar';
		$data['title'] = "Editar Reserva";

		echo $this->load->view('reservas/reserva/editar',$data, TRUE);
	}

	public function update(){

		$data = $this->Reserva_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Reserva Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Reserva No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/reserva/index");
	}

	public function eliminar($id){
		
		$data = $this->Reserva_model->eliminar( $id );

		if(!$data['code']){
			$this->session->set_flashdata('warning', "Reserva Fue Eliminado");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Reserva No Fue Eliminada : ". $data['message']);
		}

		redirect(base_url()."reservas/reserva/index");
	}

	public function column(){

		$column = array(
			'Codigo','Cliente','Entrada','Salida','Final','Creado','Adultos','Niños','T.Pago','Referencia','Anticipo','Sucursal','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
            ['codigo_reserva'=> 'Codigo'],
			['cliente_reserva' => 'Cliente'],
			['fecha_entrada_reserva'=> 'Descripcion'],
            ['fecha_salida_reserva'=> 'Capacidad'],
			['fecha_real_salida_reserva'=> 'Codigo'],
            ['fecha_creada_reserva'=> 'Codigo'],
            ['total_adultos_reserva'=> 'Codigo'],
            ['total_niños_reserva'=> 'Codigo'],
            ['tipo_pago_reserva'=> 'Codigo'],
            ['referencia_pago_reserva'=> 'Codigo'],
            ['anticipo_pago_reserva'=> 'Codigo'],
			['Sucursal'=> 'Sucursal'],
			['estado_reserva' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Reserva Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}