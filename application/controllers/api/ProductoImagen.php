<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProductoImagen extends REST_Controller
{

    const producto_img = 'pos_producto_img';
    const producto = 'producto';

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
            $this->db->select("pi.*");
            $this->db->from(self::producto . ' p');
            $this->db->join(self::producto_img . ' pi', ' on p.id_entidad = pi.id_producto');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();

            foreach ($data as $key => $producto) {
                $data[$key]->producto_img_blob = base64_encode($data[$key]->producto_img_blob);
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
