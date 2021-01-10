<?php
require APPPATH . 'libraries/REST_Controller.php';

class Empresa extends REST_Controller
{

    const empresa   = 'pos_empresa';

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
    public function index_get($id = 0)
    {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from(self::empresa);
            $this->db->where('id_empresa', $id);
            $data = $this->db->get()->result();
            
            $data[0]->logo_empresa = base64_encode($data[0]->logo_empresa);

        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
