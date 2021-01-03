<?php
require APPPATH . 'libraries/REST_Controller.php';

class Vistas extends REST_Controller
{

    const vistas   = 'sys_vistas';

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

        $data = $this->db->get(self::vistas)->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
