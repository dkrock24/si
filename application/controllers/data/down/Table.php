<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Table extends MY_Controller
{
    protected $url = "";

    protected $parametro = "";

    protected $items = null;

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
        $this->load->model('admin/Vistas_model');
        $this->load->model('admin/Pais_model');
        $this->load->model('admin/Turnos_model');
        $this->load->model('admin/Impresor_model');
        $this->load->model('admin/Empresa_model');
        $this->load->model('admin/Pagos_model');
        $this->load->model('admin/Integrador_model');
        $this->load->model('producto/Orden_model');
        $this->load->model('producto/Producto_model');
        $this->load->model('producto/Linea_model');

        $u = $this->Integrador_model->config_by_name('servidor');
        $this->url = $u[0]->valor_config;

        if (isset($_GET['params'])) {
            $this->parametro = $_GET['params'];
            $this->items = $this->callAPI($this->parametro);
        }

        if (isset($_GET['unico'])) {
            $this->parametro = $_GET['unico'];
            $this->items = $this->callAPI($this->parametro);
        }
    }

    public function marca()
    {
        $this->Marca_model->insert_api($this->items);
    }
    public function marca_categoria()
    {
        $this->Marca_model->insert_relacion_api($this->items);
    }

    public function linea()
    {
        return $this->Linea_model->insert_api($this->items);
    }

    public function correlativo()
    {
        $this->Correlativo_model->insert_api($this->items);
    }

    public function documento()
    {
        $this->Documento_model->insert_api($this->items);
    }

    public function documento_vista()
    {
        $this->Vistas_model->insert_relacion_api($this->items);
    }

    public function documento_template()
    {
        $this->Documento_model->insert_template_api($this->items);
    }

    public function moneda()
    {
        $this->Moneda_model->insert_api($this->items);
    }

    public function sucursal()
    {
        $this->Sucursal_model->insert_api($this->items);
    }

    public function corte_config()
    {
        $this->Sucursal_model->insert_sc_api($this->items);
    }

    public function cargo_laboral()
    {
        $this->Cargos_model->insert_api($this->items);
    }

    public function configuracion()
    {
        $this->Acceso_model->insert_api($this->items);
    }

    public function rol()
    {
        $this->Roles_model->insert_api($this->items);
    }

    public function categoria()
    {
        $this->Categorias_model->insert_api($this->items);
    }

    public function giro()
    {
        $this->Giros_model->insert_api($this->items);
    }

    public function giro_empresa()
    {
        $this->Giros_model->insert_empresa_api($this->items);
    }

    public function giro_plantilla()
    {
        $this->Giros_model->insert_plantilla_api($this->items);
    }

    public function impuesto()
    {
        $this->Impuesto_model->insert_api($this->items);
    }

    public function impuesto_documento()
    {
        $this->Impuesto_model->insert_id_api($this->items);
    }

    public function impuesto_categoria()
    {
        $this->Impuesto_model->insert_ic_api($this->items);
    }

    public function impuesto_cliente()
    {
        $this->Impuesto_model->insert_icli_api($this->items);
    }

    public function impuesto_proveedor()
    {
        $this->Impuesto_model->insert_ip_api($this->items);
    }

    public function caja()
    {
        $this->Caja_model->insert_api($this->items);
    }

    public function cliente_tipo()
    {
        $this->Cliente_model->insert_api($this->items);
    }

    public function cliente()
    {
        $this->Cliente_model->insert_api2($this->items);
    }

    public function pago()
    {
        $this->Pagos_model->insert_api($this->items);
    }

    public function cliente_pago()
    {
        $this->Cliente_model->insert_cp_api($this->items);
    }

    public function empleado()
    {
        $this->Empleado_model->insert_api($this->items);
    }

    public function usuario()
    {
        $this->Usuario_model->insert_api($this->items);
    }

    public function usuario_rol()
    {
        $this->Usuario_model->insert_rol_api($this->items);
    }

    public function usuario_tipo()
    {
        $this->Usuario_model->insert_ut_api($this->items);
    }

    public function componente()
    {
        $this->Vistas_model->insert_c_api($this->items);
    }

    public function vista_componente()
    {
        $this->Vistas_model->insert_vc_api($this->items);
    }

    public function proveedor()
    {
        $this->Proveedor_model->insert_api($this->items);
    }

    public function terminal()
    {
        $this->Terminal_model->insert_api($this->items);
    }

    public function terminal_cajero()
    {
        $this->Terminal_model->insert_cajero_api($this->items);
    }

    public function orden_estado()
    {
        $this->Orden_model->insert_api($this->items);
    }

    public function producto()
    {
        $this->Producto_model->insert_api($this->items);
    }

    public function producto_categoria()
    {
        $this->Producto_model->insert_pc_api($this->items);
    }

    public function producto_combo()
    {
        $this->Producto_model->insert_combo_api($this->items);
    }

    public function producto_proveedor()
    {
        $this->Producto_model->insert_proveedor_api($this->items);
    }

    public function atributo()
    {
        $this->Atributos_model->insert_api($this->items);
    }

    public function atributo_opcion()
    {
        $this->Atributos_model->insert_ao_api($this->items);
    }

    public function producto_attributo()
    {
        $this->Producto_model->insert_attributo_api($this->items);
    }

    public function producto_attributo_valor()
    {
        $this->Producto_model->insert_attributo_valor_api($this->items);
    }

    public function producto_detalle()
    {
        $this->Producto_model->insert_pd_api($this->items);
    }

    public function producto_bodega()
    {
        $this->Producto_model->insert_pb_api($this->items);
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
                $this->Producto_model->insert_pi_api($this->items);
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
        $this->Sucursal_model->insert_st_api($this->items);
    }

    public function sucursal_empleado()
    {
        $this->Sucursal_model->insert_em_api($this->items);
    }

    public function sucursal_bodega()
    {
        $this->Sucursal_model->insert_sb_api($this->items);
    }

    public function pais()
    {
        $this->Pais_model->insert_pais_api($this->items);
    }

    public function departamento()
    {
        $this->Pais_model->insert_departamento_api($this->items);
    }

    public function municipio()
    {
        $this->Pais_model->insert_municipio_api($this->items);
    }

    public function vista()
    {
        $this->Vistas_model->insert_api($this->items);
    }

    public function vista_estado()
    {
        $this->Vistas_model->insert_vs_api($this->items);
    }

    public function vista_acceso()
    {
        $this->Vistas_model->insert_va_api($this->items);
    }

    public function turno()
    {
        $this->Turnos_model->insert_turno_api($this->items);
    }

    public function impresor()
    {
        $this->Impresor_model->insert_api($this->items);
    }

    public function impresor_terminal()
    {
        $this->Impresor_model->insert_it_api($this->items);
    }

    public function empresa()
    {
        $this->Empresa_model->insert_api($this->items);
    }

    public function persona()
    {
        $this->Persona_model->insert_api($this->items);
    }

    public function modulo()
    {
        $this->Empresa_model->insert_modulo_api($this->items);
    }


    public function menu()
    {
        $this->Menu_model->insert_api($this->items);
    }

    public function submenu()
    {
        $this->Menu_model->insert_submenu_api($this->items);
    }

    public function menu_acceso()
    {
        $this->Menu_model->insert_acceso_api($this->items);
    } 

    public function menu_acceso2()
    {
        $this->Menu_model->insert_acceso2_api($this->items);
    }

    public function integrador_data()
    {
        //http://localhost:8081/index.php/data/down/table/integrador_data?unico=integrador
        $this->Integrador_model->insert_api($this->items);
    }

    private function callAPI($param ="")
    {
        $headers = array('Content-Type: application/json',);
        // the url of the API you are contacting to 'consume' 
        $finalUrl = $this->url;
        if ($param!="") {
            $finalUrl = $this->url.$param;
        }

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

    private function api()
    {
        $this->items = $this->callAPI($this->parametro);
    }

    public function integrador($integracion = 0)
	{
        $integraciones = $this->Integrador_model->get_all_integracion();
        
        $integracion_config = $this->Integrador_model->integrador_config();

        $empresa = $integracion_config[0]->valor_config;
        $sucursal = $integracion_config[1]->valor_config;
		
		foreach ($integraciones as $key => $integracion) {
            
            if ($integracion->main_parametro == 0) {
                
                $this->parametro = $integracion->parametro1."/".$empresa;

                if ($integracion->sucursal == 1 ) {
                    $this->parametro = $integracion->parametro1."/".$empresa."/".$sucursal;
                }

            } else {
                $this->parametro = $integracion->parametro1;
            }
            
            $this->api();

            if ($integracion->metodo) {
                $metodo = $integracion->metodo;
                $this->$metodo();
            }
		}
	}
}
