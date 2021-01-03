<?php
require APPPATH . 'libraries/REST_Controller.php';

class GiroPlantilla extends REST_Controller
{

    const giro = 'pos_giros';
    const giro_plantilla = 'giro_pantilla';

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
            $this->db->select("gp.*");
            $this->db->from(self::giro . ' g');
            $this->db->join(self::giro_plantilla . ' gp', ' on gp.Giro = g.id_giro');
            $this->db->where('g.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
