<?php
require APPPATH . 'libraries/REST_Controller.php';

class ClienteImpuesto extends REST_Controller
{

    const cliente = 'pos_cliente';
    const persona = 'sys_persona';
    const cliente_impuesto = 'pos_impuesto_cliente';

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
            $this->db->select("ci.*");
            $this->db->from(self::cliente . ' c');
            $this->db->join(self::persona . ' p', ' on p.id_persona = c.Persona');
            $this->db->join(self::cliente_impuesto . ' ci', ' on c.id_cliente = ci.Cliente');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
