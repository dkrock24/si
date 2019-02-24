<?php
class Ciudad_model extends CI_Model {
	
	const sys_pais = 'sys_pais';	
    const sys_departamento = 'sys_departamento';
    const sys_ciudad = 'sys_ciudad';
	
	function getCiudad(){

		$this->db->select('*');
        $this->db->from(self::sys_pais.' as p');
        $this->db->join(self::sys_departamento.' as d', 'on p.Ciudad = d.id_ciudad');
        $this->db->join(self::sys_ciudad.' as c', 'on d.Sexo = c.id_sexo');
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}