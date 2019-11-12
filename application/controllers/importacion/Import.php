<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
                
                die;
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);

                $objPHPExcel = $objReader->load($inputFileName);


                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $flag = true;
                $i = 0;
                foreach ($allDataInSheet as $value) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }
                    echo $inserdata[$i]['first_name'] = $value['A'];
                    $inserdata[$i]['last_name'] = $value['B'];
                    $i++;
                }
                $result = $this->Import_model->insert($inserdata);
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
        $this->load->view('import');
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
}
