<?php
class Dashboard_model extends CI_Model
{
    const caja      = 'pos_caja';
    const ventas    = 'pos_ventas';
    const ordenes   = 'pos_ordenes';
    const sucursal  = 'pos_sucursal';
    const terminal  = 'pos_terminal';
    const sys_login = 'sys_login';
    const usuario   = 'sys_usuario';
    const rol       = 'sys_role';
    const caja_terminal = 'pos_terminal_cajero';

    public function total_ordenes()
    {
        $this->fecha = date("Y-m-d");
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->from( self::ordenes.' as o');
        $this->db->join( self::sucursal.' as s', 'o.id_sucursal = s.id_sucursal');
        $this->db->where('fecha_inglab', date('Y-m-d'));

        $result = $this->db->count_all_results();
        return $result;

    }

    public function total_ventas(){
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->where('DATE(v.creado_el)', date('Y-m-d'));
        $this->db->from( self::ventas.' as v');
        $this->db->join( self::sucursal.' as s', 'v.id_sucursal = s.id_sucursal');

        $result = $this->db->count_all_results();

        return $result;
    }

    public function terminal_caja(){

        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->where('tc.activa',1);
        $this->db->from( self::terminal.' as t');
        $this->db->join( self::caja_terminal.' as tc', ' on  t.id_terminal = tc.Terminal');
        $this->db->join( self::sucursal .' as s', ' on s.id_sucursal = t.Sucursal');
        $result = $this->db->count_all_results();
        return $result;

    }

    public function usuarios_actividad()
    {
        $this->db->select('*');
        $this->db->from( self::sys_login.' as l');
        $this->db->join( self::usuario.' as u', ' on  l.id_usuario = u.id_usuario');
        $this->db->join( self::sucursal .' as s', ' on s.id_sucursal = l.id_sucursal');
        $this->db->join( self::rol .' as r', ' on r.id_rol = u.id_rol');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->limit(100);
        $this->db->order_by('l.id_login', 'desc');
        $result = $this->db->get();
        return $result->result();
    }

    public function ordenes_mes()
    {
        $this->db->select('count(*) as total');
        $this->db->from( self::ordenes.' as o');
        $this->db->join( self::sucursal .' as s', ' on s.id_sucursal = o.id_sucursal');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->where('o.fecha_inglab BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()');
        $this->db->group_by('o.fecha_inglab');
        $this->db->order_by('o.fecha_inglab', 'desc');
        $result = $this->db->get();
        return $result->result();
    }

}
