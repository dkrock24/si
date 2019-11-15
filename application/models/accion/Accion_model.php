<?php
class Accion_model extends CI_Model {

	/*
	|  Este modelo contiene toda la logica de acciones para cada pantalla
	|*/

	const vistas =  'sys_vistas';
    const sys_vistas_componentes = 'sys_vistas_componentes';
    const vista_acceso = 'sys_vistas_acceso';
	const sys_componentes =  'sys_componentes';    

	function get_vistas_acciones( $vista_id , $role_id ){

		$this->db->select('*');
        $this->db->from(self::vistas.' as v');
        $this->db->join(self::sys_vistas_componentes.' as vc ',' on v.id_vista = vc.Vista');
        $this->db->join(self::sys_componentes.' as c ',' on c.id_vista_componente = vc.Componente');
        $this->db->join(self::vista_acceso.' as va ',' on va.id_vista_componente = vc.id');
        $this->db->where('vc.vista_componente_estado =1');
        //$this->db->where('va.vista_acceso_estado = 1');
        $this->db->where('c.accion_estado = 1');
        $this->db->where('v.id_vista = ',$vista_id);
        $this->db->where('va.id_role = '. $role_id);
        $this->db->order_by('vc.order','asc');
        $query = $this->db->get(); 
        //echo $this->db->queries[4];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}