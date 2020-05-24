<?php
class Estados_model extends CI_Model
{
    const estados =  'pos_orden_estado';

    function get_estados()
	{
		$this->db->select('*');
		$this->db->from(self::estados);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
    }
}