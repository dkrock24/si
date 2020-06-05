<?php
class Linea_model extends CI_Model {

	const pos_linea = 'pos_linea';
	
	function getLinea( $limit, $id , $filters ){

		$this->db->select('*');
        $this->db->from(self::pos_linea);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa );
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

    function getAllLinea(  ){
        $this->db->select('*');
        $this->db->from(self::pos_linea);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count($filter){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::pos_linea);
        $result = $this->db->count_all_results();
        return $result;
    }

    function save_linea( $datos ){

        $data = array(
            'Empresa'       => $this->session->empresa[0]->id_empresa,
            'estado_linea'  => $datos['estado_linea'],
            'tipo_producto' =>  $datos['tipo_producto'],
            'descripcion_tipo_producto'  => $datos['descripcion_tipo_producto'],
        );
        
        $result = $this->db->insert(self::pos_linea, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getLineaId( $linea_id ){

        $this->db->select('*');
        $this->db->from(self::pos_linea);
        $this->db->where('id_linea',  $linea_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update_linea( $datos ){

        $data = array(
            'tipo_producto' =>  $datos['tipo_producto'],
            'estado_linea'  => $datos['estado_linea'],
            'descripcion_tipo_producto'  => $datos['descripcion_tipo_producto'],
        );
        
        $this->db->where('id_linea', $datos['id_linea']);
        $result = $this->db->update(self::pos_linea, $data);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar_linea( $id ){

        $data = array(
            'id_linea'  =>  $id
        );
        
        $this->db->where('id_linea', $id);
        $result = $this->db->delete(self::pos_linea, $data);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}