<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProductoProveedor extends REST_Controller
{

    const producto = 'producto';
    const proveedor = 'pos_proveedor';
    const producto_proveedor = 'pos_proveedor_has_producto';

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
            $this->db->select("pp.*");
            $this->db->from(self::producto . ' p');
            $this->db->join(self::producto_proveedor . ' pp', ' on p.id_entidad = pp.producto_id_producto');
            $this->db->join(self::proveedor . ' pr', ' on pr.id_proveedor = pp.proveedor_id_proveedor');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
