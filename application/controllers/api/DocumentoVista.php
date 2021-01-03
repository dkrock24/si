<?php
require APPPATH . 'libraries/REST_Controller.php';

class DocumentoVista extends REST_Controller
{

    const documento = 'pos_tipo_documento';
    const documento_vista = 'sys_vistas_documento';

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
            $this->db->select("dv.*");
            $this->db->from(self::documento . ' d');
            $this->db->join(self::documento_vista . ' dv', ' on d.id_tipo_documento = dv.documento_id');
            $this->db->where('d.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
