<?php
require APPPATH . 'libraries/REST_Controller.php';

class MenuSubMenuAcceso extends REST_Controller
{

    const menu = 'sys_menu';
    const acceso = 'sys_menu_acceso';
    const submenu = 'sys_menu_submenu';
    const submenu_acceso = 'sys_submenu_acceso';

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

        $this->db->select("sm.*");
        $this->db->from(self::menu . ' m');
        $this->db->join(self::submenu . ' s', ' on m.id_menu = s.id_menu');
        $this->db->join(self::submenu_acceso . ' sm', ' on sm.id_submenu = s.id_submenu');

        $data = $this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
