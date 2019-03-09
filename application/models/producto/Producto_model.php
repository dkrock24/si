<?php
class Producto_model extends CI_Model {

		const producto =  'producto';
		const atributo =  'atributo';
		const atributo_opcion =  'atributos_opciones';
		const categoria =  'categoria';
		const producto_valor =  'producto_valor';
		const categoria_producto =  'categoria_producto';		
		const producto_atributo =  'producto_atributo';
		const empresa_giro =  'giros_empresa';
		const giro_plantilla =  'giro_pantilla';
		const pos_linea = 'pos_linea';
		const proveedor = 'pos_proveedor';
		const producto_proveedor = 'pos_proveedor_has_producto';
		const marcas = 'pos_marca';
		const cliente = 'pos_cliente';
		const sucursal = 'pos_sucursal';
		const producto_detalle = 'prouducto_detalle';
		const impuestos = 'pos_tipos_impuestos';
		const producto_img = 'pos_producto_img';
		const pos_proveedor_has_producto = 'pos_proveedor_has_producto';
		const pos_bodega = 'pos_bodega';
		const pos_producto_bodega = 'pos_producto_bodega';
		
		
        
        function getProd( $limit, $id ){
	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        	,(select pv1.valor from producto_valor as pv1 where pv1.id_prod_atributo=PA.id_prod_atrri ) as Precio
				FROM `producto` as `P`				
				LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
				LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro` where PA.Atributo =23 
				group by P.id_entidad Limit ".$id.','.$limit );

		        //echo $this->db->queries[1];
		        return $query->result();

		}

		function getAllProducto( ){
	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        	,(select pv1.valor from producto_valor as pv1 where pv1.id_prod_atributo=PA.id_prod_atrri ) as Precio
				FROM `producto` as `P`				
				LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
				LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro` where PA.Atributo =23 
				group by P.id_entidad");

		        //echo $this->db->queries[1];
		        return $query->result();

		}

		function record_count(){
        	return $this->db->count_all(self::producto);
    	}

		//	Creacion de un nuevo producto
		function nuevo_producto( $producto , $usuario ){

			//	Creando cabecera de la tabla producto
			$data = array(
	            'name_entidad' => $producto['name_entidad'],
	            'producto_estado' => $producto['producto_estado'],
	            'Marca' => $producto['marca'],
	            'Linea' => $producto['linea'],
	            'id_producto_relacionado' => $producto['procuto_asociado'],
	            'creado_producto' => date("Y-m-d h:i:s"),
	            'Empresa' => $producto['empresa'],
	            'Giro' => $producto['giro']
	        );
			

			$this->db->insert(self::producto, $data ); 
			$id_producto = $this->db->insert_id();

			$this->producto_categoria( $id_producto , $producto['sub_categoria'] );

			// cinsertamos los proveedores en un array para recorrerlos
			$proveedor_array = array($producto['proveedor1'], $producto['proveedor2'], $producto['marca'] );

			$this->producto_proveedor( $id_producto , $proveedor_array );

			// Insertando Atributos para el producto
			$this->producto_atributos( $id_producto, $producto );

			// Insertando los detalles de los precios
			$this->producto_precios( $id_producto, $producto );
		}

		function producto_categoria($id_producto , $sub_categoria){
			//	Creando detalle en producto categoria

			$data = array(
	            'id_categoria' => $sub_categoria,
	            'id_producto' => $id_producto
	        );

			$this->db->insert(self::categoria_producto, $data ); 
		}

		function producto_proveedor($producto , $proveedores ){
			// Insertando los proveedores para el producto

			$contador = 0;
			$valor =0;
			do{
				
				$data = array(
		            'proveedor_id_proveedor' => $proveedores[$valor],
		            'producto_id_producto' => $producto,
		            'marca_id_producto' => $proveedores[2]
		        );

		        $this->db->insert(self::producto_proveedor, $data );

		        if( $proveedores[0] == $proveedores[1] ){
		        	$contador=2;
		        }else{
		        	$contador += 1;
		        	$valor += 1;
		        }
		        
			}while( $contador <= 1 );

		}

