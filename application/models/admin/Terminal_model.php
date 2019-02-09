<?php
class Terminal_model extends CI_Model {

	const pos_terminal = 'pos_terminal';
	const pos_terminal_cajero = 'pos_terminal_cajero';


	function validar_usuario_terminal( $usuario_id , $terminal_nombe ){
		$this->db->select('*');
        $this->db->from(self::pos_terminal.' as terminal');
        $this->db->join(self::pos_terminal_cajero.' as cajero ',' on cajero.Terminal = terminal.id_terminal ');
        $this->db->where('cajero.Cajero_terminal = '. $usuario_id);
        $this->db->where('terminal.mac_address = ', $terminal_nombe);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}