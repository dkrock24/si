<?php
class ModoPago_model extends CI_Model {
	const formas_pago =  'pos_formas_pago';

	function get_formas_pago(){
		$this->db->select('*');
        $this->db->from(self::formas_pago);
        $this->db->where(self::formas_pago.'.estado_modo_pago = 1');
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}