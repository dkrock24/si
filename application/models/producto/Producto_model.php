<?php
class Producto_model extends CI_Model {

		const producto =  'producto';
		const atributo =  'atributo';
		const categoria =  'categoria';
		const producto_valor =  'producto_valor';
		const categoria_producto =  'categoria_producto';		
		const producto_atributo =  'producto_atributo';
		const empresa_giro =  'giros_empresa';
		const giro_plantilla =  'giro_pantilla';

		
		
        
        function getProd(){
        	/*
			$this->db->select(' distinct(P.id_entidad ) ,P.*, c.nombre_categoria as "nombre_categoria", sub_c.nombre_categoria as "SubCategoria" ');
	        $this->db->from(self::producto.' as P');
	        $this->db->join(self::producto_atributo.' as PA',' on P.id_entidad = PA.id_producto');
	        $this->db->join(self::atributo.' as A',' on A.id_prod_atributo = PA.id_atributo');
	        $this->db->join(self::categoria_producto.' as CP',' on CP.id_producto = P.id_entidad');
	        $this->db->join(self::categoria.' as sub_c',' on sub_c.id_categoria = CP.id_categoria');
	        $this->db->join(self::categoria.' as c',' on c.id_categoria = sub_c.id_categoria_padre');
	        $query = $this->db->get();
	        echo $this->db->queries[1];

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }*/

	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro
				FROM `producto` as `P`
				LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
				LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`");

		         //echo $this->db->queries[0];
		        return $query->result();

		}

		function nuevo_producto( $producto , $usuario ){

			$data = array(
	            'name_entidad' => $producto['name_entidad'],
	            'producto_estado' => $producto['producto_estado'],
	            'creado_producto' => date("Y-m-d h:i:s"),
	            'Empresa' => $producto['empresa'],
	            'Giro' => $producto['giro']
	        );

			$this->db->insert(self::producto, $data ); 
			$id_producto = $this->db->insert_id();

			$this->producto_categoria( $id_producto , $producto['sub_categoria']);
		}

		function producto_categoria($id_producto , $sub_categoria){

			$data = array(
	            'id_categoria' => $sub_categoria,
	            'id_producto' => $id_producto
	        );

			$this->db->insert(self::categoria_producto, $data ); 
		}

		function get_sub_categorias(){
			$this->db->select('*');
	        $this->db->from(self::categoria);
	        $this->db->where('id_categoria_padre IS NULL' );
	        $this->db->where('categoria_estado = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function sub_categoria( $id_categoria ){
			$this->db->select('*');
	        $this->db->from(self::categoria);
	        $this->db->where('id_categoria_padre = '. $id_categoria);
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_producto( $id_producto ){

			$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', sub_c.id_categoria as 'id_sub_categoria', c.id_categoria as 'id_categoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro
				FROM `producto` as `P`
				LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`id_prod_atrri`
				LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
				where P.id_entidad=".$id_producto );
		         //echo $this->db->queries[0];
		        return $query->result();
		}

		function actualizar_producto( $producto ){

			$data = array(
	            'name_entidad' => $producto['name_entidad'],
	            'producto_estado' => $producto['producto_estado'],
	            'Empresa' => $producto['empresa'],
	            'Giro' => $producto['giro']
	        );

			$this->db->where('id_entidad', $producto['id_entidad']);
			$update = $this->db->update(self::producto, $data ); 
			if($update){
				$this->actualizar_categoria_producto(  $producto['sub_categoria'] , $producto['id_entidad'] );
			}
		}

		function actualizar_categoria_producto($id_sub_categoria , $id_producto ){
			$data = array(
	            'id_categoria' => $id_sub_categoria,	            
	        );

			$this->db->where('id_producto', $id_producto);
			$this->db->update(self::categoria_producto, $data );
		}

		// Buscar un producto para ser mostrado en la editicion de producto
		function get_producto_atributos( $id_producto ){

			$this->db->select('*');
	        $this->db->from(self::producto .' as p');
	        $this->db->join(self::empresa_giro .' as eg',' on eg.id_giro_empresa=p.Giro');
	        $this->db->join(self::giro_plantilla .' as gp',' on gp.Giro=eg.Giro');
	        $this->db->join(self::atributo .' as a',' on a.id_prod_atributo=gp.Atributo');
	        $this->db->where('p.id_entidad', $id_producto );	        
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_empresa_giro_atributos( $id_giro ){

			$this->db->select('*');
	        $this->db->from(self::empresa_giro .' as eg');
	        $this->db->join(self::giro_plantilla .' as gp',' on gp.Giro=eg.Giro');
	        $this->db->join(self::atributo .' as a',' on a.id_prod_atributo=gp.Atributo');
	        $this->db->where('eg.id_giro_empresa', $id_giro );	        
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}


    }