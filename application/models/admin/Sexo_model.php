<?php
class Sexo_model extends CI_Model {
	
	const sys_sexo = 'sys_sexo';	
	
	function getSexo(){

		$this->db->select('*');
        $this->db->from(self::sys_sexo);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}