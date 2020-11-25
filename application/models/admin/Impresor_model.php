<?php
class Impresor_model extends CI_Model {
	const empleado  =  'sys_empleado';
    const sucursal  = 'pos_sucursal';
    const persona   = 'sys_persona';
    const usuario_roles     = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa       = 'pos_empresa';
    const pos_impresor        = 'pos_impresor';
    const pos_orden_estado  = 'pos_orden_estado';

    function get_impresor(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::pos_impresor);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = pos_impresor.impresor_estado');
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

    function get_all_impresor(){
        $this->db->select('*');
        $this->db->from(self::pos_impresor);
        $this->db->where('impresor_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_impresor_empresa(){
        $this->db->select('*');
        $this->db->from(self::pos_impresor.' as i');
        $this->db->join(self::pos_empresa.' as e','on e.id_empresa = i.impresor_empresa');
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::pos_impresor);
    }

    function save($impresor){

        $data = $impresor;
        $data['impresor_empresa'] = $this->session->empresa[0]->id_empresa;

        $result = $this->db->insert(self::pos_impresor, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function get_impresor_id( $impresor_id ){
        $this->db->select('*');
        $this->db->from(self::pos_impresor);
        $this->db->where('id_impresor', $impresor_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($impresor){

        $data = $impresor;

        $this->db->where('id_impresor', $impresor['id_impresor'] );
        $result =  $this->db->update(self::pos_impresor, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar( $id ){
        
        $data = array(
            'id_impresor' => $id
        );

        $this->db->where('id_impresor', $id);
        $result =  $this->db->delete(self::pos_impresor, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

}
