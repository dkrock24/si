<?php
class Caja_model extends CI_Model {

	const pos_terminal = 'pos_terminal';
    const sucursal = "pos_sucursal";
    const caja = "pos_caja";
    const empresa = "pos_empresa";
    const pos_terminal_cajero = 'pos_terminal_cajero';

    function get_all_caja( $limit, $id ){;
        $this->db->select('*');
        $this->db->from( self::caja.' as c');
        $this->db->join( self::empresa.' as e',
                                    ' on c.Empresa=e.id_empresa' );
        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function crear_caja($caja){

        $result = $this->db->insert(self::caja, $caja);  
        return $result;
    }

    function get_caja($caja_id){
    	$this->db->select('*');
        $this->db->from( self::caja.' as c');
        $this->db->join( self::empresa.' as e',
                                    ' on c.Empresa=e.id_empresa' );
        $this->db->where('c.id_caja', $caja_id );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_caja_empresa(){
        $this->db->select('*');
        $this->db->from( self::caja.' as c');
        $this->db->join( self::empresa.' as e',' on c.Empresa=e.id_empresa' );
        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update_caja($caja){

    	$this->db->where('id_caja', $caja['id_caja']);  
    	$result = $this->db->update(self::caja, $caja);  
        return $result;
    }


	function record_count(){
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->from( self::caja.' as terminal');
        //$this->db->join( self::sucursal.' as sucursal',
          //                          ' on terminal.Sucursal=sucursal.id_sucursal' );
        $result = $this->db->count_all_results();
        return $result;
    }

}