<?php
require APPPATH . 'libraries/REST_Controller.php';

class GiroEmpresa extends REST_Controller
{

    const giros_empresa = 'giros_empresa';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_get($empresa)
    {
        if (!empty($empresa)) {
            $data = $this->db->get_where(self::giros_empresa, ['Empresa' => $empresa])->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
