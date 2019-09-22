<?php
class Terminal_model extends CI_Model {

	const pos_terminal = 'pos_terminal';
	const pos_terminal_cajero = 'pos_terminal_cajero';
    const sucursal = "pos_sucursal";


	function validar_usuario_terminal( $usuario_id , $terminal_nombe ){
		$this->db->select('*');
        $this->db->from(self::pos_terminal.' as terminal');
        $this->db->join(self::pos_terminal_cajero.' as cajero ',' on cajero.Terminal = terminal.id_terminal ');
        $this->db->where('cajero.Cajero_terminal = '. $usuario_id);
        $this->db->where('terminal.mac_address = ', $terminal_nombe);
        $this->db->where('cajero.estado_terminal_cajero = ', 1);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_all_terminal( $limit, $id ){;
        $this->db->select('*');
        $this->db->from( self::pos_terminal.' as terminal');
        $this->db->join( self::sucursal.' as sucursal',
                                    ' on terminal.Sucursal=sucursal.id_sucursal' );
        $this->db->where('sucursal.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        $this->db->where('sucursal.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->from( self::pos_terminal.' as terminal');
        $this->db->join( self::sucursal.' as sucursal',
                                    ' on terminal.Sucursal=sucursal.id_sucursal' );
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear( $data ){
        $this->db->insert( self::pos_terminal , $data );
    }

    function get_terminal( $terminal_id ){
        $this->db->where('t.id_terminal', $terminal_id );
        $this->db->from( self::pos_terminal.' as t');
        $query = $this->db->get();
        return $query->result();
    }

    function update( $data ){
        $this->db->where('id_terminal' , $data['id_terminal']);
        $this->db->update( self::pos_terminal , $data );
    }

    function eliminar( $id ) {
        $this->db->where('id_terminal' , $id );
        $this->db->delete( self::pos_terminal );   
    }
}