<?php
class Turnos_model extends CI_Model {

    const turno      = 'pos_turnos';
    
    function getTurnos(){

        $this->db->select('*');
        $this->db->from(self::turno);  
        $this->db->where(self::turno.'.Empresa', $this->session->empresa[0]->id_empresa);  
       
        $query = $this->db->get();
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }
}