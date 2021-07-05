<?php
class Nodos_model extends CI_Model {

    const nodos = 'pos_ordenes_nodos';
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const pos_empresa = 'pos_empresa';
    const pos_orden_estado = 'pos_orden_estado';

    function getNodos(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::nodos.' as nodo');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = nodo.nodo_estado');
        $this->db->join(self::sucursal.' as s', 'on s.id_sucursal = nodo.Sucursal');
        
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllNodos(){
        $this->db->select('*');
        $this->db->from(self::nodos);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::nodos);
    }

    function save($nodo){

        $nodo['nodo_key'] = md5(microtime().rand());

        $result = $this->db->insert(self::nodos, $nodo ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getNodoId( $nodo ){
        $this->db->select('*');
        $this->db->from(self::nodos);
        $this->db->where('id_nodo', $nodo );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($nodo){

        $nodoId = $nodo['id_nodo'];
        unset($nodo['id_nodo']);
        
        $this->db->where('id_nodo', $nodoId );
        $result =  $this->db->update(self::nodos, $nodo ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar( $nodo ){
        
        $data = array(
            'id_nodo' => $nodo
        );

        $this->db->where('id_nodo', $nodo);
        $result =  $this->db->delete(self::nodos, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
