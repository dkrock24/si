<?php
require APPPATH . 'libraries/REST_Controller.php';

class Empleado extends REST_Controller
{

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
        if(!empty($id)){
            $this->db->select('e.*');
            $this->db->from(self::empleado . ' e');
            $this->db->join(self::persona . ' p', ' on p.id_persona = e.Persona_E');
            $this->db->where(' p.Empresa', $id);
            $data = $this->db->get()->result();

            foreach ($data as $key => $usuario) {
                $data[$key]->img_empleado = base64_encode($data[$key]->img_empleado);
            }
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
