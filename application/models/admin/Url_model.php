<?php
class Url_model extends CI_Model
{
    const sys_menu_submenu = 'sys_menu_submenu';
    const submenu_acceso = 'sys_submenu_acceso';
    const sys_menu = 'sys_menu';     


    function acceso_url( $role_id )
    {
        $this->db->select('*');
        $this->db->from(self::empleado_sucursal.' as es');  
        $this->db->join(self::sucursal.' as s',' on s.id_sucursal = es.es_sucursal');
        $this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->where('es.es_empleado',$empleado_id);
        $this->db->group_by('e.id_empresa');
        $query = $this->db->get(); 
        //echo $this->db->queries[2];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}