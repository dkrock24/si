<?php
class Atributos_model extends CI_Model {
	
    const atributos =  'atributo';
    const atributos2 =  'atributo2';
    const atributos_opciones =  'atributos_opciones';
    const atributos_opciones2 =  'atributos_opciones2';
    const giro_pantilla = 'giro_pantilla';
    const pos_orden_estado = 'pos_orden_estado';

	function get_atributos( $limit, $id , $filters ){

		$this->db->select('*');
        $this->db->from(self::atributos);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = atributo.estado_atributo');
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

    function geAllAtributos(){

        $this->db->select('*');
        $this->db->from(self::atributos);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAtributosByGiro($giro){

        $this->db->select('a.*');
        $this->db->from(self::atributos.' as a');
        $this->db->join(self::giro_pantilla . ' as g', ' on a.id_prod_atributo = g.atributo');
        $this->db->where('g.giro', $giro);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filters){

        if($filters!=""){
            $this->db->where($filters);
        }

        
        $this->db->from(self::atributos);
        $result = $this->db->count_all_results();
        return $result;

        //return $this->db->count_all(self::atributos);
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
        $ultimo_id = $this->db->insert_id();

        $this->guardar_atributos_opciones( $ultimo_id , $atributos );

	}

    function guardar_atributos_opciones( $ultimo_id , $atributos ){
        // esta funcion guarda las opcciones de los tipos de atributos de multiples opciones
        var_dump($atributos);
        $contador = 1;
        foreach ($atributos as $key => $value) {

            $option = (int)$key;

            $int2 = (int) $option;
            
            if($int2 != 0){

                $data = array(
                    'Atributo'  => $ultimo_id,
                    'attr_valor' => $value,
                    'attr_fecha_creado' => date("Y-m-d h:i:s"),
                    'attr_estado' => 1
                );
                $this->db->insert(self::atributos_opciones, $data ); 
                $contador += 1;
            }            
        }
    }

	function get_atributo_id( $id_prod_atributo ){ 

		$this->db->select('*');
        $this->db->from(self::atributos.' as a');
        $this->db->join(self::atributos_opciones.' as op ',' on op.Atributo=a.id_prod_atributo', 'left');
        $this->db->where('a.id_prod_atributo ='. $id_prod_atributo );
        
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
        $result = $this->db->update(self::atributos, $data);  
        $this->deleteOpciones($atributo['id_prod_atributo']);
        $this->guardar_atributos_opciones($atributo['id_prod_atributo'] , $atributo );

        return $result;
	}

    function eliminar($id){

        $this->db->where('Atributo', $id );
        $result = $this->db->delete(self::atributos_opciones);

        $this->db->where('id_prod_atributo', $id );
        $result = $this->db->delete(self::atributos);  
        return $result;
    }

    function deleteOpciones($id_atributo){
        $data = array(
            'Atributo' => $id_atributo,
        );

        $this->db->delete(self::atributos_opciones, $data); 
    }

    function insert_api($atributos)
    {
        $this->db->truncate(self::atributos2);

        $data = [];
        foreach ($atributos as $key => $atributo) {
            $data[] = $atributo;
        }
        $this->db->insert_batch(self::atributos2, $data);
    }

    function insert_ao_api($atributos_opciones)
    {
        $this->db->truncate(self::atributos_opciones2);

        $data = [];
        foreach ($atributos_opciones as $key => $atributos_opcione) {
            $data[] = $atributos_opcione;
        }
        $this->db->insert_batch(self::atributos_opciones2, $data);
    }
}