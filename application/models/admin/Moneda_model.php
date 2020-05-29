<?php
class Moneda_model extends CI_Model {
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const persona = 'sys_persona';
    const usuario_roles = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa = 'pos_empresa';
    const sys_moneda = 'sys_moneda';

    function getMoneda(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::sys_moneda);
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllMoneda(){
        $this->db->select('*');
        $this->db->from(self::sys_moneda);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_modena_by_user(){
        $this->db->select('*');
        $this->db->from(self::sys_moneda.' as m');
        $this->db->from(self::pos_empresa.' as e','on e.Moneda = m.id_moneda');
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::sys_moneda);
    }

    function save($moneda){

        $data = array(
            'moneda_nombre' => $moneda['moneda_nombre'],
            'moneda_simbolo' => $moneda['moneda_simbolo'],
            'moneda_estado' => $moneda['moneda_estado'],
            'moneda_alias' => $moneda['moneda_alias']
        );
        $result = $this->db->insert(self::sys_moneda, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
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
        $result =  $this->db->update(self::sys_moneda, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar( $id ){
        
        $data = array(
            'id_moneda' => $id
        );

        $this->db->where('id_moneda', $id);
        $result =  $this->db->delete(self::sys_moneda, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

}
