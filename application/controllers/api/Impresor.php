<?php
require APPPATH . 'libraries/REST_Controller.php';

class Impresor extends REST_Controller
{

    const impresor   = 'pos_impresor';

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
                $data = $this->db->get_where(self::impresor, ['impresor_empresa' => $empresa, 'id_impresor' => $id])->row_array();
            } else {
                $data = $this->db->get_where(self::impresor, ['impresor_empresa' => $empresa])->result();
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
