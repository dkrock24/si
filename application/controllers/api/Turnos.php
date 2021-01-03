<?php
require APPPATH . 'libraries/REST_Controller.php';

class Turnos extends REST_Controller
{

    const turnos   = 'pos_turnos';

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
    public function index_get($empresa = 0)
    {
        if (!empty($empresa)) {
            $data = $this->db->get_where(self::turnos, ['Empresa' => $empresa])->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
