<?php
require APPPATH . 'libraries/REST_Controller.php';

class SucursalTemplate extends REST_Controller
{

    const sucursal = 'pos_sucursal';
    const sucursal_template = 'pos_temp_sucursal';

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
            $this->db->select("st.*");
            $this->db->from(self::sucursal . ' s');
            $this->db->join(self::sucursal_template . ' st', ' on s.id_sucursal = st.Sucursal');
            $this->db->where('s.Empresa_Suc', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
