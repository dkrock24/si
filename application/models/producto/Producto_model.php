<?php
class Producto_model extends CI_Model {

		const producto =  'producto';
		const atributo =  'atributo';
		const categoria =  'categoria';
		const producto_valor =  'producto_valor';
		const categoria_producto =  'categoria_producto';		
		const producto_atributo =  'producto_atributo';
		
        
        function getProd(){

			$this->db->select(' distinct(P.id_entidad ) ,P.*, c.nombre_categoria as "nombre_categoria", sub_c.nombre_categoria as "SubCategoria" ');
	        $this->db->from(self::producto.' as P');
	        $this->db->join(self::producto_atributo.' as PA',' on P.id_entidad = PA.id_producto');
	        $this->db->join(self::atributo.' as A',' on A.id_prod_atributo = PA.id_atributo');
	        $this->db->join(self::categoria_producto.' as CP',' on CP.id_producto = P.id_entidad');
	        $this->db->join(self::categoria.' as sub_c',' on sub_c.id_categoria = CP.id_categoria');
	        $this->db->join(self::categoria.' as c',' on c.id_categoria = sub_c.id_categoria_padre');
	        $query = $this->db->get();
	        //echo $this->db->queries[1];die;
	        //die;
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        } 
		}

		function getProd2(){

			$this->db->select('*');
	        $this->db->from(self::producto.' as P');
	        $this->db->join(self::producto_atributo.' as PA',' on P.id_entidad = PA.id_producto');
	        $this->db->join(self::atributo.' as A',' on A.id_prod_atributo = PA.id_atributo');
	        $query = $this->db->get(); 
	        echo $this->db->queries[1];die;
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        } 
		}
    }