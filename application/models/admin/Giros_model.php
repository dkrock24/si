<?php
class Giros_model extends CI_Model {
	
	const giros =  'pos_giros';


	function get_giros(){

		$this->db->select('*');
        $this->db->from(self::giros);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

	function crear_giro( $nuevo_giro ){

		$data = array(
            'nombre_giro' => $nuevo_giro['nombre_giro'],
            'descripcion_giro' => $nuevo_giro['descripcion_giro'],
            'tipo_giro' => $nuevo_giro['tipo_giro'],
            'codigo_giro' => $nuevo_giro['codigo_giro'],
            'estado_giro' => $nuevo_giro['estado_giro'],
            'fecha_giro_creado' => date("Y-m-d h:i:s")
        );
		$this->db->insert(self::giros, $data ); 

	}

	function get_giro_id( $id_giro ){ 

		$this->db->select('*');
        $this->db->from(self::giros);
        $this->db->where('id_giro ='. $id_giro );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function actualizar_giro( $giro ){
		$data = array(
            'nombre_giro' => $giro['nombre_giro'],
            'descripcion_giro' => $giro['descripcion_giro'],
            'tipo_giro' => $giro['tipo_giro'],
            'codigo_giro' => $giro['codigo_giro'],
            'estado_giro' => $giro['estado_giro'],
            'fecha_giro_actualizado' => date("Y-m-d h:i:s")
        );

        $this->db->where('id_giro', $giro['id_giro']);
        $this->db->update(self::giros, $data);  
	}
}