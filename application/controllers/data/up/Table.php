<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Table extends CI_Controller
{
    protected $url = "http://192.168.1.11:8081/index.php/api/";
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
        $this->load->model('producto/Orden_model');
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
}