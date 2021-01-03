<?php
require APPPATH . 'libraries/REST_Controller.php';

class DocumentoImpuesto extends REST_Controller
{

    const documento = 'pos_tipo_documento';
    const documento_impuesto = 'pos_impuesto_documento';

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
            $this->db->select("di.*");
            $this->db->from(self::documento . ' d');
            $this->db->join(self::documento_impuesto . ' di', ' on d.id_tipo_documento = di.Documento');
            $this->db->where('d.Empresa', $empresa);

            $data = $this->db->get()->result();
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }
}
