<?php
require APPPATH . 'libraries/REST_Controller.php';

class TerminalCajero extends REST_Controller
{

    const terminal = 'pos_terminal';
    const sucursal = 'pos_sucursal';
    const terminal_cajero = 'pos_terminal_cajero';

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
            $this->db->select("tc.*");
            $this->db->from(self::terminal_cajero . ' tc');
            $this->db->join(self::terminal . ' t', ' on t.id_terminal = tc.Terminal');
            $this->db->join(self::sucursal . ' s', ' on s.id_sucursal = t.Sucursal');
            $this->db->where('s.Empresa_Suc', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
