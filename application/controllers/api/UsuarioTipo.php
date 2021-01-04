<?php
require APPPATH . 'libraries/REST_Controller.php';

class UsuarioTipo extends REST_Controller
{

    const usuario_tipo = 'sys_tipo_usuario';

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
        $data = $this->db->get_where(self::usuario_tipo)->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
