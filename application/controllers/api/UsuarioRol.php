<?php
require APPPATH . 'libraries/REST_Controller.php';

class UsuarioRol extends REST_Controller
{

    const usuario = 'sys_usuario';
    const persona = 'sys_persona';
    const empleado = 'sys_empleado';
    const usuario_rol = 'sys_usuario_roles';

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
            $this->db->select('ur.*');
            $this->db->from(self::usuario . ' u');
            $this->db->join(self::empleado . ' e', ' on u.Empleado = e.id_empleado');
            $this->db->join(self::persona . ' p', ' on p.id_persona = e.Persona_E');
            $this->db->join(self::usuario_rol . ' ur', ' on ur.usuario_rol_usuario = u.id_usuario');
            $this->db->where(' p.Empresa', $empresa);
            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
