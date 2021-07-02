<?php
class Nodos_model extends CI_Model {

    const nodos = 'pos_ordenes_nodos';
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const pos_empresa = 'pos_empresa';
    const pos_orden_estado = 'pos_orden_estado';

    function getMoneda(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::nodos);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = nodo.nodo_estado');
        
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

    function update($moneda){

        $data = array(
            'moneda_nombre' => $moneda['moneda_nombre'],
            'moneda_simbolo' => $moneda['moneda_simbolo'],
            'moneda_estado' => $moneda['moneda_estado'],
            'moneda_alias' => $moneda['moneda_alias']
        );
        $this->db->where('id_moneda', $moneda['id_moneda'] );
        $result =  $this->db->update(self::nodos, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar( $nodo ){
        
        $data = array(
            'id_nodo' => $nodo
        );

        $this->db->where('id_moneda', $nodo);
        $result =  $this->db->delete(self::nodos, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
