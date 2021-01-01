<?php
require APPPATH . 'libraries/REST_Controller.php';

class Terminal extends REST_Controller
{

    const empresa = 'pos_empresa';
    const terminal = 'pos_terminal';
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
    public function index_get($empresa, $id = 0)
    {
        if (!empty($empresa)) {
            $this->db->select('t.*');
            $this->db->from(self::terminal . ' t');
            $this->db->join(self::sucursal . ' s', ' on s.id_sucursal = t.Sucursal');
            $this->db->join(self::empresa . ' e', ' on s.Empresa_Suc = e.id_empresa');

            if (!empty($id)) {
                $this->db->where('s.id_sucursal', $id);
            }
            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
