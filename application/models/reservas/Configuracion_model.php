<?php
class Configuracion_model extends CI_Model {

    const configuracion = "reserva_configuracion";
    const sucursal = 'pos_sucursal';

    function get_configuracion($param){
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

    function get_configuracion_externa($param,$empresa){
        $this->db->select('valor_configuracion');
        $this->db->from( self::configuracion.' as config');
        $this->db->join(self::sucursal.' as sucursal',' on sucursal.id_sucursal = config.Sucursal');
        $this->db->where('nombre_configuracion', $param);
        $this->db->where('Empresa_Suc', $empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}