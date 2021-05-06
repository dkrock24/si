<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends MY_Controller {

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
        $this->load->model('reservas/Reserva_model');
        $this->load->model('reservas/Zona_model');
        $this->load->model('reservas/Estado_model');
        $this->load->model('reservas/Paquete_model');
        $this->load->model('admin/Cliente_model');
	}

	public function index($code = 0){
        $data = [];
        if (!empty($code)) {
            $data['unique'] = $code;
        }
        $data['paquetes'] = $this->Paquete_model->get_paquete_lista();
        $this->load->view('reservas/pagina/cliente', $data);
	}

    public function reservar(){

        $code = 0;
        if(isset($_POST)){
           $code = $this->Reserva_model->get_reservar_from_landing($_POST);
        }

        redirect(base_url()."reservacion/Empresa/index/". $code);
    }
}