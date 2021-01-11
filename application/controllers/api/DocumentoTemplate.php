<?php
require APPPATH . 'libraries/REST_Controller.php';

class DocumentoTemplate extends REST_Controller
{

    const documento_template = 'pos_doc_temp';

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
            $this->db->select("*");
            $this->db->from(self::documento_template);
            $this->db->where('Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
