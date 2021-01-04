<?php
require APPPATH . 'libraries/REST_Controller.php';

class ProductoAtributoValor extends REST_Controller
{

    const producto = 'producto';
    const atributo = 'producto_atributo';
    const valor = 'producto_valor';

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
            $this->db->select("v.*");
            $this->db->from(self::producto . ' p');
            $this->db->join(self::atributo . ' a', ' on p.id_entidad = a.Producto');
            $this->db->join(self::valor . ' v', ' on v.id_prod_atributo = a.id_prod_atrri');
            $this->db->where('p.Empresa', $empresa);

            $data = $this->db->get()->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
