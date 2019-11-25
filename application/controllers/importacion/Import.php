<?php
defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
class Import extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->library('parser');
        @$this->load->library('session');
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->helper('seguridad/url_helper');
        $this->load->model('accion/Accion_model');
        $this->load->helper(array('url', 'html', 'form'));
        $this->load->model('admin/Menu_model');
        $this->load->model('admin/Atributos_model');
        $this->load->model('admin/Marca_model');
        $this->load->model('admin/Giros_model');
        $this->load->model('importacion/Import_model');
    }

    public function index()
    {
        $data['menu'] = $this->session->menu;

        $data['list_tablas'] = $this->Import_model->getTablesDb();

        $data['home'] = 'importacion/importacion';
        $data['title'] = 'Importacion';

        $this->parser->parse('template', $data);
    }

    public function importFile()
    {
        $path = 'uploads/';

        require_once APPPATH . "/libraries/PHPExcel.php";

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('uploadFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
        }

        if (empty($error)) {

            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }

            $inputFileName = $path . $import_xls_file;
            
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                
                $table = $_POST['tables'];

                $tipo_insert = @$_POST['tipo_insert'];

                $relaciones = @$_POST['relaciones'];
                
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);

                $objPHPExcel = $objReader->load($inputFileName);

                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                
                $flag = true;
                $i = 0;

                $encabezado = [];

                $this->Import_model->setForeignkey($relaciones);

                $this->Import_model->runFunctions($tipo_insert , $table);

                foreach ($allDataInSheet as $key => $headers) {
                    if($key == 1){
                        foreach ($headers as $keys => $value) {
                            if($value!=""){
                                $encabezado[] = $value;
                            }
                        } 
                    }
                }

                foreach ($allDataInSheet as $key => $data) {
                   
                    if($key != 0){
                        $c = 0;

                        if ($flag) {
                            $flag = false;
                            continue;
                        }

                        foreach ($data as $key => $value) {

                            if($value!=""){
                            
                            $inserdata[$encabezado[$c]] = $value;

                            $c++;
                            }
                        }

                        // Inserta directamente en una tabla
                        $result = $this->Import_model->insert($inserdata, $table  );

                        //Realiza el volcado en cadena de datos a productos.
                        //$this->crearProducto( $inserdata , $encabezado );
                    }
                   
                    $i++;
                }

                $result =1;
                if ($result) {
                    echo "Imported successfully";
                } else {
                    echo "ERROR !";
                }
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
            }
        } else {
            echo $error['error'];
        }
        redirect(base_url()."importacion/import/index");
    }

    public function otro()
    {

        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            die;
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $customer_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $address = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $city = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $postal_code = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $country = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $data[] = array(
                        'CustomerName'  => $customer_name,
                        'Address'   => $address,
                        'City'    => $city,
                        'PostalCode'  => $postal_code,
                        'Country'   => $country
                    );
                }
            }
            //$this->excel_import_model->insert($data);
            echo 'Data Imported successfully';
            die;
        }
    }

    public function crearProducto( $producto , $encabezado ){
        
        $marca = "";
        $giro  = "";
        $_Pencabezado = array();

        // Obtener > Atributos, > Marcas > Giros

        $atributos  = $this->Atributos_model->getAtributosByGiro(5); //5 Giro Comercial
        $marcas     = $this->Marca_model->getAllMarca();
        $giros      = $this->Giros_model->getAllgiros();
        
        // Filtrar por columna a utilizar

        $marcas             = array_column($marcas, 'nombre_marca');                
        $id_prod_atributo   = array_column($atributos, 'id_prod_atributo');
        
        // Reordenar el array por ID incremental de la tabla attributos
        
        array_multisort($id_prod_atributo, SORT_ASC, $atributos);

        // Construir Array Producto Encabezado

        foreach ($producto as $key => $p) {

            if(in_array( $p['marca'], $marcas ) ){

                $marca = $p['marca'];
            }

            if(in_array( $p['giro'], $giros ) ){
                $giro  = $p['giro'];
            }

            $_Pencabezado = array(
                
                'combo'     => 0,
                'Linea'     => 1,
                'Escala'    => 0,
                'Empresa'   => 1,
                'Giro'      => $giro,
                'Marca'     => $marca,
                'producto_estado'         => 1,
                'id_producto_relacionado' => 0,
                'name_entidad' => $p['name_entidad'],
                'creado_producto' => date('Y-m-d H:i:s')

            );

            // Crear Encabezado

            $id_encabezado = $this->Import_model->insertProductoEncabezado( $_Pencabezado );

            if( $id_encabezado != null ){
                $this->crearPA( $id_encabezado ,$atributos , $p);
                
            }
        }
    }

    //function crearPA( $id_encabezado ,$atributos ,$p ){
    function crearPA(){

        $atributos  = $this->Atributos_model->getAtributosByGiro(5); //5 Giro Comercial

        $productos  = $this->Import_model->get_productos();

        $valores = array();

        foreach ($productos as $key => $producto) {  

            $detalle_pivote = $this->Import_model->get_detalle_pivote($producto->codigo_producto);       

            foreach ($atributos as $key => $attr) {
                
                $id_prod_attri = null;

                $data_pa = array(
                    'Producto' => $producto->id_entidad ,
                    'Atributo' => $attr->id_prod_atributo
                );
                
                $id_prod_attri = $this->Import_model->insertProductoAttributo( $data_pa );

                //if(in_array( $attr->nam_atributo, $producto ) ){
                    $valores['id_prod_atributo'] = $id_prod_attri;

                    $val = $attr->nam_atributo;

                    $valores['valor'] = $detalle_pivote[0][$val];
                //}
                
                if( $id_prod_attri != null ){
                    // Crear Attributo Valor insert(ATTRIBUTO , VALOR)
                    $this->crearAV( $valores );
                }                
            }
        }
        // Crear Producto Atributo y Obtener el ID_prod_atributo insert(id_producto, id_atributos)
        
        /* 
        foreach ($atributos as $key => $attr) {
                
            $id_prod_attri = null;

            $data_pa = array(
                'Producto' => $id_encabezado ,
                'Atributo' => $attr['id_prod_attributo']
            );
            
            $id_prod_attri = $this->Import_model->insertProductoAttributo( $data_pa );

            if(in_array( $attr['nam_atributo'], $p ) ){
                $valores[]['id_prod_atributo'] = $id_prod_attri;
                $valores[]['valor'] = $p[$attr['nam_atributo']];
            }

            if( $id_prod_attri != null ){
                // Crear Attributo Valor insert(ATTRIBUTO , VALOR)
                $this->crearAV( $valores );
            }
            
        }
        */
    }

    function crearAV( $valores ){

        $this->Import_model->insertAttributoValor( $valores );

    }

    function crearPresentacion( $id_producto, $datos ){
        
        $detalle = array(
            'Producto' => $id_producto,
            'factor' => 1,
            'presentacion' => 'Unidad',
            'precio' => $datos[0]['Precio_Venta'],
            'unidad' => 100,
            'Utilidad' => 50,
            'cod_barra' => $datos[0]['Cod_Barras'],
            'estado_producto_detalle' => 1,
            'fecha_creacion_producto_detalle' => date('Y-m-d H:i:s')
        );

        $this->Import_model->insertarPresentacion( $detalle );
        
    }

    function Generador(){

        $cnt = 3001;

        for ( $i=1; $i<=2000; $i++ ) {
            $this->Import_model->Generador( $cnt );
            $cnt++;
        }
    }

    function insertPB(){

        //$atributos  = $this->Atributos_model->getAtributosByGiro(5); //5 Giro Comercial

        $productos  = $this->Import_model->get_productos();

        $valores = array();

        foreach ($productos as $key => $producto) {

            $detalle_pivote = $this->Import_model->get_detalle_pivote($producto->codigo_producto);

            $this->crearPresentacion($producto->id_entidad , $detalle_pivote);
            //$this->Import_model->insertProductoBodega($producto->id_entidad);
            //$this->Import_model->insertCategoriaProducto($producto->id_entidad, $producto->id_familia, $producto->id_grupo );

        }

    }

    function random(){
        echo rand();
    }
}
