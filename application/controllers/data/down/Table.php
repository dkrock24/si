<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table extends MY_Controller
{
    protected $url = "http://192.168.0.6:8081/index.php/api/";


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
        
    }

    public function marca()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Marca_model->insert_api($items);
    }

    public function linea()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Linea_model->insert_api($items);
    }

    public function correlativo()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Correlativo_model->insert_api($items);
    }

    public function documento()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Documento_model->insert_api($items);
    }

    public function moneda()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Moneda_model->insert_api($items);
    }

    public function sucursal()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Sucursal_model->insert_api($items);
    }

    public function cargo_laboral()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Cargos_model->insert_api($items);
    }

    public function configuracion()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Acceso_model->insert_api($items);
    }

    public function rol()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Roles_model->insert_api($items);
    }

    public function categoria()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Categorias_model->insert_api($items);
    }

    public function giro()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Giros_model->insert_api($items);
    }

    public function impuesto()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impuesto_model->insert_api($items);
    }

    public function caja()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Caja_model->insert_api($items);
    }

    public function cliente_tipo()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Cliente_model->insert_api($items);
    }

    public function cliente()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Cliente_model->insert_api2($items);
    }

    public function empleado()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Empleado_model->insert_api($items);
    }

    public function usuario()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Usuario_model->insert_api($items);
    }

    public function proveedor()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Proveedor_model->insert_api($items);
    }

    public function terminal()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Terminal_model->insert_api($items);
    }

    public function orden_estado()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Orden_model->insert_api($items);
    }

    private function callAPI($param)
    {
        $headers = array('Content-Type: application/json',);
        // the url of the API you are contacting to 'consume' 
        $this->url .= $param;

        // Open connection
        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        return json_decode($result);
    }
}
