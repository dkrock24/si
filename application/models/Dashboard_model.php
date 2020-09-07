<?php
class Dashboard_model extends CI_Model
{
    const ordenes = 'pos_ordenes';
    const sucursal = 'pos_sucursal';
    const ventas = 'pos_ventas';
    const caja = 'pos_caja';

    public function total_ordenes()
    {

        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->from( self::ordenes.' as o');
        $this->db->join( self::sucursal.' as s', 'o.id_sucursal = s.id_sucursal');

        $result = $this->db->count_all_results();
        return $result;

    }

    function total_ventas(){
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->where('DATE(v.creado_el)', date('Y-m-d'));
        $this->db->from( self::ventas.' as v');
        $this->db->join( self::sucursal.' as s', 'v.id_sucursal = s.id_sucursal');

        $result = $this->db->count_all_results();

        return $result;
    }

    function terminal_caja(){

        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->where('c.activa',1);
        $this->db->from( self::caja.' as c');
        $result = $this->db->count_all_results();
        return $result;

    }

}
