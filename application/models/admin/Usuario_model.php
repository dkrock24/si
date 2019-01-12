<?php
class Usuario_model extends CI_Model {
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const persona = 'sys_persona';

	function get_empleado( $id_usuario ){
		$this->db->select('*');
        $this->db->from(self::empleado);
        $this->db->join(self::sucursal,' on '.self::empleado.'.Sucursal='.self::sucursal.'.id_sucursal');
        $this->db->join(self::persona,' on '.self::persona.'.id_persona='.self::empleado.'.Persona_E');

        $this->db->where(self::empleado.'.Persona_E = ', $id_usuario);
        $this->db->where(self::empleado.'.estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_empleados_by_sucursal( $sucursal ){
        $this->db->select('*');
        $this->db->from(self::empleado);
        $this->db->join(self::sucursal,' on '.self::empleado.'.Sucursal='.self::sucursal.'.id_sucursal');
        $this->db->join(self::persona,' on '.self::persona.'.id_persona='.self::empleado.'.Persona_E');

        $this->db->where(self::empleado.'.Sucursal = ', $sucursal);
        $this->db->where(self::empleado.'.estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}