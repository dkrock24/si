<?php
require APPPATH . 'libraries/REST_Controller.php';

class SucursalBodega extends REST_Controller
{

    const sucursal = 'pos_sucursal';
    const bodega = 'pos_bodega';

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
    public function index_get($empresa = 0)
    {
        if (!empty($empresa)) {
            $this->db->select("b.*");
            $this->db->from(self::sucursal . ' s');
            $this->db->join(self::bodega . ' b', ' on s.id_sucursal = b.Sucursal');
            $this->db->where('s.Empresa_Suc', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
