<?php
require APPPATH . 'libraries/REST_Controller.php';

class Linea extends REST_Controller
{
    const lineas   = 'pos_linea';
    const lineas2   = 'pos_linea2';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->helper(array('form', 'url'));
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($empresa , $id = 0)
	{
        if (!empty($empresa)) {
            if (!empty($id)) {
                $data = $this->db->get_where(self::lineas, ['Empresa' => $empresa,'id_linea' => $id])->row_array();
            } else {
                $data = $this->db->get_where(self::lineas,['Empresa' => $empresa])->result();
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $this->load->helper(array('form', 'url'));

        $input = $this->post();
        $this->db->insert(self::lineas2,$input);
        //var_dump($input);

        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 
}
