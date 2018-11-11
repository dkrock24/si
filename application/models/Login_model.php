<?php
class Login_model extends CI_Model {

        const sys_usuario = 'sys_usuario';
        const sys_role = 'sys_role';
        const sys_empleado = 'sys_empleado';
        
        public function login( $usuario , $passwd )
        {   
            $db = $this->load->database('default', TRUE);
            $this->load->model('admin/Encrypt_model', 'admin');
            $pass = $this->admin->encrypt($passwd);

            $db->select('*');
            $db->from(self::sys_usuario);
            $db->join(self::sys_role,' on '. self::sys_usuario .'.id_rol = '. self::sys_role.'.id_rol');
            $db->join(self::sys_empleado,' on '. self::sys_empleado .'.id_empleado = '. self::sys_usuario.'.Empleado');
            $db->where(self::sys_usuario.'.nombre_usuario',$usuario);    
            $db->where(self::sys_usuario.'.contrasena_usuario',$pass);   
            $query = $db->get(); 
            //echo $db->queries[0];
            
        	if($query->num_rows() > 0 ){
     
                return $query->result();
            }else{
 
                return 0;
            } 
        }

        public function autenticacion( $usuario , $passwd ){
            $this->load->database();
            //var_dump($db);

            $this->db->select('*');
            $this->db->from('sys_persona_usuario');   
            $this->db->where('nombre_usu',$usuario);    
            $this->db->where('password_usu',$passwd); 
            $query = $this->db->get(); 
            //echo $this->db->queries[0];
            
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