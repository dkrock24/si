<?php
require APPPATH . 'libraries/REST_Controller.php';

class Pagos extends REST_Controller
{

    const pagos   = 'pos_formas_pago';

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
        $data = $this->db->get(self::pagos)->result();        

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
