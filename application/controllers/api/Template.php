<?php
require APPPATH . 'libraries/REST_Controller.php';

class Template extends REST_Controller
{

    const pos_empresa   = 'pos_empresa';

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
            $data = $this->db->get_where("pos_giros", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("pos_giros")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function empresa_get($id){
        //$data =  $this->db->get_where('pos_empresa', ['id_empresa', $id])->row_array(); 
        //var_dump($data);die;

        $this->db->select('e.id_empresa');
        $this->db->from(self::pos_empresa.' e');
        //$this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        $this->db->where('id_empresa', $id);
        
        $data = $query = $this->db->get();
        

        $this->response($data->row_array(), REST_Controller::HTTP_OK);
        
    }
}
