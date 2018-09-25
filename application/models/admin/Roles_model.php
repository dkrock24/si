<?php
class Roles_model extends CI_Model {

    const menu = 'sys_menu';
    const submenu = 'sys_menu_submenu';
    const empresa = 'sys_empresa';
    const usuarios = 'sr_usuarios';    
    const roles = 'sys_role';
    const cargos = 'sr_cargos';


    function getRoles(){

        $this->db->select('*');
        $this->db->from(self::roles);            
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getRolesById( $id_role ){

        $this->db->select('*');
        $this->db->from(self::roles);   
        $this->db->where('role_id', $id_role );    
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function setRoles( $roles ){

        $data = array(
           'role' => $roles['role'],
            'pagina' => $roles['pagina'],
            'fecha_actualizacion' => date('Y-m-d'),
            'estado_rol' => $roles['estado_rol'],
        );
        $this->db->where('role_id', $roles['role_id']);
        $this->db->update(self::roles, $data);  
    }

    
    
}

?>