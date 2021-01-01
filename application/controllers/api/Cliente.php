<?php
require APPPATH . 'libraries/REST_Controller.php';

class Cliente extends REST_Controller
{

    const persona = 'sys_persona';
    const cliente = 'pos_cliente';

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
            $this->db->select('c.*');
            $this->db->from(self::persona . ' p');
            $this->db->join(self::cliente . ' c', ' on p.id_persona = c.Persona');
            $this->db->where(' p.Empresa', $empresa);
            $data = $this->db->get()->result();
            
            foreach ($data as $key => $cliente) {
                $data[$key]->logo_cli = base64_encode($data[$key]->logo_cli);                
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
