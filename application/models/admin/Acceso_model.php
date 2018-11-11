<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Acceso_model extends CI_Model
{
    const libreria = 'sys_librerias';
    const configuracion = 'sys_config';
    const menu = 'sys_menu';
    const empresa = 'sys_empresa';
    const usuarios = 'sys_usuarios';    
    const roles = 'sys_role';
    const cargos = 'sys_cargos';

    
    

    
    public function __construct()
    {
        parent::__construct();
        
    }
    //Actualizar Roles
    public function updateRol()
    {
        $data = array(
            'nombre_rol' => $_POST['nombre']
        );
        $this->db->where('id_rol', $_POST['id_rol']);
        $this->db->update(self::roles, $data);   
        //echo $this->db->queries[0];   
    }
    //Delete Rol
    public function deleteRol()
    {
        $data = array(
            'id_rol' => $_POST['id_rol']
        );
        $this->db->delete(self::roles, $data);  
        //echo $this->db->queries[0];   
    }

    //Actualizar Cargos
    public function updateCargo()
    {
        $data = array(
            'nombre_cargo' => $_POST['nombre']
        );
        $this->db->where('id_cargo', $_POST['id_cargo']);
        $this->db->update(self::cargos, $data);   
        //echo $this->db->queries[0];   
    }

    //Delete Cargos
    public function deleteCargo()
    {
        $data = array(
            'id_cargo' => $_POST['id_cargo']
        );
        $this->db->delete(self::cargos, $data);  
        //echo $this->db->queries[0];   
    }


    public function getAccesoRol($data)
    {
        $this->db->select('*');
        $this->db->from(self::roles);
        $this->db->where('pages_config',$location);
        $this->db->where('estado_config',1);        
        $query = $this->db->get();         
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }         
    }
    public function get_menu_acceso($rol)
    {
        $this->db->select('*');
        $this->db->from(self::menu);
        $this->db->join('sys_menu_acceso as A','on '. self::menu .'.id_menu = A.id_menu');
        $this->db->join('sys_role as R','on R.id_rol = A.id_rol');
        //$this->db->join('sr_submenu as S','on '. self::menu .'.id_menu = S.id_menu');
        $this->db->where('R.id_rol',$rol);        
        //$this->db->where('A.estado',1);     
        //$this->db->where('A.estado',1); 
        $query = $this->db->get();      
        //echo $this->db->queries[0];   
        //exit();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }         
    }

    // Actualizar el Accesos Para el  Rol
    public function update_acceso_menu( $datos ){

        $accesos_rol = $this->get_access_by_rol( $datos['id_rol'] );

            foreach ($accesos_rol as $ac) 
            {
                
                if( array_key_exists( $ac->id_menu, $datos ) ){
                    $data = array('estado' => 1 );
                    
                    $this->db->where('id_rol', $datos['id_rol']);
                    $this->db->where('id_menu', $ac->id_menu );
                    $this->db->update('sys_menu_acceso', $data);

                }else{
                    $data = array('estado' => 0 );
                    $this->db->where('id_rol', $datos['id_rol']);
                    $this->db->where('id_menu', $ac->id_menu );
                    $this->db->update('sys_menu_acceso', $data);
                }
            }
               
    }

    // Obtener Los Accesos Por Rol
    public function get_access_by_rol( $id_rol ){
        $this->db->select('*');
        $this->db->from('sys_menu_acceso as a');
        $this->db->where('a.id_rol ='.$id_rol) ;
        $query = $this->db->get();      
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }  
    }

    public function getMenu()
    {
        $this->db->select('*');
        $this->db->from(self::menu); 
        $query = $this->db->get();      
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }         
    }
    public function getRoles()
    {
        $this->db->select('*');
        $this->db->from(self::roles); 
        $query = $this->db->get();      
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }         
    }
    public function getCargos()
    {
        $this->db->select('*');
        $this->db->from(self::cargos); 
        $query = $this->db->get();      
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }         
    }
    public function login($usuario,$password)
    {
        $pass = $this->encrypt($password);
        $this->db->select('*');
        $this->db->from(self::usuarios); 
        $this->db->where('usuario',$usuario);    
        $this->db->where('password',$pass);   
        $query = $this->db->get();            
        //echo $this->db->queries[0];   
        //exit(); 
          
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }  
        else{
            return 0;
        }       
    }
}
/*
 * end of application/models/consultas_model.php
 */
