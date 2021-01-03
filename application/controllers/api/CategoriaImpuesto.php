<?php
require APPPATH . 'libraries/REST_Controller.php';

class CategoriaImpuesto extends REST_Controller
{

    const categoria = 'categoria';
    const categoria_impuesto = 'pos_impuesto_categoria';

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
    public function index_get($empresa)
    {
        if (!empty($empresa)) {
            $this->db->select("ci.*");
            $this->db->from(self::categoria . ' c');
            $this->db->join(self::categoria_impuesto . ' ci', ' on c.id_categoria = ci.Categoria');
            $this->db->where('c.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
