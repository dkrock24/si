<?php
class Combo_model extends CI_Model {

	const pos_combo = 'pos_combo';
    const producto = 'producto';
	
	function getCombo( ){
		$this->db->select('*,p.name_entidad as uno, p2.name_entidad as dos');
        $this->db->from(self::pos_combo.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto_Combo= p.id_entidad');
        $this->db->join(self::producto.' as p2', ' on c.producto_a_descargar_Combo= p2.id_entidad');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function save_Combo( $datos ){

        foreach ($datos as $key => $value) {

            //echo "Id:".$key." - Valor =".$value."<br>";
            if(is_numeric( $key )){
                $data = array(
                    'Producto_Combo'     =>  $datos['produto_principal'],
                    'producto_a_descargar_Combo'  => $key,
                    'cantidad'     => $value,
                );
                $this->db->insert(self::pos_combo, $data);
            }
        }
    }

    function getComboId( $combo_id ){

        $this->db->select('*,p.name_entidad as uno, p2.name_entidad as dos');
        $this->db->from(self::pos_combo.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto_Combo= p.id_entidad');
        $this->db->join(self::producto.' as p2', ' on c.producto_a_descargar_Combo= p2.id_entidad');
        $this->db->where('c.Producto_Combo', $combo_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
        
    }

    function update_combo( $datos ){
            
        $this->db->where('Producto_Combo',$datos['produto_principal'] );
        $this->db->delete(self::pos_combo);

        $this->save_Combo($datos);
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