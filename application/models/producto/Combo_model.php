<?php
class Combo_model extends CI_Model {

	const pos_combo = 'pos_combo';
    const producto = 'producto';
    const producto_detalle = 'producto_detalle';

    function getAllCombo( $limit, $id  ){

        $this->db->select(' *, (select sum(cc.cantidad) from pos_combo as cc where cc.Producto_Combo = p.id_entidad) as total');
        $this->db->from(self::pos_combo.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto_Combo= p.id_entidad');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa );

        $this->db->group_by('c.Producto_Combo');
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[3];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

	
	function getCombo( ){

		$this->db->select(' c.*,p.*');
        $this->db->from(self::pos_combo.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto_Combo= p.id_entidad');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->group_by('c.Producto_Combo');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function record_count($filter){
        
        $this->db->select('*');
        $this->db->from(self::pos_combo.' as c');
        $this->db->join(self::producto.' as p',' on c.Producto_Combo = p.id_entidad');
        $this->db->where('p.Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->group_by('c.Producto_Combo');
        $query = $this->db->get(); 
        //echo $this->db->queries[0];
        $result = $this->db->count_all_results();
        return $result;
    }

    function get_producto_combo( $param ){

            $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', sub_c.id_categoria as 'id_sub_categoria', c.id_categoria as 'id_categoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca, img.producto_img_blob,img.imageType,cli.nombre_empresa_o_compania,cli.id_cliente 
                FROM `producto` as `P`
                LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`id_prod_atrri`
                LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
                LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
                LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
                LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
                LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
                LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
                LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
                LEFT JOIN `pos_marca` as `m` ON `m`.`id_marca` = `P`.`Marca`
                LEFT JOIN `pos_producto_img` as `img` ON `img`.`id_producto` = `P`.`id_entidad`
                LEFT JOIN `pos_cliente` as `cli` ON `cli`.`id_cliente` = `img`.`id_producto`
                where P.Empresa=".$this->session->empresa[0]->id_empresa." and P.combo=". $param['combo'] );
                 //echo $this->db->queries[0];
                return $query->result();
        }

    function save_Combo( $datos ){

        foreach ($datos as $key => $value) {

            if(is_numeric( $key )){

                $data = array(

                    'Producto_Combo'=>  $datos['produto_principal'],                    
                    'cantidad'      => $value,
                    'combo_estado'  => 1,
                    'producto_a_descargar_Combo'  => $key
                );

                $this->db->insert(self::pos_combo, $data);
            }
        }
        return true;
    }

    function eliminar($id){

        $this->db->where('Producto_Combo', $id);
        $result = $this->db->delete(self::pos_combo);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getComboId( $combo_id ){

        $this->db->select('*,pd.precio,p.name_entidad as uno, p2.name_entidad as dos, p.*, p2.codigo_barras AS codigoBarras,p2.id_entidad as internalId');
        $this->db->from(self::pos_combo.' as c');
        $this->db->join(self::producto.' as p', ' on c.Producto_Combo= p.id_entidad');
        $this->db->join(self::producto.' as p2', ' on c.producto_a_descargar_Combo= p2.id_entidad');
        $this->db->join(self::producto_detalle.' as pd', ' on pd.Producto =p2.id_entidad');

        $this->db->where('c.Producto_Combo', $combo_id );
        $this->db->group_by('pd.Producto' );
        $query = $this->db->get(); 
        //echo $this->db->queries[0];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }        
    }

    function update_combo( $datos ){
            
        $this->db->where('Producto_Combo',$datos['produto_principal'] );
        $this->db->delete(self::pos_combo);

        $result = $this->save_Combo($datos);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
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