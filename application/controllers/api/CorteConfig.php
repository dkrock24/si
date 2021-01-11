<?php
require APPPATH . 'libraries/REST_Controller.php';

class CorteConfig extends REST_Controller
{

    const corte_config = 'pos_corte_config';
    const sucursal = 'pos_sucursal';

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
            $this->db->select("c.*");
            $this->db->from(self::corte_config . ' c');
            $this->db->join(self::sucursal . ' s', ' on c.sucursal_id = s.id_sucursal');
            $this->db->where('s.Empresa_Suc', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
