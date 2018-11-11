<?php
class Categorias_model extends CI_Model {
	
	const categorias =  'categoria';


	function get_categorias(){

        $query = $this->db->query('
                SELECT c1.*, c2.nombre_categoria as "cat_padre", e.nombre_comercial FROM categoria AS c1 
                LEFT JOIN categoria AS c2 on c1.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = c1.Empresa');
         //echo $this->db->queries[0];
        return $query->result();
	}

	function crear_atributo( $categorias){

		$data = array(
            'nam_atributo' => $categorias['nam_atributo'],
            'tipo_atributo' => $categorias['tipo_atributo'],
            'estado_atributo' => $categorias['estado_atributo'],
            'creado_atributo' => date("Y-m-d h:i:s")
        );
		$this->db->insert(self::categorias, $data ); 

	}

	function get_atributo_id( $id_prod_atributo ){ 

		$this->db->select('*');
        $this->db->from(self::categorias);
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
        $this->db->update(self::categorias, $data);  
	}
}