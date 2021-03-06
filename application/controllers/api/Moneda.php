<?php
require APPPATH . 'libraries/REST_Controller.php';

class Moneda extends REST_Controller
{

    const moneda   = 'sys_moneda';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get All Data from moneda.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->db->get_where(self::moneda, ['id_moneda' => $id])->row_array();
        }else{
            $data = $this->db->get(self::moneda)->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
