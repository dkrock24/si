<?php
class Categorias_model extends CI_Model {
	
	const categorias =  'categoria';


	function get_categorias($limit, $id  , $filters ){

        if($filters!=null || $filters != ""){
				
            $filters = " and ".$filters;
        }


        $query = $this->db->query('
                SELECT c1.*, c2.nombre_categoria as "cat_padre", e.nombre_comercial, g.* FROM categoria AS c1 
                LEFT JOIN categoria AS c2 on c1.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = c1.Empresa 
                LEFT JOIN pos_giros as g on g.id_giro = c1.codigo_giro
                where c1.Empresa='.$this->session->empresa[0]->id_empresa .' order by  c1.id_categoria_padre, c1.nombre_categoria asc Limit '.  $id.','.$limit);
        //echo $this->db->queries[2];
        return $query->result();
	}

    function record_count(){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::categorias);
        $result = $this->db->count_all_results();
        return $result;
    }

	function crear_categoria( $categorias){

        if( $categorias['categoria_padre'] != 0){

            $data = array(
                'nombre_categoria' => $categorias['nombre_categoria'],
                'id_categoria_padre' => $categorias['categoria_padre'],
                'categoria_estado' => $categorias['categoria_estado'],
                'codigo_giro' => $categorias['codigo_giro'],
                'Empresa' => $this->session->empresa[0]->id_empresa,
                'creado_categoria' => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria' => $categorias['nombre_categoria'],            
                'categoria_estado' => $categorias['categoria_estado'],
                'codigo_giro' => $categorias['codigo_giro'],
                'Empresa' => $this->session->empresa[0]->id_empresa,
                'creado_categoria' => date("Y-m-d h:i:s")
            );
        }
	
		$result = $this->db->insert(self::categorias, $data ); 
        return $result;

	}

	function get_categoria_id( $id_categoria ){ 

		$query = $this->db->query('
                SELECT c1.*, c2.id_categoria as "id_padre", c2.nombre_categoria as "nombre_padre",  e.nombre_comercial, g.* FROM categoria AS c1 
                LEFT JOIN categoria AS c2 on c1.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = c1.Empresa
                LEFT JOIN pos_giros as g on g.id_giro = c1.codigo_giro
                WHERE c1.id_categoria='.$id_categoria. ' and e.id_empresa= '. $this->session->empresa[0]->id_empresa);
         //echo $this->db->queries[0];
        return $query->result();
	}

	function actualizar_categoria( $categorias ){

		if( $categorias['categoria_padre'] != 0){

            $data = array(
                'nombre_categoria'  => $categorias['nombre_categoria'],                
                'id_categoria_padre'=> $categorias['categoria_padre'],
                'Empresa' => $categorias['Empresa'],
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria'  => $categorias['nombre_categoria'],                 
                'Empresa' => $categorias['Empresa'],            
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );
        }

        $this->db->where('id_categoria', $categorias['id_categoria']);
        $result = $this->db->update(self::categorias, $data);  
        return $result;
	}

    function delete_categoria($id){
         
         $data = array(
            'id_categoria' => $id,
        );

        $result = $this->db->delete(self::categorias, $data); 
        return $result;
    }

    function get_categorias_padres(){
        $this->db->select('*');
        $this->db->from(self::categorias);
        $this->db->where('id_categoria_padre IS NULL' );
        $this->db->where('Empresa ',$this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_categorias_hija( $id_categoria ){

        $this->db->select('*');
        $this->db->from(self::categorias);
        $this->db->where('id_categoria_padre', $id_categoria );
        $this->db->where('Empresa ',$this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_categorias_empresa($id_empresa){
        $this->db->select('*');
        $this->db->from(self::categorias);
        $this->db->where('Empresa', $id_empresa);
        $this->db->where('id_categoria_padre IS NULL' );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getCategorias(){

        $this->db->select('*');
        $this->db->from(self::categorias);
        $this->db->where('id_categoria_padre !=""');  
        $this->db->order_by('nombre_categoria','asc');    
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
}