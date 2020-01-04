<?php
class Ciudad_model extends CI_Model {
	
	const sys_pais = 'sys_pais';	
    const sys_departamento = 'sys_departamento';
    const sys_ciudad = 'sys_ciudad';
	
	function getCiudad(){

		$this->db->select('*');
        $this->db->from(self::sys_pais.' as p');
        $this->db->join(self::sys_departamento.' as d', 'on p.id_pais = d.pais');
        $this->db->join(self::sys_ciudad.' as c', 'on c.departamento = d.id_departamento');
        $this->db->order_by('d.nombre_departamento', 'asc');
        
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function getCiudadId( $departamento_id ){
        $this->db->select('*');        
        $this->db->from(self::sys_ciudad);
        $this->db->where('departamento', $departamento_id);
        
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getDepartamento( ){
        $this->db->select('*');        
        $this->db->from(self::sys_departamento);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}