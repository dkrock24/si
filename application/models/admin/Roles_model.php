<?php
class Roles_model extends CI_Model {

    const menu = 'sys_menu';
    const submenu = 'sys_menu_submenu';
    const empresa = 'sys_empresa';
    const usuarios = 'sr_usuarios';    
    const roles = 'sys_role';
    const cargos = 'sr_cargos';


    function getRoles($limit, $id){

        $this->db->select('*');
        $this->db->from(self::roles);  
        $this->db->limit($limit, $id);          
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        return $this->db->count_all(self::roles);
    }

    function getRolesById( $id_role ){

        $this->db->select('*');
        $this->db->from(self::roles);   
        $this->db->where('id_rol', $id_role );    
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
        $this->db->where('id_rol', $roles['role_id']);
        $this->db->update(self::roles, $data);  
    }

    function nuevo_rol( $nuevo_rol ){

        $data = array(
           'role' => $nuevo_rol['role'],
            'pagina' => $nuevo_rol['pagina'],
            'fecha_actualizacion' => date('Y-m-d'),
            'estado_rol' => $nuevo_rol['estado_rol'],
        );

        $this->db->insert(self::roles, $data );

        $ultimo_id = $this->db->insert_id();

        $query = "select distinct id_submenu from sys_menu_submenu";
        $query = $this->db->query($query);  
        $data_menu = $query->result_array(); 

        foreach ($data_menu as $value) {
            $a = $value['id_submenu'];
            $inset_acceso = "insert into sys_submenu_acceso (id_submenu,id_role,submenu_acceso_estado)
            values($a,$ultimo_id,0)";
            $this->db->query($inset_acceso);
        } 
    }

    function delete_rol( $role_id ){

        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete('sys_menu_acceso', $data);
        
        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete(self::roles, $data);

        

        return 1;
    }
}

?>