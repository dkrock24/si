<?php
class Pagos_model extends CI_Model {

	const cliente =  'pos_cliente';
    const formas_pago =  'pos_formas_pago';
    const tipos_documentos =  'pos_tipo_documento';
    const sys_persona =  'sys_persona';
    const pos_tipo_documento= 'pos_tipo_documento';
    const pos_formas_pago_cliente = 'pos_formas_pago_cliente';

    function getPagos($limit, $id){

        $this->db->select('*');
        $this->db->from(self::formas_pago);  
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);          
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }


    function getTipoPago(){

        $this->db->select('*');
        $this->db->from(self::formas_pago.' as fp');
        $this->db->where('estado_modo_pago = 1');
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getPagosClientes($idCliente){

        $this->db->select('*');
        $this->db->from(self::cliente.' as c');
        $this->db->join(self::pos_formas_pago_cliente.' as fpc',' on c.id_cliente=fpc.cliente_form_pago');
        $this->db->join(self::formas_pago.' as fp',' on fpc.Forma_pago=fp.id_modo_pago');
        $this->db->where('c.id_cliente', $idCliente );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::formas_pago);
        $result = $this->db->count_all_results();
        return $result;
    }

    function save( $data ){

        $data['Empresa'] = $this->session->empresa[0]->id_empresa;
        $data['creado_modo_pago'] = date('Y-m-d H:i:s');

        $result = $this->db->insert(self::formas_pago , $data );
        return $result;

    }

    function getPagoId( $pago_id ){

        $this->db->select('*');
        $this->db->from(self::formas_pago);
        $this->db->where('id_modo_pago ', $pago_id );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update( $data ){

        $data['actualizado_modo_pago'] = date('Y-m-d H:i:s');

        $this->db->where('id_modo_pago' , $data['id_modo_pago'] );
        $result = $this->db->update(self::formas_pago , $data );
        return $result;

    }

    function eliminar( $pago_id ){

        $data = array(
            'id_modo_pago' => $pago_id
        );

        $result = $this->db->delete(self::formas_pago, $data);

        return $result;



    }

}