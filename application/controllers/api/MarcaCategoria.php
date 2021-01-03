<?php
require APPPATH . 'libraries/REST_Controller.php';

class MarcaCategoria extends REST_Controller
{

    const marca = 'pos_marca';
    const categoria = 'categoria';
    const marca_categoria = 'pos_marca_categoria';

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
            $this->db->select("mc.*");
            $this->db->from(self::marca . ' m');
            $this->db->join(self::marca_categoria . ' mc', ' on m.id_marca = mc.Marca');
            $this->db->join(self::categoria . ' c', ' on mc.Categoria = id_categoria');
            $this->db->where('m.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
