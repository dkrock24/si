<?php
require APPPATH . 'libraries/REST_Controller.php';

class MenuSubMenu extends REST_Controller
{

    const menu = 'sys_menu';
    const acceso = 'sys_menu_acceso';
    const submenu = 'sys_menu_submenu';

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

        $this->db->select("s.*");
        $this->db->from(self::menu . ' m');
        $this->db->join(self::submenu . ' s', ' on m.id_menu = s.id_menu');

        $data = $this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
