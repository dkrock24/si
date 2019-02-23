<?php
class Sucursal_model extends CI_Model {

	const pos_sucursal = 'pos_sucursal';
	const pos_empresa = 'pos_empresa';	
	const sys_empleado_sucursal = 'sys_empleado_sucursal';	
	
	function getSucursal(){
		$this->db->select('*');
        $this->db->from(self::pos_sucursal.' as b');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

}