		function producto_atributos($id_producto, $producto){
			// Inserta todos los atributos relacionados al producto
			foreach ($producto as $key => $value) {
	            
	            $atributo = (int)$key;

				$int2 = (int) $atributo;

	            if($int2 != 0){

                    $data = array(
                        'Producto' => $id_producto,
                        'Atributo' => $int2
                    );
                    $this->db->insert(self::producto_atributo, $data ); 
                    $id_producto_atributo = $this->db->insert_id();

                    // llamando el insert de los valores de los atributos del producto
	        		$this->producto_atributo_valor( $id_producto_atributo , $producto[$int2] );
	            }
	        }
	        if( $_FILES['11'] ){
	        	$id = 11;
	            // Si viene Atribut0 11=Imagen insertemos la imagen blob
	       		$this->producto_images( $id_producto , $_FILES['11'] );

	       		$data = array(
                        'Producto' => $id_producto,
                        'Atributo' => $id
                    );
                
                $this->db->insert(self::producto_atributo, $data ); 
                $id_producto_atributo = $this->db->insert_id();

                $imageName = getimageSize($_FILES['11']['tmp_name']);

                // llamando el insert de los valores de los atributos del producto
	        	$this->producto_atributo_valor( $id_producto_atributo , $imageName['mime'] );

	        }
	       	
		}

		function producto_precios( $id_producto, $producto ){
			
			foreach ($producto as $key => $value) {
	            $costo;
	            $similar_key = 'presentacion';

	            // Contador es el ultimo caracter numerico del string del campo que se envie				
	            similar_text( $key, $similar_key, $percent );
				
				if( round( $percent) >= 90  and isset($producto['14']) ){

					$contador = substr($key, -1);
					/*
					if(isset($producto[14])){
	            		$costo = $producto['14'] ;
	            	}

					
					if(preg_match_all('/\d+/', $key, $numbers))
    					$contador = end($numbers[0]);

					// Calcular factor					
					 $factor = ($costo / $producto['precio'.$contador] );
					*/

                    $data = array(
                        'Producto' => $id_producto,
                        'presentacion' 	=> $producto['presentacion'.$contador],
                        'factor' 		=> $producto['factor'.$contador],
                        'precio' 		=> $producto['precio'.$contador],
                        'unidad' 		=> $producto['unidad'.$contador],
                        'Cliente' 		=> $producto['cliente'.$contador],
                        'Sucursal' 		=> $producto['sucursal'.$contador],
                        'Utilidad' 		=> $producto['utilidad'.$contador],
                        'cod_barra' 	=> $producto['cbarra'.$contador],
                        'estado_producto_detalle' => 1,
                        'fecha_creacion_producto_detalle' => date("Y-m-d h:i:s")
                    );
                    $this->db->insert(self::producto_detalle, $data ); 
	            }
	        }
		}

		function producto_atributo_valor( $id_producto_atributo , $atributo_valor ){
			// Insertando todos los valores de los campos de los atributos del producto
			$data = array(
                'id_prod_atributo' => $id_producto_atributo,
                'valor' => $atributo_valor
            );
            $this->db->insert(self::producto_valor, $data ); 
		}

		function producto_images( $id_producto  , $imagen_producto ){
			// Insertando Imagenes Productos
			$imagen="";
			$imagen = file_get_contents($_FILES['11']['tmp_name']);
			$imageProperties = getimageSize($_FILES['11']['tmp_name']);

			$data = array(
                'id_producto' => $id_producto,
                'producto_img_blob' => $imagen,
                'imageType' => $imageProperties['mime'],
                'estado_producto_img' => 1,
                'creado_producto_img' => date("Y-m-d h:i:s")
            );
            $this->db->insert(self::producto_img, $data ); 
            

		}

