<?php
class Moneda_model extends CI_Model {
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const persona = 'sys_persona';
    const usuario_roles = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa = 'pos_empresa';
    const sys_moneda = 'sys_moneda';

    function getMoneda(){
    	$this->db->select('*');
        $this->db->from(self::sys_moneda);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function save($moneda){

        $data = array(
            'moneda_nombre' => $moneda['moneda_nombre'],
            'moneda_simbolo' => $moneda['moneda_simbolo'],
            'moneda_estado' => $moneda['moneda_estado'],
            'moneda_alias' => $moneda['moneda_alias']
        );
        $this->db->insert(self::sys_moneda, $data ); 
    }

    function getMonedaId( $moneda_id ){
        $this->db->select('*');
        $this->db->from(self::sys_moneda);
        $this->db->where('id_moneda', $moneda_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($moneda){

        $data = array(
            'moneda_nombre' => $moneda['moneda_nombre'],
            'moneda_simbolo' => $moneda['moneda_simbolo'],
            'moneda_estado' => $moneda['moneda_estado'],
            'moneda_alias' => $moneda['moneda_alias']
        );
        $this->db->where('id_moneda', $moneda['id_moneda'] );
        $this->db->update(self::sys_moneda, $data ); 
    }

}
