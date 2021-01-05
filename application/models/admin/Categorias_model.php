<?php
class Categorias_model extends CI_Model {
	
    const categorias =  'categoria';
    const categorias2 =  'categoria2';

	function get_categorias($limit, $id  , $filters ){

        if($filters!=null || $filters != ""){				
            $filters = " and ".$filters;            
        }
        $query = $this->db->query('
                SELECT categoria.*,es.*, c2.nombre_categoria as "cat_padre", e.nombre_comercial, g.* FROM categoria 
                LEFT JOIN categoria AS c2 on categoria.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = categoria.Empresa 
                LEFT JOIN pos_giros as g on g.id_giro = categoria.codigo_giro
                LEFT JOIN pos_orden_estado AS es ON es.id_orden_estado = categoria.categoria_estado
                where categoria.Empresa='.$this->session->empresa[0]->id_empresa .' '.$filters .' order by categoria.codigo_giro asc Limit '.  $id.','.$limit);
        //echo $this->db->queries[2];
        return $query->result();
	}

    function record_count($filter){
        /*
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa . ' '. $filter);
        $this->db->from(self::categorias);        
        $result = $this->db->count_all_results();
        */

        if($filter){
            $filter = " and ". $filter;
        }

        $query = $this->db->query('
                SELECT count(*) as total FROM categoria 
                LEFT JOIN categoria AS c2 on categoria.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = categoria.Empresa 
                LEFT JOIN pos_giros as g on g.id_giro = categoria.codigo_giro
                where categoria.Empresa='.$this->session->empresa[0]->id_empresa .' '.$filter );
                $data = $query->result();        

        return $data[0]->total;
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
	
		$insert = $this->db->insert(self::categorias, $data ); 
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;

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
                'Empresa'           => $categorias['Empresa'],
                'codigo_giro'       => $categorias['codigo_giro'],
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria'  => $categorias['nombre_categoria'],                 
                'Empresa'           => $categorias['Empresa'],   
                'codigo_giro'       => $categorias['codigo_giro'],         
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );
        }

        $this->db->where('id_categoria', $categorias['id_categoria']);
        $insert = $this->db->update(self::categorias, $data);  
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
	}

    function delete_categoria($id){
         
         $data = array(
            'id_categoria' => $id,
        );

        $insert = $this->db->delete(self::categorias, $data); 
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_categorias_padres(){
        $this->db->select('*');
        $this->db->from(self::categorias);
        $this->db->where('id_categoria_padre IS NULL' );
        $this->db->where('nombre_categoria != ""' );
        $this->db->where('Empresa ',$this->session->empresa[0]->id_empresa );
        $this->db->order_by('nombre_categoria','asc');
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
        $this->db->order_by('nombre_categoria','asc');
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
        $this->db->where('Empresa ',$this->session->empresa[0]->id_empresa );
        $this->db->order_by('nombre_categoria','asc');    
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function get_all_categorias( ){

        $this->db->select('*');
        $this->db->from(self::categoria.' as c');
        $this->db->where('c.id_categoria_padre', null);
        $this->db->where('c.nombre_categoria != ""');
        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function insert_api($categorias)
    {
        $this->db->truncate(self::categorias2);

        $data = [];
        foreach ($categorias as $key => $categoria) {
            $data[] = $categoria;
        }
        $this->db->insert_batch(self::categorias2, $data);
    }
}