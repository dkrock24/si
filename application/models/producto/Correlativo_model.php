<?php
class Correlativo_model extends CI_Model {

	const correlativo = 'pos_correlativos';
    const pos_sucursal = 'pos_sucursal';
	
	function getLinea( $limit, $id  ){
		$this->db->select('*');
        $this->db->from(self::correlativo);
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
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::correlativo);
    }

    function save_linea( $datos ){

        $data = array(
            'tipo_producto'     =>  $datos['tipo_producto'],
            'descripcion_tipo_producto'  => $datos['descripcion_tipo_producto'],
            'estado_linea'     => $datos['estado_linea'],
        );
        
        $this->db->insert(self::correlativo, $data);

    }

    function getLineaId( $linea_id ){

        $this->db->select('*');
        $this->db->from(self::correlativo);
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
            'tipo_producto'     =>  $datos['tipo_producto'],
            'descripcion_tipo_producto'  => $datos['descripcion_tipo_producto'],
            'estado_linea'     => $datos['estado_linea'],
        );
        
        $this->db->where('id_linea', $datos['id_linea']);
        $this->db->update(self::correlativo, $data);
    }

    
}