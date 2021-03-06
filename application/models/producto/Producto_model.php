<?php
class Producto_model extends CI_Model
{

	const producto			 = 'producto';
	const producto2 		 = 'producto2';
	const atributo			 = 'atributo';
	const atributo_opcion	 = 'atributos_opciones';
	const categoria			 = 'categoria';
	const producto_valor	 = 'producto_valor';
	const producto_valor2	 = 'producto_valor2';
	const categoria_producto = 'categoria_producto';
	const categoria_producto2 = 'categoria_producto2';
	const producto_atributo	 = 'producto_atributo';
	const empresa_giro		 = 'giros_empresa';
	const giro_plantilla	 = 'giro_pantilla';
	const pos_linea			 = 'pos_linea';
	const proveedor			 = 'pos_proveedor';
	const producto_proveedor = 'pos_proveedor_has_producto';
	const marcas			 = 'pos_marca';
	const cliente			 = 'pos_cliente';
	const sucursal			 = 'pos_sucursal';
	const producto_detalle	 = 'producto_detalle';
	const producto_detalle2 = 'producto_detalle2';
	const impuestos			 = 'pos_tipos_impuestos';
	const producto_img		 = 'pos_producto_img';
	const producto_img2		 = 'pos_producto_img2';
	const pos_proveedor_has_producto = 'pos_proveedor_has_producto';
	const pos_proveedor_has_producto2 = 'pos_proveedor_has_producto2';
	const pos_bodega		 = 'pos_bodega';
	const pos_producto_bodega = 'pos_producto_bodega';
	const pos_producto_bodega2 = 'pos_producto_bodega2';
	const correlativos		 = 'pos_correlativos';
	const persona			 = 'sys_persona';
	const combo2			 = 'pos_combo2';
	const producto_atributo2  = 'producto_atributo2';


