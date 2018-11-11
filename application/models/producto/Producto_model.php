<?php
class Producto_model extends CI_Model {

		const producto =  'ops_prod';
		const atributo =  'ops_atributo';
		const categoria =  'ops_categ';
		const producto_valor =  'ops_prod_valor';
		const sub_categoria =  'ops_categoria_subcategoria';		
		const producto_atributo =  'ops_prod_atri';
		
        
        function getProd(){

			$this->db->select(' distinct(P.id_entidad ) ,P.*, sub_c.*, c.* ');
	        $this->db->from(self::producto.' as P');
	        $this->db->join(self::producto_atributo.' as PA',' on P.id_entidad = PA.id_producto');
	        $this->db->join(self::sub_categoria.' as sub_c',' on sub_c.id_categoria = PA.id_categoria');
	        $this->db->join(self::categoria.' as c',' on c.id_cat = sub_c.id_categoria');
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