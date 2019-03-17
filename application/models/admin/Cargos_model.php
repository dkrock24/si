<?php
class Cargos_model extends CI_Model {
	
	const sys_persona = 'sys_persona';	
    const sys_empleado = 'sys_empleado';  
    const sys_cargo_laboral = 'sys_cargo_laboral';
	
	function get_cargos(){

		$this->db->select('*');
        $this->db->from(self::sys_cargo_laboral.' as p');
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}