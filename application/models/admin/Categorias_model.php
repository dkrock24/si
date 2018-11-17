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

	function crear_categoria( $categorias){

        if( $categorias['categoria_padre'] != 0){

            $data = array(
                'nombre_categoria' => $categorias['nombre_categoria'],
                'img_cate' => $categorias['img_cate'],
                'id_categoria_padre' => $categorias['categoria_padre'],
                'categoria_estado' => $categorias['categoria_estado'],
                'creado_categoria' => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria' => $categorias['nombre_categoria'],
                'img_cate' => $categorias['img_cate'],                
                'categoria_estado' => $categorias['categoria_estado'],
                'creado_categoria' => date("Y-m-d h:i:s")
            );
        }
		

		$this->db->insert(self::categorias, $data ); 

	}

	function get_categoria_id( $id_categoria ){ 

		$query = $this->db->query('
                SELECT c1.*, c2.id_categoria as "id_padre", c2.nombre_categoria as "nombre_padre" FROM categoria AS c1 
                LEFT JOIN categoria AS c2 on c1.id_categoria_padre = c2.id_categoria
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
                'categoria_estado'  => $categorias['categoria_estado'],
                'actualizado_categoria'  => date("Y-m-d h:i:s")
            );

        }else{
            $data = array(
                'nombre_categoria'  => $categorias['nombre_categoria'],
                'img_cate'          => $categorias['img_cate'],                
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
}