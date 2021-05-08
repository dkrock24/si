<?php
class Configuracion_model extends CI_Model {

    const configuracion = "reserva_configuracion";

    function get_configuracion($param){;
        $this->db->select('valor_configuracion');
        $this->db->from( self::configuracion );
        $this->db->where('nombre_configuracion', $param);
        $this->db->where('Sucursal', $this->session->usuario[0]->Sucursal);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}