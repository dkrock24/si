<?php
class Configuracion_model extends CI_Model {

    const configuracion = "reserva_configuracion";

    function get_configuracion($empresa){;
        $this->db->select('*');
        $this->db->from( self::configuracion );
        $this->db->where('empresa_nombre', $empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}