<?php
require APPPATH . 'libraries/REST_Controller.php';

class Correlativo extends REST_Controller
{

    const correlativo = 'pos_correlativos';
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
    public function index_get($empresa, $sucursal=0)
    {
        if (!empty($empresa)) {
            $this->db->select('c.*');
            $this->db->from(self::correlativo.' c');
            $this->db->join(self::sucursal . ' s', ' on c.Sucursal = s.id_sucursal');
            $this->db->where('s.Empresa_Suc', $empresa);
            
            if ($sucursal != 0) {
                $this->db->where('c.Sucursal', $sucursal);
            }

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
