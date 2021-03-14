<?php
require APPPATH . 'libraries/REST_Controller.php';

class Venta extends REST_Controller
{
    const ventas2 = 'pos_ventas2';
    const pos_venta_detalle2 = 'pos_venta_detalle2';
    const pos_venta_impuestos2 = 'pos_ventas_impuestos2';
    const pos_venta_pagos2 = 'pos_venta_pagos2';

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

        $ventasArray = $this->post();
        
        $dataInserted = [];
        foreach ($ventasArray as $key => $venta) {
            $id_orden = $venta['id'];
            unset($venta['id']);
            
            $this->db->trans_begin();
            $a = $this->db->insert(self::ventas2,$venta);
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $dataInserted [] = 
                array(
                    'id_venta_local' => $id_orden,
                    'id_venta_produccion' => $this->db->insert_id(),
                    'id_sucursal'=> $venta['id_sucursal']
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

        $ventaDetalles = $this->post();
        $dataIntegrada = [];

        foreach ($ventaDetalles as $detalle) {

            unset($detalle->id_orden_detalle);

            $this->db->trans_begin();
            $this->db->insert(self::pos_venta_detalle2,$detalle);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        $this->response("Ventas detalle integradas", REST_Controller::HTTP_OK);
    }

    /**
     * Post All Data from this method.
     *
     * @return Response
    */
    public function impuesto_post()
    {
        $this->load->helper(array('form', 'url'));

        $ventaImpuesto = $this->post();
        $dataIntegrada = [];

        foreach ($ventaImpuesto as $impuesto) {

            unset($impuesto->id_vent_imp);

            $this->db->trans_begin();
            $this->db->insert(self::pos_venta_impuestos2, $impuesto);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        $this->response("Venta impuestos integrados", REST_Controller::HTTP_OK);
    }

    /**
     * Post All Data from this method.
     *
     * @return Response
    */
    public function pagos_post()
    {
        $this->load->helper(array('form', 'url'));

        $ventaPagos = $this->post();
        $dataIntegrada = [];

        foreach ($ventaPagos as $pago) {

            unset($pago->id_vent_imp);

            $this->db->trans_begin();
            $this->db->insert(self::pos_venta_pagos2, $pago);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        $this->response("Venta pagos integrados", REST_Controller::HTTP_OK);
    }
}
