<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Table extends CI_Controller
{
    protected $url = "";
    protected $urlBase = "";

    protected $parametro = "";

    protected $items = array();


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

        /*$this->load->model('accion/Accion_model');
        $this->load->model('admin/Atributos_model');
        $this->load->model('admin/Cargos_model');
        $this->load->model('admin/Correlativo_model');
        $this->load->model('admin/Categorias_model');
        $this->load->model('admin/Empleado_model');
        $this->load->model('admin/Marca_model');
        $this->load->model('admin/Menu_model');
        $this->load->model('admin/Persona_model');
        $this->load->model('admin/Roles_model');
        $this->load->model('admin/Usuario_model');
        $this->load->model('producto/Linea_model');
        $this->load->model('admin/Documento_model');
        $this->load->model('admin/Moneda_model');
        $this->load->model('admin/Sucursal_model');
        $this->load->model('admin/Cargos_model');
        $this->load->model('admin/Acceso_model');
        $this->load->model('admin/Roles_model');
        $this->load->model('admin/Categorias_model');
        $this->load->model('admin/Giros_model');
        $this->load->model('admin/Impuesto_model');
        $this->load->model('admin/Caja_model');
        $this->load->model('admin/Cliente_model');
        $this->load->model('admin/Empleado_model');
        $this->load->model('admin/Proveedor_model');
        $this->load->model('admin/Terminal_model');
        $this->load->model('producto/Orden_model');
        $this->load->model('admin/Vistas_model');
        $this->load->model('producto/Producto_model');
        $this->load->model('admin/Pais_model');
        $this->load->model('admin/Turnos_model');
        $this->load->model('admin/Impresor_model');
        $this->load->model('admin/Empresa_model');
        $this->load->model('admin/Pagos_model');*/

        $this->load->model('admin/Integrador_model');
        $this->load->model('producto/Venta_model');

        $this->get_config_url();
    }

    public function orden_sync()
    {
        /** Ordenes Activas para ser procesadas */
        $ordenes = $this->Orden_model->ordenesIntegracion();

        $this->items = json_encode($ordenes);
        $this->setUrl('orden');
        $ordenesIntegradas = $this->callAPI();

        if ($ordenesIntegradas) {
            /** Registrar en local cada orden que se proceso a produccion */
            $ordenIds = $this->Orden_model->ordenesRegistro($ordenesIntegradas);
            if($ordenIds){
                /** obtener ordenes detalle de las que se procesaron */
                $ordenDetalle = $this->Orden_model->get_ordenes_in($ordenIds);

                /** Integrar Orden Detalle a Produccion */
                $this->items = json_encode($ordenDetalle);
                $this->setUrl('orden/detalle');
                $this->callAPI();

                /** Integrar Orden Impuesto a Produccion */
                $ordenImpuesto = $this->Orden_model->get_ordenes_impuestos($ordenIds);
                $this->items = json_encode($ordenImpuesto);
                $this->setUrl('orden/impuesto');
                $this->callAPI();
            }
        }
        
    }

    public function venta_sync()
    {
        /** Ventas Activas para ser procesadas */
        $ventas = $this->Venta_model->ventasIntegracion();

        $this->items = json_encode($ventas);
        $this->setUrl('venta');
        $ventasIntegradas = $this->callAPI();

        if ($ventasIntegradas) {
            /** Registrar en local cada venta que se proceso a produccion */
            $ventasIds = $this->Venta_model->ventasRegistro($ventasIntegradas);
            if($ventasIds){

                /** obtener ordenes detalle de las que se procesaron */
                $ventaDetalle = $this->Venta_model->get_ventas_in($ventasIds);

                /** Integrar Venta Detalle a Produccion */
                $this->items = json_encode($ventaDetalle);
                $this->setUrl('venta/detalle');
                $this->callAPI();

                /** Integrar Venta Impuesto a Produccion */
                $ventasImpuesto = $this->Venta_model->get_ventas_impuestos($ventasIds);
                $this->items = json_encode($ventasImpuesto);
                $this->setUrl('venta/impuesto');
                $this->callAPI();

                /** Integrar Venta pagos a produccion */
                $ventasPagos = $this->Venta_model->get_ventas_pagos($ventasIds);
                $this->items = json_encode($ventasPagos);
                $this->setUrl('venta/pagos');
                $this->callAPI();
            }
        }
    }

    private function setUrl($endPoint)
    {
        $this->urlBase = $this->url.$endPoint;
    }

    private function callAPI()
    {
       $curl = curl_init($this->urlBase);
  
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
       curl_setopt($curl, CURLOPT_POST, $this->items);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $this->items);
           
       curl_setopt($curl, CURLOPT_HEADER, false); 
           
       $result = curl_exec($curl);

       curl_close($curl);

       return json_decode($result);
    }

    private function get_config_url()
    {
        /** Config */
        $integrador_config = $this->Integrador_model->integrador_config();

        $config = array_filter($integrador_config, function($k) use ($integrador_config){
            if( $k->nombre_config == 'servidor') {
                return $k;
            }
        }, ARRAY_FILTER_USE_BOTH);

        $config_array = (array) $config;
        $config = array_column($config_array, 'valor_config')[0];

        $this->url = $config;
    }
}