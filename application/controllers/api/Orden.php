<?php
require APPPATH . 'libraries/REST_Controller.php';

class Orden extends REST_Controller
{
    const ordenes = 'pos_ordenes';
    const ordenes2 = 'pos_ordenes2';
    const orden_detalle2 = 'pos_orden_detalle2';
    const pos_orden_impuestos2 = 'pos_orden_impuestos2';


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('form', 'url'));
    }

    /**
     * Post All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $this->load->helper(array('form', 'url'));

        $ordenesArray = $this->post();

        $dataInserted = [];
        foreach ($ordenesArray as $key => $ordenes) {
            $id_orden = $ordenes['id'];
            unset($ordenes['id']);
            
            $this->db->trans_begin();
            $this->db->insert(self::ordenes2,$ordenes);

            if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
            } else {
                $dataInserted [] = 
                    array(
                        'id_orden_local' => $id_orden,
                        'id_orden_produccion' => $this->db->insert_id(),
                        'id_sucursal'=> $ordenes['id_sucursal']
                    );
                
                $this->db->trans_commit();
            }
        }

        $this->response($dataInserted, REST_Controller::HTTP_OK);
    }

    /**
     * Post All Data from this method.
     *
     * @return Response
    */
    public function detalle_post()
    {
        $this->load->helper(array('form', 'url'));

        $ordeneDetalles = $this->post();
        $dataIntegrada = [];

        foreach ($ordeneDetalles as $detalle) {

            unset($detalle->id_orden_detalle);

            $this->db->trans_begin();
            $this->db->insert(self::orden_detalle2,$detalle);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        $this->response("orden detalle insertados", REST_Controller::HTTP_OK);
    }

    /**
     * Post All Data from this method.
     *
     * @return Response
    */
    public function impuesto_post()
    {
        $this->load->helper(array('form', 'url'));

        $ordeneImpuesto = $this->post();
        $dataIntegrada = [];

        foreach ($ordeneImpuesto as $impuesto) {

            unset($impuesto->id_orden_detalle);

            $this->db->trans_begin();
            $this->db->insert(self::pos_orden_impuestos2,$impuesto);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        $this->response("orden impuestos insertados", REST_Controller::HTTP_OK);
    }
}
