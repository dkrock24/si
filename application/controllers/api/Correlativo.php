<?php
require APPPATH . 'libraries/REST_Controller.php';

class Correlativo extends REST_Controller
{

    const correlativo   = 'pos_correlativos';

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
    public function index_get($sucursal, $id = 0)
    {
        if (!empty($sucursal)) {
            if (!empty($id)) {
                $data = $this->db->get_where(self::correlativo, ['Sucursal' => $sucursal, 'id_correlativos' => $id])->row_array();
            } else {
                $data = $this->db->get_where(self::correlativo, ['Sucursal' => $sucursal])->result();
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
