<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProveedorImpuesto extends REST_Controller
{

    const proveedor = 'pos_proveedor';
    const cliente_impuesto = 'pos_impuesto_proveedor';

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
            $this->db->from(self::proveedor . ' p');
            $this->db->join(self::cliente_impuesto . ' cp', ' on p.id_proveedor = cp.Proveedor');
            $this->db->where('p.Empresa_id', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
