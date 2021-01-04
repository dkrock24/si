<?php
require APPPATH . 'libraries/REST_Controller.php';

class ComponenteVista extends REST_Controller
{

    const componentes   = 'sys_componentes';
    const componentes_vista   = 'sys_vistas_componentes';

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
        $this->db->select("cv.*");
        $this->db->from(self::componentes . ' c');
        $this->db->join(self::componentes_vista . ' cv', ' on c.id_vista_componente = cv.Componente');

        $data = $this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
