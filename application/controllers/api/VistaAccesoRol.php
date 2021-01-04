<?php
require APPPATH . 'libraries/REST_Controller.php';

class VistaAccesoRol extends REST_Controller
{

    const rol   = 'sys_role';
    const vista_acceso   = 'sys_vistas_acceso';

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
            $this->db->select("va.*");
            $this->db->from(self::rol . ' r');
            $this->db->join(self::vista_acceso . ' va', ' on r.id_rol = va.id_role');
            $this->db->where('r.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
