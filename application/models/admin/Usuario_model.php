<?php
class Usuario_model extends CI_Model {
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const persona = 'sys_persona';
    const usuario_roles = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa = 'pos_empresa';

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

    function get_usuario_roles( $usuario_id ){

        $this->db->select('*');
        $this->db->from(self::usuario_roles);  
        $this->db->where(self::usuario_roles.'.usuario_rol_usuario',$usuario_id);   
        $query = $this->db->get(); 
        //echo $this->->queries[0];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function permiso_empresa( $empleado_id ){

        $this->db->select('*');
        $this->db->from(self::empleado_sucursal.' as es');  
        $this->db->join(self::sucursal.' as s',' on s.id_sucursal = es.es_sucursal');
        $this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->where('es.es_empleado',$empleado_id);
        $this->db->group_by('e.id_empresa');
        $query = $this->db->get(); 
        //echo $this->db->queries[2];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}