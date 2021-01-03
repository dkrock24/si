<?php
require APPPATH . 'libraries/REST_Controller.php';

class Producto extends REST_Controller
{

    const producto   = 'producto';

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
            $data = $this->db->get_where(self::producto, ['Empresa' => $id])->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
