<?php
class Menu_model extends CI_Model {

    const menu = 'sys_menu';
    const empresa = 'sys_empresa';
    const usuarios = 'sr_usuarios';    
    const roles = 'sys_roles';
    const cargos = 'sr_cargos';

    function getMenu( $id_rol ){

        $this->db->select('*');
        $this->db->from(self::menu);
        $this->db->join('sys_menu_acceso as A','on '. self::menu .'.id_menu = A.id_menu');
        $this->db->join('sys_role as R','on R.role_id = A.id_rol');
        $this->db->join('sys_menu_submenu as S','on '. self::menu .'.id_menu = S.id_menu');
        $this->db->where('R.role_id',$id_rol);        
        $this->db->where('A.estado',1);     
        $this->db->where('A.estado',1); 
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        //die;   
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getSubMenu( $id_menu ){

        $this->db->select('*');
        $this->db->from(self::menu);       
        $this->db->join('sr_submenu as S','on '. self::menu .'.id_menu = S.id_menu');          
        $this->db->where(self::menu.'.id_menu',$id_menu );     
        $this->db->where('S.estado_submen',1);             
        $query = $this->db->get();    
        echo $this->db->queries[2];
        die;
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getOneMenu( $id_menu ){

        $this->db->select('*');
        $this->db->from(self::menu);
        $this->db->where('id_menu',$id_menu );             
        $query = $this->db->get();    
        //echo $this->db->queries[2];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    
}

?>