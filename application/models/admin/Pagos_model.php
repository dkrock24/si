<?php
class Pagos_model extends CI_Model {

	const cliente =  'pos_cliente';
    const sys_persona =  'sys_persona';
    const formas_pago =  'pos_formas_pago';
    const formas_pago2 =  'pos_formas_pago2';
    const tipos_documentos =  'pos_tipo_documento';
    const pos_orden_estado = 'pos_orden_estado';
    const pos_tipo_documento= 'pos_tipo_documento';
    const pos_formas_pago_cliente = 'pos_formas_pago_cliente';

    /**
     * Retorna la lista pagina de formas de pagos
     *
     * @param int $limit
     * @param int $id
     * @param string $filters
     * @return void
     */
    public function getPagos($limit, $id, $filters ){

        $this->db->select('*');
        $this->db->from(self::formas_pago);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = pos_formas_pago.estado_modo_pago');
        //$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }


    /**
     * obtener la lista de pagos
     *
     * @return void
     */
    public function getTipoPago(){

        $this->db->select('*');
        $this->db->from(self::formas_pago.' as fp');
        $this->db->where('estado_modo_pago = 1');
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /**
     * Retornar las formas de pago del cliente
     *
     * @param int $idCliente
     * @return void
     */
    public function getPagosClientes(int $idCliente){

        // Sincronzar formas de pago del cliente
        $this->crear_formapago_cliente($idCliente);

        $this->db->select('*');
        //$this->db->from(self::cliente.' as c');
        $this->db->from(self::pos_formas_pago_cliente.' as fpc');
        $this->db->join(self::formas_pago.' as fp',' on fpc.Forma_pago=fp.id_modo_pago','full');
        $this->db->where('fpc.Cliente_form_pago', $idCliente );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /**
     * Asociar la formas de pagos restante al cliente si no las tiene
     *
     * @param int $idCliente
     * @return void
     */
    private function crear_formapago_cliente(int $idCliente){

        $pagos = $this->getTipoPago();

        foreach ($pagos as $key => $TipoPago) {

            $params = array(
                'id_forma_pago' => $TipoPago->id_modo_pago,
                'cliente_id'    => $idCliente
            );
            
            $pagos = $this->pagos_clientes( $params );

            if ( !$pagos ) {

                $data = array(
                    'Forma_pago' => $TipoPago->id_modo_pago,
                    'Cliente_form_pago' => $idCliente,
                    'for_pag_emp_estado' => 0
                );

                $result = $this->db->insert(self::pos_formas_pago_cliente , $data );

            }
        }

    }

    /**
     * Obtener todos los tipos de pagos que tiene el cliente
     *
     * @param array $params
     * @return void
     */
    private function pagos_clientes( array $params ){

        $this->db->select('*');
        $this->db->from(self::pos_formas_pago_cliente.' as fpc');
        $this->db->where('fpc.Cliente_form_pago', $params['cliente_id'] );
        $this->db->where('fpc.Forma_pago', $params['id_forma_pago'] );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }


    /**
     * contar numero de registros para mostrar en la paginacion
     *
     * @param string $filter
     * @return void
     */
    public function record_count(string $filter){
        
        if($filter){
            $this->db->where($filter);
        }

        $this->db->from(self::formas_pago);
        $result = $this->db->count_all_results();

        return $result;
    }

    /**
     * Guardar for a de pago
     *
     * @param array $data
     * @return void
     */
    public function save( array $data ){

        $data['Empresa'] = $this->session->empresa[0]->id_empresa;
        $data['creado_modo_pago'] = date('Y-m-d H:i:s');

        $result = $this->db->insert(self::formas_pago , $data );
        return $result;

    }

    /**
     * Obtener forma de pago for ID
     *
     * @param integer $pago_id
     * @return void
     */
    public function getPagoId( int $pago_id ){

        $this->db->select('*');
        $this->db->from(self::formas_pago);
        $this->db->where('id_modo_pago ', $pago_id );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /**
     * Actualizar cada forma de pago
     *
     * @param array $data
     * @return void
     */
    public function update( array $data ){

        $data['actualizado_modo_pago'] = date('Y-m-d H:i:s');

        $this->db->where('id_modo_pago' , $data['id_modo_pago'] );
        $result = $this->db->update(self::formas_pago , $data );
        if(!$result){
            $result = $this->db->error();
        }

        return $result;

    }

    /**
     * Eliminar forma de pago
     *
     * @param integer $pago_id
     * @return void
     */
    public function eliminar(int $pago_id ){

        $data = array(
            'id_modo_pago' => $pago_id
        );

        $result = $this->db->delete(self::formas_pago, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;

    }

    function insert_api($pagos)
    {
        $this->db->truncate(self::formas_pago2);

        $data = [];
        foreach ($pagos as $key => $pago) {
            $data[] = $pago;
        }
        $this->db->insert_batch(self::formas_pago2, $data);
    }

}