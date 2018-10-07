<?php
class Login_model extends CI_Model {

        const users = 'core_usuario';
        const user_db = 'core_db_usuario';
        const db = 'core_system_information';
        
        public function login( $usuario , $passwd )
        {   
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