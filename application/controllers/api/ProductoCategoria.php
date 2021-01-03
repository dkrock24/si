<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProductoCategoria extends REST_Controller
{

    const producto = 'producto';
    const categoria_producto = 'categoria_producto';

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
            $this->db->select("cp.*");
            $this->db->from(self::producto . ' p');
            $this->db->join(self::categoria_producto . ' cp', ' on p.id_entidad = cp.id_producto');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