	function getProd($limit, $id, $filters)
	{
		$limite = " Limit " . $id . ',' . $limit;

		if ($filters != null || $filters != "") {

			$filters = " and " . $filters;
			$limite = "";
		}

		$query = $this->db->query(
			"SELECT distinct(P.id_entidad ), `P`.*,es.*, round(P.precio_venta,2) as precio_venta,
			 `sub_c`.`nombre_categoria` , e.nombre_razon_social,
			  e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca, 
			  DATE_FORMAT(P.creado_producto,'%m/%d/%Y') as creado_producto,
			  (Select sum(round(Cantidad,0)) from pos_producto_bodega as pb Where pb.Producto = P.id_entidad ) as prodCantidad
	        	
				FROM `producto` as `P`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_orden_estado` as `es` ON `es`.`id_orden_estado` = `P`.`producto_estado`
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro` where P.Empresa = '" . $this->session->empresa[0]->id_empresa . "'
				$filters   $limite "
		);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function getAllProducto()
	{
		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        	
			FROM `producto` as `P`
			LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
			LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
			LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
			LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
			LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
			LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
			LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro` where P.producto_estado=1 and P.Empresa=" . $this->session->empresa[0]->id_empresa);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function record_count($filter)
	{
		if ($filter != "") {

			$filter = " and " . $filter;

			$query = $this->db->query("SELECT COUNT(P.id_entidad) as total
	        	
				FROM `producto` as `P`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`				
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro` where P.producto_estado=1 and P.Empresa=" . $this->session->empresa[0]->id_empresa . ' ' . $filter);

			//$this->db->queries[0];
			$data = $query->result();

			$total = (int) $data[0]->total;

			return $total;
		} else {

			$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
			$this->db->from(self::producto);
			$result = $this->db->count_all_results();
			return $result;
		}
	}

	// ::::::: CREAR 

	//	Creacion de un nuevo producto
	function nuevo_producto($producto, $usuario)
	{
		//	Creando cabecera de la tabla producto
		$data = array(
			'name_entidad' 		=> strtoupper($producto['name_entidad']),
			'producto_estado' 	=> $producto['producto_estado'],
			'Marca' 			=> $producto['Marca'],
			'Linea' 			=> $producto['Linea'],
			'id_producto_relacionado' => $producto['producto_asociado'],
			'creado_producto' 	=> date("Y-m-d h:i:s"),
			'Empresa' 			=> $producto['empresa'],
			'Giro' 				=> $producto['giro'],
			'codigo_barras' 	=> strtoupper($producto['codigo_barras']),
			'codigo_producto' 	=> strtoupper($producto['codigo_barras']),
			'modelo' 			=> strtoupper($producto['modelo']),
			'costo' 			=> $producto['costo'],
			'minimos' 			=> $producto['minimos'],
			'medios' 			=> $producto['medios'],
			'maximos' 			=> $producto['maximos'],
			'almacenaje' 		=> strtoupper($producto['almacenaje']),
			'descuento_limite' 	=> $producto['descuento_limite'],
			'precio_venta' 		=> $producto['precio_venta'],
			'iva' 				=> $producto['iva'],
			'incluye_iva' 		=> $producto['incluye_iva']
		);
		if (isset($producto['escala'])) {
			$data += ['Escala' => 1];
		} else {
			$data += ['Escala' => 0];
		}
		if (isset($producto['combo'])) {
			$data += ['combo' => 1];
		} else {
			$data += ['combo' => 0];
		}

		$this->db->insert(self::producto, $data);
		$id_producto = $this->db->insert_id();

		$this->producto_categoria($id_producto, $producto['sub_categoria']);

		// insertamos los proveedores en un array para recorrerlos
		$proveedor_array = array($producto['proveedor1'], $producto['proveedor2'], $producto['Marca']);

		$this->producto_proveedor($id_producto, $proveedor_array);

		// Insertando Atributos para el producto
		$this->producto_atributos($id_producto, $producto);

		// Insertando los detalles de los precios
		$presentacion_ids = $this->producto_precios($id_producto, $producto);
		$data_producto = array(
			'producto_id' => $id_producto,
			'presentaciones' => $presentacion_ids
		);

		// Asociar Producto a Sucursales
		return $data_producto;
	}

	function save_producto_bodega($data_producto, $bodegas)
	{
		// Asociar nuevo producto a bodega

		/** Recorrer Bodegas Existentes */
		foreach ($bodegas as $key => $bodega) {

			/** Recorrer Presentaciones Creadas para el producto */
			foreach ($data_producto['presentaciones'] as $key => $presentacion) {
				
				$data = array(
					'Producto' 		=> $data_producto['producto_id'],
					'Presentacion'  => $presentacion,
					'Bodega' 		=> $bodega->id_bodega,
					'Cantidad' 		=> 0,
					'Descripcion' 	=> "",
					'pro_bod_creado' 	=> date("Y-m-d H:i:s"),
					'pro_bod_estado' 	=> 1
				);
			}

			$this->db->insert(self::pos_producto_bodega, $data);
		}
	}

	function producto_categoria($id_producto, $sub_categoria)
	{
		//	Creando detalle en producto categoria

		$data = array(
			'id_categoria' => $sub_categoria,
			'id_producto' => $id_producto
		);

		$this->db->insert(self::categoria_producto, $data);
	}

	function producto_proveedor($producto, $proveedores)
	{
		// Insertando los proveedores para el producto

		$contador = 0;
		$valor = 0;
		do {

			$data = array(
				'proveedor_id_proveedor' => $proveedores[$valor],
				'producto_id_producto' => $producto,
				'marca_id_producto' => $proveedores[2]
			);

			$this->db->insert(self::producto_proveedor, $data);

			if ($proveedores[0] == $proveedores[1]) {
				$contador = 2;
			} else {
				$contador += 1;
				$valor += 1;
			}
		} while ($contador <= 1);
	}

	function producto_atributos($id_producto, $producto)
	{
		// Inserta todos los atributos relacionados al producto
		foreach ($producto as $key => $value) {

			$atributo = (int)$key;

			$int2 = (int) $atributo;

			if ($int2 != 0) {

				$data = array(
					'Producto' => $id_producto,
					'Atributo' => $int2
				);
				$this->db->insert(self::producto_atributo, $data);
				$id_producto_atributo = $this->db->insert_id();

				// llamando el insert de los valores de los atributos del producto
				$this->producto_atributo_valor($id_producto_atributo, $producto[$int2]);
			}
		}
		if ($_FILES['11']) {
			$id = 11;
			// Si viene Atribut0 11=Imagen insertemos la imagen blob
			$this->producto_images($id_producto, $_FILES['11']);

			$data = array(
				'Producto' => $id_producto,
				'Atributo' => $id
			);

			$this->db->insert(self::producto_atributo, $data);
			$id_producto_atributo = $this->db->insert_id();

			$imageName = @getimageSize($_FILES['11']['tmp_name']);

			// llamando el insert de los valores de los atributos del producto
			$this->producto_atributo_valor($id_producto_atributo, $imageName['mime']);
		}
	}

	function producto_precios($id_producto, $producto)
	{
		$producto_presentacion = array();

		foreach ($producto as $key => $value) {
			$costo;
			$similar_key = 'presentacion';

			// Contador es el ultimo caracter numerico del string del campo que se envie				
			similar_text($key, $similar_key, $percent);

			if (round($percent) >= 90) {

				$contador = substr($key, -1);

				$imagen = @file_get_contents($_FILES['img'.$contador]['tmp_name']);
				$imageProperties = @getimageSize($_FILES['img'.$contador]['tmp_name']);

				$data = array(
					'Producto' => $id_producto,
					'presentacion' 	=> $producto['presentacion' . $contador],
					'imagen_presentacion' => $imagen,
					'imagen_type' 	=> $imageProperties['mime'],
					'factor' 		=> $producto['factor' . $contador],
					'precio' 		=> $producto['precio' . $contador],
					'unidad' 		=> $producto['unidad' . $contador],
					'Cliente' 		=> $producto['cliente' . $contador],
					'Sucursal' 		=> $producto['sucursal' . $contador],
					'Utilidad' 		=> $producto['utilidad' . $contador],
					'cod_barra' 	=> $producto['cbarra' . $contador],
					'estado_producto_detalle' => 1,
					'fecha_creacion_producto_detalle' => date("Y-m-d h:i:s")
				);
				$this->db->insert(self::producto_detalle, $data);
				$producto_presentacion[] = $this->db->insert_id();
			}
			if (!isset($producto['presentacion1'])){
				$data = array(
					'Producto' => $id_producto,
					'presentacion' 	=> 'Unidad',
					'factor' 		=> '1',
					'precio' 		=> '0',
					'unidad' 		=> '0',
					'Cliente' 		=> 0,
					'Sucursal' 		=> 0,
					'Utilidad' 		=> '0',
					'cod_barra' 	=> null,
					'estado_producto_detalle' => 1,
					'fecha_creacion_producto_detalle' => date("Y-m-d h:i:s")
				);
				$this->db->insert(self::producto_detalle, $data);
				$producto_presentacion[] = $this->db->insert_id();
				break;
			}
		}
		return $producto_presentacion;
	}

	function producto_atributo_valor($id_producto_atributo, $atributo_valor)
	{
		// Insertando todos los valores de los campos de los atributos del producto
		$data = array(
			'id_prod_atributo' => $id_producto_atributo,
			'valor' => $atributo_valor
		);
		$this->db->insert(self::producto_valor, $data);
	}

	function producto_images($id_producto, $imagen_producto)
	{
		// Insertando Imagenes Productos
		$imagen = "";
		$imagen = @file_get_contents($_FILES['11']['tmp_name']);
		$imageProperties = @getimageSize($_FILES['11']['tmp_name']);

		$data = array(
			'id_producto' 		=> $id_producto,
			'producto_img_blob' => $imagen,
			'imageType' 		=> $imageProperties['mime'],
			'estado_producto_img' => 1,
			'creado_producto_img' => date("Y-m-d h:i:s")
		);
		$this->db->insert(self::producto_img, $data);
	}

	// ::::::: END CREAR

	function get_categorias()
	{
		$this->db->select('*');
		$this->db->from(self::categoria);
		$this->db->where('id_categoria_padre IS NULL');
		$this->db->where('categoria_estado = 1');
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_sub_categorias()
	{
		$this->db->select('*');
		$this->db->from(self::categoria);
		$this->db->where('id_categoria_padre IS NULL');
		$this->db->where('categoria_estado = 1');
		$this->db->where('nombre_categoria != ""');
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function sub_categoria($id_categoria)
	{
		$this->db->select('*');
		$this->db->from(self::categoria);
		$this->db->where('id_categoria_padre = ' . $id_categoria);
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_lineas()
	{
		$this->db->select('*');
		$this->db->from(self::pos_linea);
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$this->db->where('estado_linea = 1');
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_marcas()
	{

		$this->db->select('*');
		$this->db->from(self::marcas);
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$this->db->where('estado_marca = 1');
		$this->db->order_by('nombre_marca', 'asc');
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_proveedor()
	{
		$this->db->select('*');
		$this->db->from(self::proveedor);
		$this->db->where('Empresa_id', $this->session->empresa[0]->id_empresa);
		$this->db->where('estado = 1');
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_producto($id_producto)
	{

		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, 
			`c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', 
				sub_c.id_categoria as 'id_sub_categoria', c.id_categoria as 'id_categoria', 
				e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca, 
				img.producto_img_blob,img.imageType,cli.nombre_empresa_o_compania,cli.id_cliente 
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
				where P.id_entidad=" . $id_producto .
				" and P.Empresa = ". $this->session->empresa[0]->id_empresa);
		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_precios($id_producto)
	{
		$query = $this->db->query("SELECT *
				FROM `producto_detalle` as `P` where P.Producto=" . $id_producto ." and estado_producto_detalle = 1");
		return $query->result();
	}

	function get_producto_proveedor($producto)
	{
		$query = $this->db->query("SELECT *
				FROM `producto` as `P`
				LEFT JOIN `pos_proveedor_has_producto` as `pp` ON `pp`.`producto_id_producto` = `P`.`id_entidad`
				LEFT JOIN `pos_proveedor` as `proveedor` ON `proveedor`.`id_proveedor` = `pp`.`proveedor_id_proveedor`
				where P.id_entidad=" . $producto);
		//echo $this->db->queries[0];
		return $query->result();
	}

	/** Actualizar, vieja funciona */
	function actualizar_producto($producto, $bodegas)
	{
		$data = array(
			'Empresa' => $producto['empresa'],
			'id_producto_relacionado' => $producto['producto_asociado'],
			'actualizado_producto' => date('Y-m-d h:i:s'),
			'name_entidad' 		=> strtoupper($producto['name_entidad']),
			'producto_estado' 	=> $producto['producto_estado'],
			'Marca' 			=> $producto['Marca'],
			//'Linea' 			=> $producto['Linea'],
			'id_producto_relacionado' => $producto['producto_asociado'],
			'creado_producto' 	=> date("Y-m-d h:i:s"),
			'Empresa' 			=> $producto['empresa'],
			'Giro' 				=> $producto['giro'],
			'codigo_barras' 	=> strtoupper($producto['codigo_barras']),
			'modelo' 			=> strtoupper($producto['modelo']),
			'costo' 			=> $producto['costo'],
			'minimos' 			=> $producto['minimos'],
			'medios' 			=> $producto['medios'],
			'maximos' 			=> $producto['maximos'],
			'almacenaje' 		=> strtoupper($producto['almacenaje']),
			'descuento_limite' 	=> $producto['descuento_limite'],
			'precio_venta' 		=> $producto['precio_venta'],
			'iva' 				=> $producto['iva'],
			'incluye_iva' 		=> $producto['incluye_iva']
		);
		if (isset($producto['escala'])) {
			$data += ['Escala' => 1];
		} else {
			$data += ['Escala' => 0];
		}
		if (isset($producto['combo'])) {
			$data += ['combo' => 1];
		} else {
			$data += ['combo' => 0];
		}

		$this->db->where('id_entidad', $producto['id_producto']);
		$result = $update = $this->db->update(self::producto, $data);
		if ($update) {
			$this->actualizar_categoria_producto($producto['sub_categoria'], $producto['id_producto']);

			$this->actualizar_proveedor_producto($producto['proveedor1'], $producto['id_producto']);
			$this->actualizar_proveedor_producto2($producto['proveedor2'], $producto['id_producto']);

			$this->producto_atributo_actualizacion($producto['id_producto'], $producto);

			$this->producto_precios_actualizacion($producto['id_producto'], $producto, $bodegas);

			if (isset($_FILES['11']) && $_FILES['11']['tmp_name'] != null) {
				$this->producto_imagen_actualizar($producto['id_producto'], $_FILES['11']);
			}
		}

		return $result;
	}

	// Actualizar producto
	function actualizar_categoria_producto($id_sub_categoria, $id_producto)
	{
		$data = array(
			'id_categoria' => $id_sub_categoria,
		);

		$this->db->where('id_producto', $id_producto);
		$this->db->update(self::categoria_producto, $data);
	}

	// Actualizar producto
	function actualizar_proveedor_producto($id_proveedor, $id_producto)
	{
		$data = array(
			'proveedor_id_proveedor' => $id_proveedor,
		);

		$this->db->where('producto_id_producto', $id_producto);
		$this->db->where('proveedor_id_proveedor', $id_proveedor);
		$this->db->update(self::pos_proveedor_has_producto, $data);
	}

	function actualizar_proveedor_producto2($id_proveedor, $id_producto)
	{
		$data = array(
			'proveedor_id_proveedor' => $id_proveedor,
		);

		$this->db->where('producto_id_producto', $id_producto);
		$this->db->where('proveedor_id_proveedor', $id_proveedor);
		$this->db->update(self::pos_proveedor_has_producto, $data);
	}

	// Actualizar Atributos
	function producto_atributo_actualizacion($id_producto, $producto)
	{

		$this->db->select('*');
		$this->db->from(self::producto_atributo);
		$this->db->where('Producto', $id_producto);
		$query = $this->db->get();
		//echo $this->db->queries[1];
		$datos = $query->result();

		// Recorrer la lista de producto_atributos
		$id_prod_atrri = 0;

		foreach ($datos as $value) {

			$id_prod_atrri 	= $value->id_prod_atrri;
			$Atributo 		= $value->Atributo;

			if (isset($producto[$Atributo])) {
				$this->actualizar_producto_valor($id_prod_atrri, $producto[$Atributo]);
			}
		}
	}

	// Actualizar Precios del producto
	function producto_precios_actualizacion($id_producto, $producto, $bodegas)
	{
		$cont = 1;
		$flag = false;

		/** Buscar Todos los precios del producto */
		$producto_precio = $this->buscar_producto_precio($id_producto);

		do{
			/** Exite la presentacion que se va actualizar */
			if (isset($producto['presentacion'.$cont])) {
				
				if (isset($producto['id_producto_detalle'.$cont])) {
					
					/** Actualizar presentaciones existentes */
					$id_producto_detalle = $producto['id_producto_detalle'.$cont];
				
					/**  Filtrar para buscar presentacion */ 
					$precioResult = array_filter(
						(array) $producto_precio,
						function($producto,$valor) use ($id_producto_detalle) {
							if($producto->id_producto_detalle == $id_producto_detalle){
								return $producto;
							}
						},ARRAY_FILTER_USE_BOTH
					);

					if ($precioResult) {
						$this->update_producto_detalle($precioResult, $producto , $cont);
					}
					$cont++;

				} else {
					/** Insertar nuevas presentaciones */
					$this->insert_producto_detalle($id_producto, $producto, $cont, $bodegas);
					$cont++;
				}
			
			} else {
				$flag = true;
			}
		}while(!$flag);
		
	}

	private function insert_producto_detalle($id_producto, $producto, $contador, $bodegas)
	{
		$data = array(
			'Producto' => $id_producto,
			'presentacion' 	=> $producto['presentacion' . $contador],
			'factor' 		=> $producto['factor' . $contador],
			'precio' 		=> $producto['precio' . $contador],
			'unidad' 		=> $producto['unidad' . $contador],
			'Cliente' 		=> $producto['cliente' . $contador],
			'Sucursal' 		=> $producto['sucursal' . $contador],
			'Utilidad' 		=> $producto['utilidad' . $contador],
			'cod_barra' 	=> $producto['cbarra' . $contador],
			'estado_producto_detalle' => 1,
			'fecha_creacion_producto_detalle' => date("Y-m-d h:i:s")
		);
		$this->db->insert(self::producto_detalle, $data);
		$presentacion = $this->db->insert_id();

		/** Recorrer Bodegas Existentes */
		foreach ($bodegas as $key => $bodega) {

			$data = array(
				'Producto' 		=> $id_producto,
				'Presentacion'  => $presentacion,
				'Bodega' 		=> $bodega->id_bodega,
				'Cantidad' 		=> 0,
				'Descripcion' 	=> "",
				'pro_bod_creado' 	=> date("Y-m-d H:i:s"),
				'pro_bod_estado' 	=> 1
			);

			$this->db->insert(self::pos_producto_bodega, $data);
		}
	}

	private function update_producto_detalle($precioResult , $producto , $contador)
	{
		$data = array(
			'Producto' 		=> $producto['id_producto'],
			'presentacion' 	=> $producto['presentacion' . $contador],
			'factor' 		=> $producto['factor' . $contador],
			'precio' 		=> $producto['precio' . $contador],
			'unidad' 		=> $producto['unidad' . $contador],
			'Cliente' 		=> $producto['cliente' . $contador],
			'Sucursal' 		=> $producto['sucursal' . $contador],
			'Utilidad' 		=> $producto['utilidad' . $contador],
			'cod_barra' 	=> $producto['cbarra' . $contador],
			'estado_producto_detalle' => 1
		);

		$img = @file_get_contents($_FILES['img'.$contador]['tmp_name']);
		if (!empty($img)) {
			$imagen = @file_get_contents($_FILES['img'.$contador]['tmp_name']);
			$imageProperties = @getimageSize($_FILES['img'.$contador]['tmp_name']);

			$data['imagen_presentacion'] = $imagen;
			$data['imagen_type'] = $imageProperties['mime'];
		}

		$this->db->where('id_producto_detalle', $producto['id_producto_detalle'. $contador]);
		$this->db->update(self::producto_detalle, $data);
	}

	private function buscar_producto_precio($id_producto)
	{
		$data = array(
			'estado_producto_detalle' => 0,
		);
		$this->db->where('Producto', $id_producto);
		$this->db->update(self::producto_detalle, $data);

		$this->db->select('*');
		$this->db->from(self::producto_detalle);
		$this->db->where('Producto', $id_producto);
		$query = $this->db->get();
		//echo $this->db->queries[4];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	// Actualizar producto valor
	function actualizar_producto_valor($id_prod_atrri, $producto_valor)
	{
		$data = array(
			'valor' => $producto_valor,
		);

		$this->db->where('id_prod_atributo', $id_prod_atrri);
		$this->db->update(self::producto_valor, $data);
	}

	// Actualizar Imagen del producto
	function producto_imagen_actualizar($producto_id, $imagen)
	{

		$imagen = file_get_contents($_FILES['11']['tmp_name']);
		$imageProperties = getimageSize($_FILES['11']['tmp_name']);

		$data = array(
			'producto_img_blob' => $imagen,
			'imageType' => $imageProperties['mime'],
			'estado_producto_img' => 1,
			'producto_img_actualizado' => date("Y-m-d h:i:s")
		);

		$this->db->where('id_producto', $producto_id);
		$this->db->update(self::producto_img, $data);
	}

	// ::::::: END ACTUALIZADO

	// Buscar un producto para ser mostrado en la editicion de producto
	function get_producto_atributos($id_producto)
	{

		$query = $this->db->query("SELECT *,a.id_prod_atributo as AtributoId
					FROM `producto` as `p`
					LEFT JOIN `giros_empresa` as `eg` ON `eg`.`id_giro_empresa`=`p`.`Giro`
					LEFT JOIN `giro_pantilla` as `gp` ON `gp`.`Giro`=`eg`.`Giro`
					LEFT JOIN `atributo` as `a` ON `a`.`id_prod_atributo`=`gp`.`Atributo`
					LEFT JOIN `producto_atributo` as `pa` ON `pa`.`Producto`=`p`.`id_entidad`
					LEFT JOIN `producto_valor` as `pv` ON `pv`.`id_prod_atributo`=`pa`.`id_prod_atrri`
					LEFT JOIN `atributos_opciones` as `ao` ON `ao`.`Atributo`=`a`.`id_prod_atributo`
					WHERE `p`.`id_entidad` = " . $id_producto . " and pa.Atributo = a.id_prod_atributo");

		return $query->result();
	}

	function get_empresa_giro_atributos($id_giro)
	{

		$this->db->select('*');
		$this->db->from(self::empresa_giro . ' as eg');
		$this->db->join(self::giro_plantilla . ' as gp', ' on gp.Giro=eg.Giro');
		$this->db->join(self::atributo . ' as a', ' on a.id_prod_atributo=gp.Atributo');
		$this->db->join(self::atributo_opcion . ' as ao', ' on a.id_prod_atributo=ao.Atributo', 'left');
		$this->db->where('eg.id_giro_empresa', $id_giro);
		$this->db->order_by('a.id_prod_atributo', 'ASC');
		$query = $this->db->get();
		//echo $this->db->queries[4];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_clientes()
	{
		$this->db->select('*');
		$this->db->from(self::cliente . ' as c');
		$this->db->join(self::persona . ' as p', ' on c.Persona = p.id_persona ');
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$this->db->where('c.estado_cliente = 1');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_clientes2()
	{
		$this->db->select('nombre_empresa_o_compania, id_cliente');
		$this->db->from(self::cliente . ' as c');
		$this->db->join(self::persona . ' as p', ' on p.id_persona = c.Persona');
		$this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
		$this->db->where('c.estado_cliente = 1');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_sucursales()
	{
		$this->db->select('*');
		$this->db->from(self::correlativos . ' as c');
		$this->db->join(self::sucursal . ' as s', 'on c.Sucursal = s.id_sucursal');
		$this->db->where('correlativo_estado = 1');
		$this->db->where('Empresa_Suc', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_sucursal_producto()
	{
		$this->db->select('*');
		$this->db->from(self::sucursal);
		$this->db->where('sucursal_estado = 1');
		$this->db->where('Empresa_Suc', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_inpuesto()
	{

		$this->db->select('*');
		$this->db->from(self::impuestos);
		$this->db->where('id_tipos_impuestos = 1');
		$this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function eliminar($producto_id)
	{

		$this->db->select('*');
		$this->db->from(self::producto_atributo.' pa');
		$this->db->join(self::producto.' as p',' on pa.Producto = p.id_entidad');
		$this->db->where('Producto', $producto_id);
		$this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();

		$prod = $query->result();

		if ($prod) {

			foreach ($prod as $key => $value) {

				$this->db->where('id_prod_atributo', $value->id_prod_atrri);
				$this->db->delete(self::producto_valor);


				$this->db->where('id_prod_atrri', $value->id_prod_atrri);
				$this->db->delete(self::producto_atributo);
			}
		}

		$this->db->where('id_entidad', $producto_id);
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$result = $this->db->delete(self::producto);
		if ($this->db->error()) {
			return $this->db->error();
		}
		return $result;
	}

	// Aqui se activa o desactiva producto en bodega
	function producto_activar($datos)
	{

		$bodega_producto = $this->get_bodega_by_producto($datos['producto_id'], 1);

		$contador = 1;

		foreach ($bodega_producto as $pb) {
			$cantidad = 0;

			if ($datos['cantidad' . $pb->id_pro_bod] != "") {
				$cantidad = ($datos['cantidad' . $pb->id_pro_bod] + $pb->Cantidad);
			} else {
				$cantidad =  $pb->Cantidad;
			}
			if (array_key_exists($pb->id_pro_bod, $datos)) {

				$data = array('pro_bod_estado' => 1, 'Cantidad' => $cantidad, 'pro_bod_actualizado' => date("Y-m-d h:i:s"));
				$this->db->where('id_pro_bod', $pb->id_pro_bod);
				$this->db->update(self::pos_producto_bodega, $data);
			} else {

				$data = array('pro_bod_estado' => 0, 'Cantidad' => $cantidad, 'pro_bod_actualizado' => date("Y-m-d h:i:s"));
				$this->db->where('id_pro_bod', $pb->id_pro_bod);
				$this->db->update(self::pos_producto_bodega, $data);
			}
			$contador += 1;
		}
	}

	// Esta funcion es usada para buscar producto y activar o desactivar los productos en bodega
	function get_bodega_by_producto($producto, $estado)
	{

		$this->db->select('*');
		$this->db->from(self::pos_bodega . ' as b');
		$this->db->join(self::pos_producto_bodega . ' as pb', 'on pb.Bodega = b.id_bodega');

		$this->db->where('pb.Producto', $producto);
		$this->db->order_by('b.Sucursal');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	// Aqui se crea nueva vinculacion con producto - bodega
	function associar_bodega($bodegas)
	{

		foreach ($bodegas as $key => $b) {
			$Bodega_id = $key;

			if (is_numeric($Bodega_id)) {

				$bodega_producto = $this->get_producto_bodega_byId($Bodega_id, $bodegas['producto']);

				if ($bodega_producto) {
					foreach ($bodega_producto as $pb) {

						if (array_key_exists($pb->Bodega, $bodegas)) {
						} else {

							$data = array(
								'Producto' => $bodegas['producto'],
								'Bodega' => $key,
								'pro_bod_creado' => date("Y-m-d h:i:s"),
								'pro_bod_estado' => 1
							);
							$this->db->insert(self::pos_producto_bodega, $data);
						}
					}
				} else {

					$data = array(
						'Producto' => $bodegas['producto'],
						'Bodega' => $key,
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
	function get_producto_bodega_byId($id_pro_bod, $producto)
	{

		$this->db->select('*');
		$this->db->from(self::pos_bodega . ' as b');
		$this->db->join(self::pos_producto_bodega . ' as pb', 'on pb.Bodega = b.id_bodega');

		$this->db->where('pb.Producto', $producto);
		$this->db->where('pb.Bodega', $id_pro_bod);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_producto_tabla($param)
	{

		$this->db->select('*');
		$this->db->from(self::producto);
		$this->db->where('producto_estado', 1);
		$this->db->where('combo', $param['combo']);
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$this->db->order_by('name_entidad', 'asc');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_producto_tabla2($param)
	{

		$this->db->select('*');
		$this->db->from(self::producto);
		$this->db->where('producto_estado', 1);
		$this->db->where('combo', 0);
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
		$this->db->order_by('name_entidad', 'asc');
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_productos_id($producto_id)
	{

		$this->db->select('*');
		$this->db->from(self::producto);
		$this->db->where('id_entidad', $producto_id);

		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_productos_codigo($producto_codigo)
	{

		$this->db->select('*');
		$this->db->from(self::producto);
		$this->db->where('codigo_barras', $producto_codigo);

		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_productos_imagen($producto_id)
	{

		$this->db->select('*');
		$this->db->from(self::producto_img);
		$this->db->where('id_producto', $producto_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function filtrar($fields)
	{
	}

	function insert_api($productos)
	{
		$this->db->truncate(self::producto2);

		$data = [];
		foreach ($productos as $key => $p) {
			$data[] = $p;
		}
		$this->db->insert_batch(self::producto2, $data);
	}

	function insert_pc_api($categoria_producto)
	{
		$this->db->truncate(self::categoria_producto2);

		$data = [];
		foreach ($categoria_producto as $key => $cp) {
			$data[] = $cp;
		}
		$this->db->insert_batch(self::categoria_producto2, $data);
	}

	function insert_combo_api($producto_combos)
	{
		$this->db->truncate(self::combo2);

		$data = [];
		foreach ($producto_combos as $key => $c) {
			$data[] = $c;
		}
		$this->db->insert_batch(self::combo2, $data);
	}


	function insert_proveedor_api($producto_proveedor)
	{
		$this->db->truncate(self::pos_proveedor_has_producto2);

		$data = [];
		foreach ($producto_proveedor as $key => $proveedor) {
			$data[] = $proveedor;
		}
		$this->db->insert_batch(self::pos_proveedor_has_producto2, $data);
	}

	function insert_attributo_api($attributos)
	{
		$this->db->truncate(self::producto_atributo2);

		$data = [];
		foreach ($attributos as $key => $attributo) {
			$data[] = $attributo;
		}
		$this->db->insert_batch(self::producto_atributo2, $data);
	}

	function insert_attributo_valor_api($valores)
	{
		$this->db->truncate(self::producto_valor2);

		$data = [];
		foreach ($valores as $key => $valor) {
			$data[] = $valor;
		}
		$this->db->insert_batch(self::producto_valor2, $data);
	}

	function insert_pd_api($producto_detalle)
	{
		$this->db->truncate(self::producto_detalle2);
		$data = [];
		foreach ($producto_detalle as $key => $detalle) {
			$data[] = $detalle;
		}
		$this->db->insert_batch(self::producto_detalle2, $data);
	}

	function insert_pb_api($producto_bodega)
	{
		$this->db->truncate(self::pos_producto_bodega2);
		$data = [];
		foreach ($producto_bodega as $key => $bodega) {
			$data[] = $bodega;
		}
		$this->db->insert_batch(self::pos_producto_bodega2, $data);
		var_dump($this->db->error());
	}

	function insert_pi_api($producto_img)
	{
		
		$data = [];
		foreach ($producto_img as $key => $img) {
			$img->producto_img_blob = base64_decode($img->producto_img_blob);
			$data[] = $img;
		}
		//var_dump($data);
		$this->db->insert_batch(self::producto_img2, $data);
		
	}

	function truncate_product_image(){
		$this->db->truncate(self::producto_img2);
	}
}
