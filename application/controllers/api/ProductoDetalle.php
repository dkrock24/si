<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProductoDetalle extends REST_Controller
{

    const producto = 'producto';
    const producto_detalle = 'producto_detalle';

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
            $this->db->select("d.*");
            $this->db->from(self::producto . ' p');
            $this->db->join(self::producto_detalle . ' d', ' on p.id_entidad = d.Producto');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
