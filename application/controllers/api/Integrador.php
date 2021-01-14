<?php
require APPPATH . 'libraries/REST_Controller.php';

class Integrador extends REST_Controller
{

    const integrador   = 'sys_integrador';

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
        $data = $this->db->get(self::integrador)->result();
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
