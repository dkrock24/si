<?php
class Login_model extends CI_Model {

		const users = 'sr_usuarios';

        public $title;
        public $content;
        public $date;

        public function login()
        {   
            $query = $this->db->get('sr_usuarios', 10);
            //var_dump($query->sr_roles);
        	return $query->result();
        }
}

?>