<?php
class Login_model extends CI_Model {

        const users = 'sys_persona_usuario';
        
        public function login( $usuario , $passwd )
        {   
            $this->load->model('admin/Encrypt_model', 'admin');
            $pass = $this->admin->encrypt($passwd);

            $this->db->select('*');
            $this->db->from(self::users);
            $this->db->where('NOMBRE_USUARIO',$usuario);    
            //$this->db->where('CONTRASENA_USUARIO',$pass);   
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