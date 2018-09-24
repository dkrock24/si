<?php
class Login_model extends CI_Model {

        const users = 'sr_usuarios';
        
        public function login( $usuario , $passwd )
        {   
            $this->load->model('admin/Encrypt_model', 'admin');
            $pass = $this->admin->encrypt($passwd);

            $this->db->select('*');
            $this->db->from(self::users);
            $this->db->where('usuario',$usuario);    
            $this->db->where('password',$pass);   
            $query = $this->db->get();  
            
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