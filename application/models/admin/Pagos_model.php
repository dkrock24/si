<?php
class Pagos_model extends CI_Model {

	const cliente =  'pos_cliente';
    const formas_pago =  'pos_formas_pago';
    const tipos_documentos =  'pos_tipo_documento';
    const sys_persona =  'sys_persona';
    const pos_tipo_documento= 'pos_tipo_documento';
    const pos_formas_pago = 'pos_formas_pago';

    function getTipoPago(){

        $this->db->select('*');
        $this->db->from(self::pos_formas_pago.' as fp');
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
        $this->db->join(self::formas_pago.' as fp',' on c.id_cliente=fp.cliente_forma_pago');
        $this->db->where('c.id_cliente', $idCliente );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

}