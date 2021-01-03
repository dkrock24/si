<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProductoCombo extends REST_Controller
{

    const producto = 'producto';
    const pos_combo = 'pos_combo';

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
            $this->db->select("pc.*");
            $this->db->from(self::producto . ' p');
            $this->db->join(self::pos_combo . ' pc', ' on p.id_entidad = pc.Producto_Combo');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
