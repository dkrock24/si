<?php
class Categorias_model extends CI_Model {
	
	const categorias =  'categoria';


	function get_categorias($limit, $id){
        $query = $this->db->query('
                SELECT c1.*, c2.nombre_categoria as "cat_padre", e.nombre_comercial FROM categoria AS c1 
                LEFT JOIN categoria AS c2 on c1.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = c1.Empresa order by c1.nombre_categoria, c2.id_categoria_padre asc Limit '.  $id.','.$limit);
        //echo $this->db->queries[2];
        return $query->result();
	}

    function record_count(){
        return $this->db->count_all(self::categorias);
    }

	function crear_categoria( $categorias){

        //$Empresa = $this->session->userdata['usuario'][0]->Empresa;

        if( $categorias['categoria_padre'] != 0){

            $data = array(
                'nombre_categoria' => $categorias['nombre_categoria'],
                'img_cate' => $categorias['img_cate'],
                'id_categoria_padre' => $categorias['categoria_padre'],
                'categoria_estado' => $categorias['categoria_estado'],
                'Empresa' => $categorias['Empresa'],
                'creado_categoria' => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria' => $categorias['nombre_categoria'],
                'img_cate' => $categorias['img_cate'],                
                'categoria_estado' => $categorias['categoria_estado'],
                'Empresa' => $categorias['Empresa'],
                'creado_categoria' => date("Y-m-d h:i:s")
            );
        }
	
		$this->db->insert(self::categorias, $data ); 

	}

	function get_categoria_id( $id_categoria ){ 

		$query = $this->db->query('
                SELECT c1.*, c2.id_categoria as "id_padre", c2.nombre_categoria as "nombre_padre",  e.nombre_comercial FROM categoria AS c1 
                LEFT JOIN categoria AS c2 on c1.id_categoria_padre = c2.id_categoria
                LEFT JOIN pos_empresa as e on e.id_empresa = c1.Empresa
                WHERE c1.id_categoria='.$id_categoria);
         //echo $this->db->queries[0];
        return $query->result();
	}

	function actualizar_categoria( $categorias ){

		if( $categorias['categoria_padre'] != 0){

            $data = array(
                'nombre_categoria'  => $categorias['nombre_categoria'],
                'img_cate'          => $categorias['img_cate'],
                'id_categoria_padre'=> $categorias['categoria_padre'],
                'Empresa' => $categorias['Empresa'],
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria'  => $categorias['nombre_categoria'],
                'img_cate'          => $categorias['img_cate'],    
                'Empresa' => $categorias['Empresa'],            
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );
        }

        $this->db->where('id_categoria', $categorias['id_categoria']);
        $this->db->update(self::categorias, $data);  
	}

    function get_categorias_padres(){
        $this->db->select('*');
        $this->db->from(self::categorias);
        $this->db->where('id_categoria_padre IS NULL' );
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
}