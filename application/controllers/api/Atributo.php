<?php
require APPPATH . 'libraries/REST_Controller.php';

class Atributo extends REST_Controller
{

    const atributo   = 'atributo';

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
        $data = $this->db->get_where(self::atributo)->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
