<?php
require APPPATH . 'libraries/REST_Controller.php';

class Orden extends REST_Controller
{
    const ordenes   = 'pos_ordenes';
    const ordenes2  = 'pos_ordenes2';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->helper(array('form', 'url'));
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $this->load->helper(array('form', 'url'));

        $ordenesArray = $this->post();

        $dataInserted = [];
        foreach ($ordenesArray as $key => $ordenes) {
            $id_orden = $ordenes['id'];
            unset($ordenes['id']);
            $this->db->insert(self::ordenes2,$ordenes);
            $dataInserted[$id_orden] = $this->db->insert_id();
        }

        $this->response($dataInserted, REST_Controller::HTTP_OK);
    } 
}