		function get_categorias(){
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

		function get_lineas( ){
			$this->db->select('*');
	        $this->db->from(self::pos_linea);
	        $this->db->where('estado_linea = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_marcas(){

			$this->db->select('*');
	        $this->db->from(self::marcas);
	        $this->db->where('estado_marca = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_proveedor( ){
			$this->db->select('*');
	        $this->db->from(self::proveedor);
	        $this->db->where('estado = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_producto( $id_producto ){

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
				where P.id_entidad=".$id_producto );
		         //echo $this->db->queries[0];
		        return $query->result();
		}

		function get_precios( $id_producto ){
			$query = $this->db->query("SELECT *
				FROM `prouducto_detalle` as `P` where P.Producto=".$id_producto );
		        return $query->result();
		}

		function get_producto_proveedor( $producto ){
			$query = $this->db->query("SELECT *
				FROM `producto` as `P`
				LEFT JOIN `pos_proveedor_has_producto` as `pp` ON `pp`.`producto_id_producto` = `P`.`id_entidad`
				LEFT JOIN `pos_proveedor` as `proveedor` ON `proveedor`.`id_proveedor` = `PP`.`proveedor_id_proveedor`
				where P.id_entidad=".$producto );
		         //echo $this->db->queries[0];
		        return $query->result();
		}

		function actualizar_producto( $producto ){

			$data = array(
	            'name_entidad' => $producto['name_entidad'],
	            'producto_estado' => $producto['producto_estado'],
	            'Empresa' => $producto['empresa'],
	            'Giro' => $producto['giro'],
	            'id_producto_relacionado' => $producto['procuto_asociado']	            
	        );

			//echo $_FILES['11']['tmp_name'];
			//var_dump($_FILES['11']);
			//var_dump($producto);
	        //die;

			$this->db->where('id_entidad', $producto['id_producto']);
			$update = $this->db->update(self::producto, $data ); 
			if($update){
				$this->actualizar_categoria_producto(  $producto['sub_categoria'] , $producto['id_producto'] );

				$this->actualizar_proveedor_producto(  $producto['proveedor1'] , $producto['id_producto'] );
				$this->actualizar_proveedor_producto2(  $producto['proveedor2'] , $producto['id_producto'] );

				$this->producto_atributo_actualizacion($producto['id_producto'] , $producto);

				$this->producto_precios_actualizacion($producto['id_producto'] , $producto);

				if(isset($_FILES['11']) && $_FILES['11']['tmp_name']!=null){
					$this->producto_imagen_actualizar( $producto['id_producto'], $_FILES['11'] );
				}
			}
			
		}

		// Actualizar producto
		function actualizar_categoria_producto($id_sub_categoria , $id_producto ){
			$data = array(
	            'id_categoria' => $id_sub_categoria,	            
	        );

			$this->db->where('id_producto', $id_producto);
			$this->db->update(self::categoria_producto, $data );
		}

		// Actualizar producto
		function actualizar_proveedor_producto($id_proveedor , $id_producto ){
			$data = array(
	            'proveedor_id_proveedor' => $id_proveedor,
	        );

			$this->db->where('producto_id_producto', $id_producto);
			$this->db->where('proveedor_id_proveedor', $id_proveedor);
			$this->db->update(self::pos_proveedor_has_producto, $data );
		}

		function actualizar_proveedor_producto2($id_proveedor , $id_producto ){
			$data = array(
	            'proveedor_id_proveedor' => $id_proveedor,
	        );

			$this->db->where('producto_id_producto', $id_producto);
			$this->db->where('proveedor_id_proveedor', $id_proveedor);
			$this->db->update(self::pos_proveedor_has_producto, $data );
		}

		// Actualizar Atributos
		function producto_atributo_actualizacion( $id_producto , $producto ){
			
			$this->db->select('*');
	        $this->db->from(self::producto_atributo);
	        $this->db->where('Producto', $id_producto );
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        $datos = $query->result();

	        // Recorrer la lista de producto_atributos
	        $id_prod_atrri=0;
	        foreach ($datos as $value) {

	        	$id_prod_atrri 	= $value->id_prod_atrri;
	        	$Atributo 		= $value->Atributo;

	        	if(isset( $producto[$Atributo] )){
	        		$this->actualizar_producto_valor($id_prod_atrri, $producto[$Atributo] );
	        	}

	        }
	        
		}

		// Actualizar Precios del producto
		function producto_precios_actualizacion( $id_producto , $producto ){

			$data = array(
	            'Producto' => $id_producto,
	        );

	        $this->db->delete(self::producto_detalle, $data); 

	        $this->producto_precios( $id_producto , $producto );
		}

		// Actualizar producto valor
		function actualizar_producto_valor( $id_prod_atrri, $producto_valor ){
			$data = array(
	            'valor' => $producto_valor,
	        );

			$this->db->where('id_prod_atributo', $id_prod_atrri);
			$this->db->update(self::producto_valor, $data );
		}

		// Actualizar Imagen del producto
		function producto_imagen_actualizar( $producto_id , $imagen ){

			$imagen = file_get_contents($_FILES['11']['tmp_name']);
			$imageProperties = getimageSize($_FILES['11']['tmp_name']);

			$data = array(
	            'producto_img_blob' => $imagen,
                'imageType' => $imageProperties['mime'],
                'estado_producto_img' => 1,
                'producto_img_actualizado' => date("Y-m-d h:i:s")
	        );

			$this->db->where('id_producto', $producto_id);
			$this->db->update(self::producto_img, $data );
		}

		// Buscar un producto para ser mostrado en la editicion de producto
		function get_producto_atributos( $id_producto ){

			$query = $this->db->query("SELECT *,a.id_prod_atributo as AtributoId
					FROM `producto` as `p`
					LEFT JOIN `giros_empresa` as `eg` ON `eg`.`id_giro_empresa`=`p`.`Giro`
					LEFT JOIN `giro_pantilla` as `gp` ON `gp`.`Giro`=`eg`.`Giro`
					LEFT JOIN `atributo` as `a` ON `a`.`id_prod_atributo`=`gp`.`Atributo`
					LEFT JOIN `producto_atributo` as `pa` ON `pa`.`Producto`=`p`.`id_entidad`
					LEFT JOIN `producto_valor` as `pv` ON `pv`.`id_prod_atributo`=`pa`.`id_prod_atrri`
					LEFT JOIN `atributos_opciones` as `ao` ON `ao`.`Atributo`=`a`.`id_prod_atributo`
					WHERE `p`.`id_entidad` = ".$id_producto." and pa.Atributo = a.id_prod_atributo");

		    return $query->result();
		}

		function get_empresa_giro_atributos( $id_giro ){

			$this->db->select('*');
	        $this->db->from(self::empresa_giro .' as eg');
	        $this->db->join(self::giro_plantilla .' as gp',' on gp.Giro=eg.Giro');
	        $this->db->join(self::atributo .' as a',' on a.id_prod_atributo=gp.Atributo');
	        $this->db->join(self::atributo_opcion .' as ao',' on a.id_prod_atributo=ao.Atributo','left');
	        $this->db->where('eg.id_giro_empresa', $id_giro );	     
	        $this->db->order_by('a.id_prod_atributo', 'ASC');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[4];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_clientes(){
			$this->db->select('*');
	        $this->db->from(self::cliente);
	        $this->db->where('estado = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_sucursales(){
			$this->db->select('*');
	        $this->db->from(self::sucursal);
	        $this->db->where('estado = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_inpuesto(){

			$this->db->select('*');
	        $this->db->from(self::impuestos);
	        $this->db->where('id_tipos_impuestos = 1');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		// Aqui se activa o desactiva producto en bodega
		function producto_activar( $datos ){

			$bodega_producto = $this->get_bodega_by_producto( $datos['producto_id'] , 1 );
			$contador = 1;
			$cantidad = 0;
            foreach ($bodega_producto as $pb) 
            {


            	if($datos['cantidad'.$contador] != ""){
                	$cantidad = ($datos['cantidad'.$contador] + $pb->Cantidad );	
                }else{
                	$cantidad =  $pb->Cantidad;	
                }
                if( array_key_exists( $pb->id_pro_bod, $datos ) ){

                    
                    $data = array('pro_bod_estado' => 1 ,'Cantidad'=> $cantidad ,'pro_bod_actualizado' => date("Y-m-d h:i:s") );                    
                    $this->db->where('id_pro_bod', $pb->id_pro_bod );
                    $this->db->update(self::pos_producto_bodega, $data);

                }else{

                    $data = array('pro_bod_estado' => 0, 'Cantidad'=> $cantidad, 'pro_bod_actualizado' => date("Y-m-d h:i:s") );
                    $this->db->where('id_pro_bod', $pb->id_pro_bod );                    
                    $this->db->update(self::pos_producto_bodega, $data);
                }
                $contador+=1;
            }            
		}

		// Esta funcion es usada para buscar producto y activar o desactivar los productos en bodega
		function get_bodega_by_producto( $producto , $estado ){

			$this->db->select('*');
	        $this->db->from(self::pos_bodega.' as b');	        
	        $this->db->join(self::pos_producto_bodega.' as pb', 'on pb.Bodega = b.id_bodega');

	        $this->db->where('pb.Producto', $producto );
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		// Aqui se crea nueva vinculacion con producto - bodega
		function associar_bodega( $bodegas ){
			var_dump($bodegas);
			foreach ($bodegas as $key => $b) 
            {
            	$Bodega_id = $key;
            	
            	if(is_numeric($Bodega_id)){

					$bodega_producto = $this->get_producto_bodega_byId($Bodega_id ,$bodegas['producto'] );
					
					if($bodega_producto){
						foreach ($bodega_producto as $pb) {

						if( array_key_exists( $pb->Bodega, $bodegas ) ){
		                   
		                }else{
		                	
	                		$data = array(
		                    	'Producto' => $bodegas['producto'],
		                    	'Bodega'=> $key,
		                    	'pro_bod_creado' => date("Y-m-d h:i:s"),
		                    	'pro_bod_estado' => 1
		                    );                   
		                    $this->db->insert(self::pos_producto_bodega, $data);
		                	}		                    
		            	}
					}else{
						
						$data = array(
	                    	'Producto' => $bodegas['producto'],
	                    	'Bodega'=> $key,
	                    	'pro_bod_creado' => date("Y-m-d h:i:s"),
	                    	'pro_bod_estado' => 1
	                    );                   
	                    $this->db->insert(self::pos_producto_bodega, $data);
					}
				}
            }
		}

		/* Esta funcion es usada por associar_bodega en donde
			el producto es validad en la bodega y si no existe
			tiene que ser insertado o vinculado */
		function get_producto_bodega_byId( $id_pro_bod , $producto){

			$this->db->select('*');
	        $this->db->from(self::pos_bodega.' as b');	        
	        $this->db->join(self::pos_producto_bodega.' as pb', 'on pb.Bodega = b.id_bodega');

	        $this->db->where('pb.Producto', $producto );
	        $this->db->where('pb.Bodega', $id_pro_bod );
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_producto_tabla(){

			$this->db->select('*');
	        $this->db->from(self::producto);	        
	        $this->db->where('producto_estado', 1 );
	        $this->db->order_by('name_entidad', 'asc');
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_productos_id( $producto_id ){

			$this->db->select('*');
	        $this->db->from(self::producto);	        
	        $this->db->where('id_entidad', $producto_id );
	        
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

    }

