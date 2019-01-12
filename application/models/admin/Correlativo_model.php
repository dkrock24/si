<?php
class Correlativo_model extends CI_Model {

	const correlativos =  'pos_correlativos';
    const empleado =  'sys_empleado';

	function get_correlativo_by_sucursal( $id_usuario ){
		$this->db->select('*');
        $this->db->from(self::correlativos);
        $this->db->join(self::empleado,' on '.self::empleado.'.Sucursal='.self::correlativos.'.Sucursal');
        $this->db->where(self::empleado.'.Persona_E = ', $id_usuario);        
        $this->db->where(self::correlativos.'.estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}