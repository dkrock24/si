<?php
require APPPATH . 'libraries/REST_Controller.php';

class VistasEstado extends REST_Controller
{

    const vistas = 'sys_vistas';
    const vista_estado = 'sys_estados_vistas';

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
    public function index_get()
    {
        $this->db->select("ve.*");
        $this->db->from(self::vistas . ' v');
        $this->db->join(self::vista_estado . ' ve', ' on v.id_vista = ve.vista_id');

        $data = $this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
