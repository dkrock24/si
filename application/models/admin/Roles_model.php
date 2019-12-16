<?php
class Roles_model extends CI_Model {

    const menu = 'sys_menu';
    const submenu = 'sys_menu_submenu';
    const sub_men_acceso = 'sys_submenu_acceso';
    const empresa = 'sys_empresa';
    const usuarios = 'sr_usuarios';    
    const roles = 'sys_role';
    const cargos = 'sr_cargos';
    
    
    

    function getRoles($limit, $id , $filters ){

        $this->db->select('*');
        $this->db->from(self::roles);  
        $this->db->where(self::roles.'.Empresa', $this->session->empresa[0]->id_empresa);  
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[2];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllRoles(){

        $this->db->select('*');
        $this->db->from(self::roles);   
        $this->db->where(self::roles.'.Empresa', $this->session->empresa[0]->id_empresa);       
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filter){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::roles);
        $result = $this->db->count_all_results();
        return $result;
    }

    function getRolesById( $id_role ){

        $this->db->select('*');
        $this->db->from(self::roles);   
        $this->db->where('id_rol', $id_role );   
        $this->db->where(self::roles.'.Empresa', $this->session->empresa[0]->id_empresa);   
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
            'Empresa'=> $this->session->empresa[0]->id_empresa,
            'estado_rol' => $nuevo_rol['estado_rol'],
        );

        $result = $this->db->insert(self::roles, $data );

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

        return $result;
    }

    function delete_rol( $role_id ){

        $data = array(
            'id_role' => $role_id
        );
        $result =$this->db->delete('sys_submenu_acceso', $data);

         $data = array(
            'id_rol' => $role_id
        );
        $result = $this->db->delete('sys_menu_acceso', $data);
        
        $data = array(
            'id_rol' => $role_id
        );
        $result = $this->db->delete(self::roles, $data);

        return $result;
    }

    function copiar_rol( $data ){
        
        $rol_nombre = $data['nom_nue_rol'];

        $accesos = $this->getRolAccesos( $data['role_id'] );
    }

    function createRolCopia( $nuevo_rol ){

        $data = array(
            'role' => $nuevo_rol['role'],
            'pagina' => $nuevo_rol['pagina'],
            'fecha_actualizacion' => date('Y-m-d'),
            'Empresa'=> $this->session->empresa[0]->id_empresa,
            'estado_rol' => $nuevo_rol['estado_rol'],
        );

        $result = $this->db->insert(self::roles, $data );

        $ultimo_id = $this->db->insert_id();

        // Set Mismo Acceso que el Rol copiado
        $this->setAccesosRol( $ultimo_id , $nuevo_rol['role_id'] );
        return $result;
    }

    function setAccesosRol($role_copia , $rol_copiado ){

        $accesos_rol = $this->get_accesos( $rol_copiado );

        foreach ($accesos_rol as $ac) 
        {
            $data = array(
                'id_role' => $role_copia,
                'id_submenu' => $ac->id_submenu,
                'submenu_acceso_estado' => $ac->submenu_acceso_estado
            );
            $this->db->insert(self::sub_men_acceso, $data);
        }
    }

    function get_accesos( $rol_copiado ){

        $this->db->select('*');
        $this->db->from(self::sub_men_acceso .' as sma');
        $this->db->join(self::submenu .' as sm ',' on sm.id_submenu = sma.id_submenu');
        $this->db->join(self::menu .' as m ',' on m.id_menu = sm.id_menu');
        $this->db->join(self::roles .' as r ',' on r.id_rol = sma.id_role');
        $this->db->where('sma.id_role', $rol_copiado );
        $query = $this->db->get();
        //echo $this->db->queries[0];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}

?>