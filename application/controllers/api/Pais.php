<?php
require APPPATH . 'libraries/REST_Controller.php';

class Pais extends REST_Controller
{
    const pais   = 'sys_pais';
    const municipio = 'sys_ciudad';
    const departamneto = 'sys_departamento';

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
            $data = $this->db->get_where(self::pais, ['id_pais' => $id])->row_array();
        } else {
            $data = $this->db->get(self::pais)->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function pais_dep_get($id = 0){

        $this->db->select('d.*');
        $this->db->from(self::pais.' p');
        $this->db->join(self::departamneto.' d', ' on p.id_pais = d.pais');

        if(!empty($id)){
            $this->db->where('d.id_departamento', $id);
        }
        $data =$this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function pais_dep_ciu_get($id = 0){

        $this->db->select('m.*');
        $this->db->from(self::pais.' p');
        $this->db->join(self::departamneto.' d', ' on p.id_pais = d.pais');
        $this->db->join(self::municipio.' m', ' on m.departamento = d.id_departamento');

        if(!empty($id)){
            $this->db->where('d.id_departamento', $id);
        }
        $data =$this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
