<?php
require APPPATH . 'libraries/REST_Controller.php';

class Usuario extends REST_Controller
{

    const usuario = 'sys_usuario';
    const persona = 'sys_persona';
    const empleado = 'sys_empleado';

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
        if (!empty($id)) {
            $this->db->select('u.*');
            $this->db->from(self::usuario . ' u');
            $this->db->join(self::empleado . ' e', ' on u.Empleado = e.id_empleado');
            $this->db->join(self::persona . ' p', ' on p.id_persona = e.Persona_E');
            $this->db->where(' p.Empresa', $id);
            $data = $this->db->get()->result();

            foreach ($data as $key => $usuario) {
                $data[$key]->img = base64_encode($data[$key]->img);
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
