<?php
class Menu_model extends CI_Model {

    const menu      = 'sys_menu';
    const menu2      = 'sys_menu2';
    const submenu   = 'sys_menu_submenu';
    const submenu2  = 'sys_menu_submenu2';
    const empresa   = 'sys_empresa';
    const usuarios  = 'sr_usuarios';    
    const roles     = 'sys_roles';
    const cargos    = 'sr_cargos';
    const sys_menu_submenu = 'sys_menu_submenu';
    const submenu_acceso = 'sys_submenu_acceso';
    const submenu_acceso2 = 'sys_submenu_acceso2';
    const sys_menu = 'sys_menu';
    const sys_vistas = 'sys_vistas';


    function getMenu( $roles_id ){

        $this->db->select('*');
        $this->db->from(self::submenu_acceso .' as sma');
        $this->db->join(self::sys_menu_submenu .' as sm ',' on sm.id_submenu = sma.id_submenu');
        $this->db->join(self::sys_menu .' as m ',' on m.id_menu = sm.id_menu');
        $this->db->where_in('sma.id_role',$roles_id);
        $this->db->where('sma.submenu_acceso_estado',1); 
        $this->db->order_by('m.orden_menu , sm.nombre_submenu','asc');
        $query = $this->db->get();
        //echo $this->db->queries[1]; 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function lista_menu( ){

        $this->db->select('*');
        $this->db->from(self::menu);       
        $query = $this->db->get(); 
        //echo $this->db->queries[1];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getSubMenu( $id_menu ){

        $this->db->select('*');
        $this->db->from(self::menu);       
        $this->db->join('sys_menu_submenu as S','on '. self::menu .'.id_menu = S.id_menu');       
        $this->db->join('sys_vistas as V','on V.id_vista = S.id_vista');
        $this->db->where(self::menu.'.id_menu',$id_menu );     
        //$this->db->where('S.estado_submen',1);
        //$this->db->where('S.estado_referencia',null);
        $query = $this->db->get();    
        //echo $this->db->queries[2];
  
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

    function getOneSubMenu( $id_sub_menu ){

        $this->db->select('*');
        $this->db->from(self::submenu);
        $this->db->join('sys_vistas as V','on V.id_vista = '.self::sys_menu_submenu.'.id_vista');     
        $this->db->where('id_submenu',$id_sub_menu );             
        $query = $this->db->get();    
        //echo $this->db->queries[2];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllMenu( ){

        $this->db->select('*');
        $this->db->from(self::menu);                 
        $query = $this->db->get();    
                        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function update_menu( $menu ){
        $data = array(
           'nombre_menu' => $menu['nombre_menu'],
            'url_menu' => $menu['url_menu'],
            'icon_menu' => $menu['icon_menu'],
            'class_menu' => $menu['class_menu'],
            'id_rol_menu' => 1,
            'estado_menu' => $menu['estado_menu']
        );
        $this->db->where('id_menu', $menu['id_menu']);
        $result = $this->db->update(self::menu, $data);  

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    public function update_sub_menu($submenu)
    {
        $data = array(
            'nombre_submenu'    => $submenu['nombre_submenu'],
            'url_submenu'       => $submenu['url_submenu'],
            'titulo_submenu'    => $submenu['titulo_submenu'],
            'icon_submenu'         => $submenu['icon_submenu'],
            'id_menu'           => $submenu['id_menu'],            
            'id_vista'           => $submenu['vista'],            
            'estado_submen'     => $submenu['estado_menu']            
        );
        $this->db->where('id_submenu', $submenu['id_submenu']);
        $result = $this->db->update(self::submenu, $data);   

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function save_menu( $data ){

        $orden_menu = $this->get_last_menu();

        $data = array(
            'nombre_menu' => $data['nombre_menu'],
            'url_menu' => $data['url_menu'],
            'icon_menu' =>  $data['icon_menu'],
            'class_menu' => $data['class_menu'],
            'id_rol_menu' => 1,
            'orden_menu' => $orden_menu[0]['orden_menu'],
            'estado_menu' => $data['estado_menu']
        );
        $result = $this->db->insert(self::menu, $data );

        $ultimo_id = $this->db->insert_id();

        $query = "select distinct id_rol from sys_role";
        $query = $this->db->query($query);  
        $data_roles = $query->result_array(); 

        foreach ($data_roles as $value) {
            $a = $value['id_rol'];
            $inset_acceso = "insert into sys_menu_acceso (id_rol,id_menu,id_usuario,estado)
            values($a,$ultimo_id,0,0)";
            $this->db->query($inset_acceso);
        }   
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function get_last_menu(){
        $query =  "SELECT * FROM sys_menu ORDER by id_menu  DESC LIMIT 1";
        $query = $this->db->query($query);  
        $data = $query->result_array(); 
        return $data;
    }

    function delete_menu( $menu_id ){

        $data = array(
            'id_menu' => $menu_id
        );
        $this->db->delete('sys_menu_acceso', $data);
        
        $data = array(
            'id_menu' => $menu_id
        );
        $this->db->delete(self::menu, $data);

        return 1;
    }

    function save_sub_menu( $submenu ){

        $data = array(
            'nombre_submenu'    => $submenu['nombre_submenu'],
            'url_submenu'       => $submenu['url_submenu'],
            'titulo_submenu'    => $submenu['titulo_submenu'],
            'icon_submenu'      => $submenu['icon_submenu'],
            'id_menu'           => $submenu['id_menu'],     
            'id_vista'           => $submenu['vista'],           
            'estado_submen'     => $submenu['estado_menu']            
        );
        $result = $this->db->insert('sys_menu_submenu', $data ); 

        $ultimo_id = $this->db->insert_id();

        $query = "select distinct id_rol from sys_role";
        $query = $this->db->query($query);  
        $data_roles = $query->result_array(); 

        foreach ($data_roles as $value) {
            $a = $value['id_rol'];
            $inset_acceso = "insert into sys_submenu_acceso (id_submenu,id_role,submenu_acceso_estado)
            values($ultimo_id,$a,0)";
            $this->db->query($inset_acceso);
        }   

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function delete_sub_menu( $id_sub_menu ){


        $data = array(
            'id_submenu' => $id_sub_menu
        );
        
        $this->db->delete('sys_submenu_acceso', $data);

        $this->db->delete('sys_menu_submenu', $data);

        return 1;
    }

    function insert_api($menus)
    {
        $this->db->truncate(self::menu2);

        $data = [];
        foreach ($menus as $key => $menu) {
            $data[] = $menu;
        }
        $this->db->insert_batch(self::menu2, $data);
    }

    function insert_submenu_api($sub_menus)
    {
        $this->db->truncate(self::submenu2);

        $data = [];
        foreach ($sub_menus as $key => $submenu) {
            $data[] = $submenu;
        }
        $this->db->insert_batch(self::submenu2, $data);
    }

    function insert_acceso_api($accesos)
    {
        $this->db->truncate(self::submenu_acceso2);

        $data = [];
        foreach ($accesos as $key => $acceso) {
            $data[] = $acceso;
        }
        $this->db->insert_batch(self::submenu_acceso2, $data);
    }    
}

?>