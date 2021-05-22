<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends MY_Controller {

	private $empresa_id;

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
        $this->load->model('reservas/Zona_model');
		$this->load->model('reservas/Paquete_model');
        $this->load->model('reservas/Estado_model');
        $this->load->model('admin/Cliente_model');
        $this->load->model('admin/Pagos_model');
		$this->load->model('reservas/Configuracion_model');
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
        $data['reservas_proceso']   = $this->Reserva_model->get_reservas_activas(2);
        $data['reservas_reservadas']   = $this->Reserva_model->get_reservas_activas(1);
        $data['habitacion_reservadas']   = $this->Reserva_model->get_habitacion_reserva(array(2)); // En Proceso
        
        $data['habitacion']   = $this->Reserva_model->get_habitacion(array(7)); // Toda las ctivas
        $data['habitacion_limpieza']   = $this->Reserva_model->get_habitacion(array(8)); //5 limpieza

		$dates = [
			'inicio' => date('Y-m-d'),
			'fin' => date('Y-m-d')
		];
		$capacidad = $this->Reserva_model->get_capacidad($dates);
		$data['utilizado'] = $capacidad[0]->capacidad ? $capacidad[0]->capacidad :  0;

		$data['capacidad'] = $this->get_configuracion_capacidad('limite_personas');

		/**
         * obtener la configuracion de la empresa para mostrar data
         */
		$this->get_paquetes();
        

		$data['paquetes'] = $this->Paquete_model->get_paquete_lista($this->empresa_id);

        $data['mesa'] = $this->Mesa_model->get_mesa_sucursal();

        $data['zona'] = $this->Zona_model->get_zona_sucursal();

        $data['estados'] = $this->Estado_model->get_estado_lista();

		$data['menu'] = $this->session->menu;
		$data['title'] = "Nueva Reserva";
		$data['home'] = 'reservas/mesa/uevo';

		echo $this->load->view('reservas/reserva/nuevo',$data, TRUE);
	}

	private function get_paquetes()
	{
		$configuracion = $this->Configuracion_model->get_configuracion('empresa');
        $this->empresa_id = $configuracion[0]->valor_configuracion;
	}

    public function get_reservacion_habiatacion(){
        $data = $this->Reserva_model->get_reservacion_habiatacion($_POST);
        echo json_encode($data);
    }

    public function reservaciones(){
        $data = array();
        $reservas = $this->Reserva_model->get_reservaciones_calendar_data();
        if($reservas) {
            foreach($reservas as $row)
            {
                $data[] = array(
                'title'   => $row->title,
                'start'   => $row->start,
                'end'   => $row->end,
                'backgroundColor' => $row->color,
                'textColor' => 'black'
                );
            }
        }
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
		redirect(base_url()."reservas/reserva/index");
	}

	public function editar($reserva){

		$data['cliente']    			= $this->Cliente_model->getCliente();
        $data['pago']       			= $this->Pagos_model->getTipoPago();
        $data['reservas_proceso']   	= $this->Reserva_model->get_reservas_activas(2);
        $data['reservas_reservadas']   	= $this->Reserva_model->get_reservas_activas(1);
        $data['habitacion_reservadas']  = $this->Reserva_model->get_habitacion_reserva(array(2)); // En Proceso
        
        $data['habitacion']   			= $this->Reserva_model->get_habitacion(array(7)); // Toda las ctivas
        $data['habitacion_limpieza']   	= $this->Reserva_model->get_habitacion(array(8)); //5 limpieza

		$data['habitacion_']   			= $this->Reserva_model->get_habitacion_($reserva);
		$data['mesa_']   				= $this->Reserva_model->get_mesa_($reserva);
		$data['zona_']   				= $this->Reserva_model->get_zona_($reserva);
		$data['paquete_'] 				= $this->Reserva_model->get_paquete_($reserva);

		$data['reserva'] =  $this->Reserva_model->get_reserva( $reserva );

		$dates = [
			'inicio' => $data['reserva'][0]->fecha_entrada_reserva,
			'fin' => $data['reserva'][0]->fecha_salida_reserva
		];
		$capacidad = $this->Reserva_model->get_capacidad($dates);
		$data['utilizado'] = $capacidad[0]->capacidad ? $capacidad[0]->capacidad :  0;

		$data['capacidad'] = $this->get_configuracion_capacidad('limite_personas');

		/**
         * obtener la configuracion de la empresa para mostrar data
         */
		$this->get_paquetes();

		$data['paquetes'] = $this->Paquete_model->get_paquete_lista($this->empresa_id);

        $data['mesa'] = $this->Mesa_model->get_mesa_sucursal();

        $data['zona'] = $this->Zona_model->get_zona_sucursal();

        $data['estados'] = $this->Estado_model->get_estado_lista();

		$data['menu'] = $this->session->menu;
		$data['home'] = 'reservas/reserva/editar';
		$data['title'] = "Editar Reserva";

		echo $this->load->view('reservas/reserva/editar',$data, TRUE);
	}

	/**
	 * Obtener la capacidad de persona global que permite el establecimiento
	 *
	 * @param String $limite
	 * @return void
	 */
	private function get_configuracion_capacidad($limite)
	{
		$param =  $this->Configuracion_model->get_configuracion($limite);
		return $param[0]->valor_configuracion;
	}

	/**
	 * Obtener la capacidad de persona global que permite el establecimiento
	 *
	 * @param Array $fecha
	 * @return void
	 */
	public function get_capacidad_fecha()
	{
		$fechaInicio = $_POST['inicio'];
        $fechaInicio = explode("T", $fechaInicio);

        $fechaFin = $_POST['fin'];
        $fechaFin = explode("T", $fechaFin);

		$dates = array(
			'inicio' => $fechaInicio[0],
			'fin' => $fechaFin[0]
		);

		$param =  $this->Reserva_model->get_capacidad($dates);
		echo json_encode($param[0]);
	}

	public function update(){

		$data = $this->Reserva_model->update( $_POST );

		if(!$data['code']){
			$this->session->set_flashdata('info', "Reserva Fue Actualizada");
		}else{
			$data = $this->db_error_format($data);
			$this->session->set_flashdata('danger', "Reserva No Fue Actualizada : ". $data['message']);
		}	
		redirect(base_url()."reservas/reserva/editar/". $_POST['id_reserva']);
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
			'Codigo','Cliente','Reserva','Entrada','Salida','Creado','Adultos','MENORES','Total','Eventos','T.Pago','Estado'
		);
		return $column;
	}

	public function fields(){
		$fields['field'] = array(
            ['codigo_reserva'=> 'Codigo'],
			['nombre_empresa_o_compania' => 'Cliente'],
			['nombre_reserva' => 'Reserva'],
			['fecha_entrada_reserva'=> 'Creado'],
            ['fecha_salida_reserva'=> 'Creado'],
            ['fecha_creada_reserva'=> 'Creado'],
            ['total_adultos_reserva'=> 'Adultos'],
            ['total_ninos_reserva'=> 'Menores'],
			['total_personas_reserva'=> 'Total Personas'],
			['eventos'=> 'Eventos'],
            ['nombre_modo_pago'=> 'Tipo Pago'],
            //['referencia_pago_reserva'=> 'Codigo'],
            //['anticipo_pago_reserva'=> 'Codigo'],
			['nombre_reserva_estados' => 'Estado']
		);

		$fields['reglas'] = array(
			'orden_estado_nombre' => array(
				'valor' => 1,
				'condicion' => 1
			),
		);
		
		$fields['id'] = array('id_reserva');
		$fields['estado'] = array('estado');
		$fields['titulo'] = "Reservaciones Lista";

		return $fields;
	}

	function export(){

		$column = $this->column();
		$fields = $this->fields();

		$this->xls( $_SESSION['registros'] ,$_SESSION['Vista'] ,$column, $fields  );

	}
}