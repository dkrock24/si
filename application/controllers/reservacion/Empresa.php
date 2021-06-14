<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();    
		$this->load->database(); 

		$this->load->library('parser');	    
	    $this->load->library('../controllers/general');
		$this->load->helper('url');
        @$this->load->library('session');

		$this->load->model('accion/Accion_model');
		$this->load->model('reservas/Habitacion_model');
        $this->load->model('reservas/Reserva_model');
        $this->load->model('reservas/Zona_model');
        $this->load->model('reservas/Estado_model');
        $this->load->model('reservas/Paquete_model');
        $this->load->model('admin/Cliente_model');
        $this->load->model('reservas/Configuracion_model');
        $this->load->model('admin/Param_model');
        $this->load->model('admin/Pagos_model');        
	}

	public function index($code = 0){
        
        $data = [];
        $empresa_id = 0;
        
        if (isset($_GET['id'])) {
            $this->session->sucursal = $_GET['id'];
            $empresa_id = $this->getSucursal( $_GET['id']);
        } else {
            $empresa_id = $this->getSucursal( $this->session->sucursal );
        }

        if (!empty($code)) {
            $data['unique'] = $code;
            $data['reserva'] = $this->session->reserva;
            $pago = $this->Pagos_model->getPagoId($this->session->reserva['tipo_pago_reserva']);
            $eventos = $this->Reserva_model->get_eventos_reserva($code);
            $paquetes = $this->Reserva_model->get_paquetes_reserva($code);
            $data['reserva']['tipo_pago_reserva'] = $pago[0]->nombre_modo_pago;
            $data['reserva']['eventos'] = $eventos[0]->eventos;
            $data['reserva']['paquete'] = $paquetes[0]->paquetes;
        }        
        
        $data['controller'] = $this; 
        $data['paquetes'] = $this->Paquete_model->get_paquete_lista($empresa_id);
        $data['eventos'] = $this->Zona_model->get_eventos_lista($empresa_id);
        $this->load->view('reservas/pagina/cliente', $data);
	}

    public function get_config_param($configuracion)
    {
        $params = $this->Param_model->get_modulos_conf(0);

        return array_filter(
            $params,
            function($config) use ($configuracion){
                if($config->componente_conf == $configuracion){
                    return array(
                        'estado' => $config->valor_conf,
                        'valor'  => $config->descripcion_conf
                    );
                }
            }, ARRAY_FILTER_USE_BOTH
        );
    }

    public function reservar(){

        $code = 0;
        if(isset($_POST)){
           $code = $this->Reserva_model->get_reservar_from_landing($_POST);
        }
        $this->session->reserva = $_POST;

        redirect(base_url()."reservacion/empresa/index/". $code);
    }

    public function getClietAlreadyCreated($document){

        $data['documento'] = $document;
        $data['sucursal'] = $this->session->sucursal;
        $result = $this->Reserva_model->getClietAlreadyCreated($data);
        echo json_encode($result);
    }

    private function getSucursal($sucursal)
    {
        /**
         * obtener la configuracion de la empresa para mostrar data
         */
        $configuracion = $this->Configuracion_model->get_configuracion_externa($sucursal);
        

        if(isset($configuracion[0]->valor_configuracion)) {
            $empresa_id = $configuracion[0]->valor_configuracion;
        } else {
            echo "No Se Encontro El Establecimiento";die;
        }
        return $empresa_id;
    }
}