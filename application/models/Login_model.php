<?php
class Login_model extends CI_Model {

    /* definicion de las tablas existentes en la BD que almacena los parametros
    /  globales de inicio de session y la que se encarga hacia donde tiene que 
    /  autenticarlo
    */
        const users = 'core_usuario';
        const user_db = 'core_db_usuario';
        const db = 'core_system_information';


        const sys_usuario = 'sys_usuario';
        const sys_role = 'sys_role';
        const sys_empleado = 'sys_empleado';
        
        public function login( $usuario , $passwd )
        {   
            // hacemos la llamada a la BD por defecto que valida el usuario y empresa
            $db = $this->load->database('client', TRUE);
            $this->load->model('admin/Encrypt_model', 'admin');
            $pass = $this->admin->encrypt($passwd);

            $db->select('*');
            $db->from(self::users);
            $db->join(self::user_db,' on '. self::users .'.id_usu = '. self::user_db.'.id_usuario');
            $db->join(self::db,' on '. self::user_db .'.id_db = '. self::db.'.id');
            $db->where(self::users.'.nombre_usu',$usuario);    
            $db->where(self::users.'.password_usu',$pass);   
            $query = $db->get(); 
            //echo $db->queries[0];
            
            if($query->num_rows() > 0 ){
     
                return $query->result();
            }else{
 
                return 0;
            } 
        }
        public function autenticacion( $usuario , $passwd ){

            $db = $this->load->database('default', TRUE);
            $this->load->model('admin/Encrypt_model', 'admin');
            $pass = $this->admin->encrypt($passwd);

            $db->select('*');
            $db->from(self::sys_usuario);
            $db->join(self::sys_empleado,' on '. self::sys_empleado .'.id_empleado = '. self::sys_usuario.'.Empleado');
            $db->where(self::sys_usuario.'.nombre_usuario',$usuario);    
            $db->where(self::sys_usuario.'.contrasena_usuario',$passwd);   
            $query = $db->get(); 
            //echo $db->queries[0];
            
            if($query->num_rows() > 0 ){
     
                return $query->result();
            }else{
 
                return 0;
            } 
        }
        public function usuarios()
        {   
           
            $this->db->select('*');
            $this->db->from(self::users); 
            $query = $this->db->get();  
            
            if($query->num_rows() > 0 ){
                return $query->result();
            }else{
                return 0;
            } 
        }
}
?>