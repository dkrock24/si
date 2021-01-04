<?php
require APPPATH . 'libraries/REST_Controller.php';

class AtributoOpcion extends REST_Controller
{

    const atributo   = 'atributo';
    const opciones   = 'atributos_opciones';

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
        $this->db->select("o.*");
        $this->db->from(self::atributo . ' a');
        $this->db->join(self::opciones . ' o', ' on a.id_prod_atributo = o.Atributo');

        $data = $this->db->get()->result();

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
