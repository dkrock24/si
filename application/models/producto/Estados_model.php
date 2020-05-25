<?php
class Estados_model extends CI_Model
{
	const estados 	= 'pos_orden_estado';
	const vistas 	= 'sys_vistas';
	const vistas_estados = 'sys_estados_vistas';

    function get_estados( )
	{
		$this->db->select('*');
		$this->db->from(self::estados .' as estados');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	function get_estados_vistas( $vista_id )
	{
		$this->db->select('*');
		$this->db->from(self::estados .' as estados');
		$this->db->join(self::vistas_estados .' as ve' , 'estados.id_orden_estado = ve.estado_id');
		$this->db->join(self::vistas .' as v' , ' v.id_vista = ve.vista_id');
		$this->db->where('ve.vista_id' , $vista_id);
		$this->db->order_by('ve.orden_estado_vista' , 'asc');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
    }
}