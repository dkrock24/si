<?php
class Codbarra_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
	
	function getCodbarra( ){
		$this->db->select('*');
        $this->db->from(self::pos_agregar_code_barr.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto= p.id_entidad');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function save_Codbarra( $datos ){

        foreach ($datos as $key => $value) {

            if( $value != $datos['produto_principal'] ){
                $data = array(
                    'Producto'     =>  $datos['produto_principal'],
                    'nombre'  => $key,
                    'code_barr'     => $value,
                );
                $this->db->insert(self::pos_agregar_code_barr, $data);
            }
        }
    }

    function getCodbarraId( $codbarra_id ){

        $this->db->select('*');
        $this->db->from(self::pos_agregar_code_barr.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto= p.id_entidad');
        $this->db->where('c.Producto', $codbarra_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
        
    }

    function update_codbarra( $datos ){
            
        $this->db->where('Producto',$datos['produto_principal'] );
        $this->db->delete(self::pos_agregar_code_barr);

        $this->save_Codbarra($datos);
    }

    function get_combo_valor( $producto , $combo_producto ){

        $this->db->select('*');
        $this->db->from(self::pos_combo);
        $this->db->where('Producto_Combo', $producto);
        $this->db->where('producto_a_descargar_Combo', $combo_producto );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}