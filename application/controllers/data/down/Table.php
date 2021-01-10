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
        $this->load->model('admin/Vistas_model');
        $this->load->model('producto/Producto_model');
        $this->load->model('admin/Pais_model');
        $this->load->model('admin/Turnos_model');
        $this->load->model('admin/Impresor_model');
        $this->load->model('admin/Empresa_model');

        
        
    }

    public function marca()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Marca_model->insert_api($items);
    }
    public function marca_categoria()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Marca_model->insert_relacion_api($items);
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

    public function documento_vista()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Vistas_model->insert_relacion_api($items);
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

    public function impuesto_documento()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impuesto_model->insert_id_api($items);
    }

    public function impuesto_categoria()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impuesto_model->insert_ic_api($items);
    }

    public function impuesto_cliente()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impuesto_model->insert_icli_api($items);
    }

    public function impuesto_proveedor()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impuesto_model->insert_ip_api($items);
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

    public function cliente_pago()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Cliente_model->insert_cp_api($items);
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

    public function usuario_tipo()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Usuario_model->insert_ut_api($items);
    }

    public function vista_componente()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Vistas_model->insert_vc_api($items);
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

    public function producto()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_api($items);
    }

    public function producto_categoria()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_pc_api($items);
    }

    public function producto_combo()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_combo_api($items);
    }

    public function producto_proveedor()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_proveedor_api($items);
    }

    public function atributo()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Atributos_model->insert_api($items);
    }

    public function atributo_opcion()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Atributos_model->insert_ao_api($items);
    }

    public function producto_attributo()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_attributo_api($items);
    }

    public function producto_attributo_valor()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_attributo_valor_api($items);
    }

    public function producto_detalle()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_pd_api($items);
    }

    public function producto_bodega()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Producto_model->insert_pb_api($items);
    }

    public function producto_imagen()
    {
        $this->Producto_model->truncate_product_image();

        $valor = 0;
        $limite = $_GET['limite'];
        $origen = $_GET['cantidad'];
        $cont = 0;
        do {
            
            if ( $cont == 0 ) {
                $origen = 0;
            }
            $url = $_GET['params']."/".$limite."/".$origen;

            $items = $this->callAPI($url);

            if ( $items ) {
                $this->Producto_model->insert_pi_api($items);
                $valor = 1;
            } else {
                $valor = 0;
            }

            if ($cont == 0 ) {
                $origen = 20;
            } else {
                $origen = $origen + $_GET['cantidad'];
            }

            $cont++;
        } while ($valor != 0);

    }

    public function sucursal_template()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Sucursal_model->insert_st_api($items);
    }

    public function sucursal_empleado()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Sucursal_model->insert_em_api($items);
    }

    public function sucursal_bodega()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Sucursal_model->insert_sb_api($items);
    }

    public function pais()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Pais_model->insert_pais_api($items);
    }

    public function departamento()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Pais_model->insert_departamento_api($items);
    }

    public function municipio()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Pais_model->insert_municipio_api($items);
    }

    public function vista()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Vistas_model->insert_api($items);
    }

    public function vista_estado()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Vistas_model->insert_vs_api($items);
    }

    public function vista_acceso()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Vistas_model->insert_va_api($items);
    }

    public function turno()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Turnos_model->insert_turno_api($items);
    }

    public function impresor()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impresor_model->insert_api($items);
    }

    public function impresor_terminal()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Impresor_model->insert_it_api($items);
    }

    public function empresa()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Empresa_model->insert_api($items);
    }

    public function persona()
    {
        $items = $this->callAPI($_GET['params']);
        $this->Persona_model->insert_api($items);
    }

    private function callAPI($param)
    {
        $headers = array('Content-Type: application/json',);
        // the url of the API you are contacting to 'consume' 
        $finalUrl = $this->url.$param;

        // Open connection
        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $finalUrl);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);
        //var_dump($result);

        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        return json_decode($result);
    }
}
