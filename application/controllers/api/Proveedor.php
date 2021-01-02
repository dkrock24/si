<?php
require APPPATH . 'libraries/REST_Controller.php';

class Proveedor extends REST_Controller
{
    const proveedor = 'pos_proveedor';

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
    public function index_get($id = 0)
    {
        if (!empty($id)) {
            $data = $this->db->get_where(self::proveedor, ['Empresa_id' => $id])->result();

            foreach ($data as $key => $proveedor) {
                $data[$key]->logo = base64_encode($proveedor->logo);
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
