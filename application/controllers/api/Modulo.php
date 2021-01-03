<?php
require APPPATH . 'libraries/REST_Controller.php';

class Modulo extends REST_Controller
{

    const modulo   = 'sys_modulo';

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

        $data = $this->db->get(self::modulo)->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
