<?php
class Empresa_model extends CI_Model {
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const persona = 'sys_persona';
    const usuario_roles = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa = 'pos_empresa';

	function get_empresa_by_id( $empresa_id ){
		$this->db->select('*');
        $this->db->from(self::pos_empresa);

        $this->db->where(self::pos_empresa.'.id_empresa = ', $empresa_id);
        $this->db->where(self::pos_empresa.'.empresa_estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}