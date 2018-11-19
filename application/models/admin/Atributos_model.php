<?php
class Atributos_model extends CI_Model {
	
	const atributos =  'atributo';


	function get_atributos(){

		$this->db->select('*');
        $this->db->from(self::atributos);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
	}

    function get_atributos_total(){

        $this->db->select('count(*) as atributos_total');
        $this->db->from(self::atributos);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

	function crear_atributo( $atributos){

		$data = array(
            'nam_atributo' => $atributos['nam_atributo'],
            'tipo_atributo' => $atributos['tipo_atributo'],
            'estado_atributo' => $atributos['estado_atributo'],
            'creado_atributo' => date("Y-m-d h:i:s")
        );
		$this->db->insert(self::atributos, $data ); 

	}

	function get_atributo_id( $id_prod_atributo ){ 

		$this->db->select('*');
        $this->db->from(self::atributos);
        $this->db->where('id_prod_atributo ='. $id_prod_atributo );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function actualizar_atributo( $atributo ){
		$data = array(
            'nam_atributo' => $atributo['nam_atributo'],
            'tipo_atributo' => $atributo['tipo_atributo'],
            'estado_atributo' => $atributo['estado_atributo'],
            'actualizado_atributo' => date("Y-m-d h:i:s")
        );

        $this->db->where('id_prod_atributo', $atributo['id_prod_atributo']);
        $this->db->update(self::atributos, $data);  
	}
}