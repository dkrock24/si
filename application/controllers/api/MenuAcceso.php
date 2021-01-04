<?php
require APPPATH . 'libraries/REST_Controller.php';

class MenuAcceso extends REST_Controller
{

    const menu = 'sys_menu';
    const acceso = 'sys_menu_acceso';

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

        $this->db->select("a.*");
        $this->db->from(self::menu . ' m');
        $this->db->join(self::acceso . ' a', ' on m.id_menu = a.id_menu');

        $data = $this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
