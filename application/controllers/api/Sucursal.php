<?php
require APPPATH . 'libraries/REST_Controller.php';

class Sucursal extends REST_Controller
{

    const sucursal   = 'pos_sucursal';

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
    public function index_get($empresa, $id = 0)
    {
        if (!empty($empresa)) {
            if (!empty($id)) {
                $data = $this->db->get_where(self::sucursal, ['Empresa_Suc' => $empresa, 'id_sucursal' => $id])->row_array();
            } else {
                $data = $this->db->get_where(self::sucursal, ['Empresa_Suc' => $empresa])->result();
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
