<?php
require APPPATH . 'libraries/REST_Controller.php';

class OrdenEstado extends REST_Controller
{

    const orden_estados   = 'pos_orden_estado';

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
        $data = $this->db->get(self::orden_estados)->result();        

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
