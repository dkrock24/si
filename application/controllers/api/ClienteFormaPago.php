<?php
require APPPATH . 'libraries/REST_Controller.php';

class ClienteFormapago extends REST_Controller
{

    const cliente = 'pos_cliente';
    const persona = 'sys_persona';
    const pago_cliente = 'pos_formas_pago_cliente';

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
            $this->db->select("pc.*");
            $this->db->from(self::persona . ' p');
            $this->db->join(self::cliente . ' c', ' on c.Persona = p.id_persona');
            $this->db->join(self::pago_cliente . ' pc', ' on pc.Cliente_form_pago = c.id_cliente');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
