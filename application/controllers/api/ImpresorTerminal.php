<?php
require APPPATH . 'libraries/REST_Controller.php';

class ImpresorTerminal extends REST_Controller
{

    const impresor = 'pos_impresor';
    Const terminal = 'pos_terminal';
    Const impresor_terminal = 'pos_impresor_terminal';

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
            $this->db->select("it.*");
            $this->db->from(self::impresor . ' i');
            $this->db->join(self::impresor_terminal . ' it', ' on it.impresor_id = i.id_impresor');
            $this->db->join(self::terminal . ' t', ' on t.id_terminal = it.terminal_id');
            $this->db->where('i.impresor_empresa', $empresa);

            $data = $this->db->get()->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
