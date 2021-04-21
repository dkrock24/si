<?php
class Orden_model extends CI_Model
{

	const sys_conf				 = 'sys_conf';
	const producto				 =  'producto';
	const atributo				 =  'atributo';
	const categoria				 =  'categoria';
	const pos_giros				 =  'pos_giros';
	const pos_linea				 = 'pos_linea';
	const marcas				 = 'pos_marca';
	const pos_combo				 = 'pos_combo';
	const pos_empresa			 = 'pos_empresa';
	const pos_bodega			 = "pos_bodega";
	const pos_ordenes			 = 'pos_ordenes';
	const sys_persona			 = 'sys_persona';
	const sys_usuario			 = 'sys_usuario';	
	const cliente				 = 'pos_cliente';
	const sucursal				 = 'pos_sucursal';
	const sys_empleado			 = 'sys_empleado';
	const pos_doc_temp			 = 'pos_doc_temp';
	const empleado				 = "sys_empleado";
	const proveedor				 = 'pos_proveedor';
	const empresa_giro			 =  'giros_empresa';
	const giro_plantilla		 =  'giro_pantilla';
	const producto_valor		 =  'producto_valor';
	const producto_img			 = 'pos_producto_img';
	const pos_correlativos		 = 'pos_correlativos';
	const producto_atributo		 =  'producto_atributo';
	const producto_detalle		 = 'producto_detalle';
	const pos_ordenes_detalle	 = 'pos_orden_detalle';
	const pos_temp_suc			 = 'pos_temp_sucursal';
	const categoria_producto	 =  'categoria_producto';
	const impuestos				 = 'pos_tipos_impuestos';
	const producto_bodega		 = 'pos_producto_bodega';
	const atributo_opcion		 =  'atributos_opciones';
	const pos_orden_impuestos	 = "pos_orden_impuestos";
	const pos_ventas_impuestos	 = "pos_ventas_impuestos";
	const sys_empleado_sucursal	 = 'sys_empleado_sucursal';	
	const producto_proveedor	 = 'pos_proveedor_has_producto';
	const pos_proveedor_has_producto	 = 'pos_proveedor_has_producto';
	const pos_orden_estado = 'pos_orden_estado';
	const pos_orden_estado2 = 'pos_orden_estado2';
	const pos_ordenes_integracion = 'pos_ordenes_integracion';
	const sys_integrador_config = 'sys_integrador_config';

	// Ordenes
	const pos_tipo_documento = 'pos_tipo_documento';

	function getOrdenes($limit, $id , $filters )
	{
		//echo $this->session->user[0]->id_usuario;
		if($filters){
			$filters = " and ".$filters;
		}
		$query = $this->db->query("select orden.id,orden.id_sucursal,orden.id_vendedor,orden.id_condpago,orden.num_caja,orden.nombre as nombre_cliente_orden,
			orden.num_correlativo,DATE_FORMAT(orden.fecha,'%m/%d/%Y - %H:%i') AS fecha,orden.anulado,orden.modi_el, cliente.nombre_empresa_o_compania , sucursal.nombre_sucursal,orden_estado
			,tdoc.nombre as tipo_documento, usuario.nombre_usuario, vendedor.nombre_usuario AS vendedor, pago.nombre_modo_pago, oe.orden_estado_nombre,
			(SELECT SUM(od.precioUnidad * od.factor) FROM pos_orden_detalle AS od WHERE od.id_orden = orden.id) AS monto_orden
			from pos_ordenes as orden 

			left join pos_cliente as cliente on cliente.id_cliente = orden.id_cliente
			left join pos_sucursal as sucursal on sucursal.id_sucursal=orden.id_sucursal
			left join pos_tipo_documento as tdoc on tdoc.id_tipo_documento = orden.documento
			left join sys_usuario as usuario on usuario.id_usuario = orden.id_usuario
			left join sys_usuario AS vendedor ON vendedor.id_usuario = orden.id_vendedor
			left join pos_formas_pago as pago on pago.id_modo_pago = orden.id_condpago 
			left join pos_orden_estado as oe  on oe.id_orden_estado= orden.orden_estado
			where oe.id_orden_estado in (1,6,2,5,3,4,6,7) 
			and orden.id_sucursal = ". $this->session->usuario[0]->id_sucursal ." 
			and sucursal.Empresa_Suc=" . $this->session->empresa[0]->id_empresa . $filters. 
			" Order By oe.id_orden_estado ASC , orden.fecha DESC Limit " . $id . ',' . $limit);

		//echo $this->db->queries[5];die;
		return $query->result();
	}

	function record_count($filter)
	{

		$this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa. ' '. $filter);
		$this->db->where('o.id_sucursal',$this->session->usuario[0]->id_sucursal);
		$this->db->from(self::pos_ordenes . ' as o');
		$this->db->join(self::sucursal . ' as s', ' on o.id_sucursal = s.id_sucursal');
		$this->db->where('o.orden_estado in (1,2,5,3,4,6,7)');
		$result = $this->db->count_all_results();
		return $result;
	}

	function get_tipo_documentos()
	{
		$this->db->select('*');
		$this->db->from(self::pos_tipo_documento);
		$this->db->where('Empresa' , $this->session->empresa[0]->id_empresa );
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_doc_suc_pre()
	{

		$this->db->select('*');
		$this->db->from(self::pos_tipo_documento . ' as tp');
		$this->db->join(self::pos_temp_suc . ' as ts', ' on tp.id_tipo_documento = ts.Documento');
		$this->db->join(self::pos_doc_temp . ' as dt', ' on dt.id_factura = ts.Template');
		$this->db->where('ts.Sucursal', $this->session->usuario[0]->Sucursal);
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_productos_valor($sucursal, $bodega, $texto)
	{

		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*,  m.nombre_marca,	b.nombre_bodega
	        		, pde.presentacion , pde.cod_barra as pres_cod_bar , pde.id_producto_detalle, pde.precio, pb.Cantidad, pde.Cliente as productoCliente, pde.Sucursal as productoSucursal
				FROM `producto` as `P`
				
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca				
				LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
				LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
				LEFT JOIN producto_detalle AS `pde` ON pde.Producto = P.id_entidad
				
				WHERE b.id_bodega='" . $bodega . "' and pde.estado_producto_detalle=1
				 and (P.name_entidad LIKE '%$texto%' || P.codigo_barras LIKE '%$texto%' ||
				  P.descripcion_producto LIKE '%$texto%' )");

		//echo $this->db->queries[4];
		return $query->result();
	}

	function get_productos_existencias($texto)
	{

		$query = $this->db->query("SELECT `P`.*, 
		 e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		
				FROM `producto` as `P`
				
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`	
				-- LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
				-- LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
				
				WHERE  P.Empresa='" . $this->session->empresa[0]->id_empresa . "' and (P.name_entidad LIKE '%$texto%' || P.codigo_barras LIKE '%$texto%' || P.descripcion_producto LIKE '%$texto%') ");

		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_producto_completo($producto_id, $id_bodega)
	{

		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, b.id_bodega, b.nombre_bodega, pbodega.id_pro_bod AS id_inventario
	        		, tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage ,
	        		 `sub_c`.`id_categoria` as 'categoria',pde.presentacion,pde.factor,pde.precio,pde.unidad

				FROM `producto` as `P`
				LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
				-- LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
				LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
				LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
				-- LEFT JOIN producto_valor AS pv2 on pv2.id_prod_atributo = PA.id_prod_atrri
				-- LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
				LEFT JOIN pos_producto_bodega AS pbodega ON (pbodega.Producto = P.id_entidad && pbodega.Bodega = $id_bodega)
				LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
				LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
				LEFT JOIN producto_detalle AS pde ON pde.Producto = P.id_entidad

				WHERE pde.id_producto_detalle = " . $producto_id . " and pde.estado_producto_detalle =1 and b.id_bodega =" . $id_bodega);
		//echo $this->db->queries[4];die;
		return $query->result();
	}

	function get_producto_completo3($producto_id, $id_bodega)
	{

		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', 
					`sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa,
					g.id_giro, g.nombre_giro, m.nombre_marca
	        		,b.id_bodega, b.nombre_bodega, pbodega.id_pro_bod AS id_inventario
	        		, tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage ,
	        		 `sub_c`.`id_categoria` as 'categoria',pde.presentacion,pde.factor,pde.precio,pde.unidad

				FROM `producto` as `P`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
				LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
				LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
				-- LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
				LEFT JOIN pos_producto_bodega AS pbodega ON (pbodega.Producto = P.id_entidad && pbodega.Bodega = $id_bodega)
				LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
				LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
				LEFT JOIN producto_detalle AS pde ON pde.Producto = P.id_entidad

				WHERE P.id_entidad = " . $producto_id . " and pde.estado_producto_detalle =1 and b.id_bodega =" . $id_bodega);
		//echo $this->db->queries[1];
		return $query->result();
	}

	function get_producto_precios($producto_id)
	{
		$query = $this->db->query("SELECT 
			id_producto_detalle,
			Producto,
			presentacion,
			factor,
			precio,
			unidad,
			Cliente,
			Sucursal,
			Utilidad,
			cod_barra,
			fecha_creacion_producto_detalle,
			fecha_actualizacion_producto_detalle,
			estado_producto_detalle 
			from producto_detalle as pd
			WHERE pd.Producto = " . $producto_id ." and pd.estado_producto_detalle =1");

		//echo $this->db->queries[1];
		return $query->result();
	}

	function get_bodega($usuario)
	{

		$this->db->select('*');
        $this->db->from(self::sucursal.' as s');
		//$this->db->join(self::sys_empleado_sucursal.' as es', ' on s.id_sucursal = es.es_sucursal','LEFT');
		$this->db->join(self::pos_bodega.' as b', ' on b.Sucursal = s.id_sucursal','');
        //$this->db->join(self::sys_usuario.' as u', ' u.Empleado = es.es_empleado','LEFT');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
		//echo $this->db->queries[4];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }

	}

	function get_bodega_sucursal_traslados($Sucursal)
	{

		$query = $this->db->query("SELECT * FROM pos_bodega where Sucursal= " . $Sucursal);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function get_bodega_sucursal($Sucursal)
	{

		$query = $this->db->query("
				SELECT b.* FROM sys_empleado_sucursal es 
				left join sys_usuario as u on u.id_usuario = es.es_empleado
				left join pos_bodega as b on b.Sucursal = es.es_sucursal
				where b.Sucursal= " . $Sucursal);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function correlativo_final($correlativo, $ingresado)
	{

		$valor = 0;
		if ($correlativo == $ingresado) {
			$valor = $correlativo;
		} else {
			$valor = $ingresado;
		}
		return $valor;
	}

	function guardar_orden($orden, $id_usuario, $cliente , $dataParametros)
	{

		$order_estado = $dataParametros['orden_estado'];

		$total_orden = $orden['orden'][0]['total'];

		//Precio Orden con Impuesto
		$cliente_aplica_impuesto = $cliente[0]->aplica_impuestos;
		if ($cliente_aplica_impuesto == 1) {
			//$total_orden += ($orden['orden'][0]['total'] * $orden['orden'][0]['impuesto_porcentaje']);
		}

		$desc_val = ($orden['orden'][0]['descuento_limite'] * $orden['orden'][0]['total']);

		$siguiente_correlativo = $this->get_siguiente_correlativo( $dataParametros['sucursal_origin'] , $dataParametros['id_tipo_documento'] );
		
		$correlativo_final = $this->correlativo_final($siguiente_correlativo[0]->siguiente_valor, $siguiente_correlativo[0]->siguiente_valor);

		$data = array(
			'id_caja' 		=> $dataParametros['terminal_id'], //terminal_id
			'num_caja' 		=> $dataParametros['terminal_numero'], //terminal_numero
			'd_inc_imp0' 	=> $dataParametros['impuesto'], //impuesto
			'id_tipod' 		=> $dataParametros['id_tipo_documento'], //modo_pago_id
			'documento' 	=> $dataParametros['factura_documento'], //modo_pago_id
			'id_sucursal' 	=> $dataParametros['sucursal_destino'], //sucursal_destino
			'num_correlativo'=> $correlativo_final, //$orden['encabezado'][5]['value'], //numero correlativo
			'id_cliente' 	=> $dataParametros['cliente_codigo'], //cliente_codigo
			'nombre' 		=> $dataParametros['cliente_nombre'], //cliente_nombre
			'direccion' 	=> $dataParametros['cliente_direccion'], //cliente_direccion
			'numero_documento' 	=> $dataParametros['numero_documento_persona'], //numero_documento
			'id_condpago' 	=> $dataParametros['modo_pago_id'], //modo_pago_id
			'comentarios' 	=> $dataParametros['comentarios'], //comentarios
			'id_sucursal_origin'=> $dataParametros['sucursal_origin'], //sucursal_origin	
			'id_vendedor' 	=> $dataParametros['vendedor'], //vendedor
			'id_usuario' 	=> $id_usuario,
			'fecha' 		=> $dataParametros['fecha'],
			'digi_total' 	=> $total_orden,
			'desc_porc' 	=> $orden['orden'][0]['descuento_limite'],
			//'id_bodega' 	=> $orden['orden'][0]['bodega'],
			'desc_val' 		=> $desc_val,
			'total_doc' 	=> $total_orden,
			'fh_inicio' 	=> date("Y-m-d h:i:s"),
			'fh_final' 		=> date("Y-m-d h:i:s"),
			'id_venta' 		=> 0, // Actualizara al procesar la venta
			'facturado_el' 	=> 0, // Actualizara al procesar la venta
			'anulado' 		=> 0, // Actualizara al procesar alguna accion
			//'anulado_el' 	=> "", // Actualizara al procesar alguna accion
			//'anulado_conc'=> "", // Actualizara al procesar alguna accion
			//'cod_estado'	=> "0",
			//'estado_el' 	=> "0",
			//'reserv_producs' => "0",
			//'reserv_conc' 	=> "0",
			'fecha_inglab' 	=> date("Y-m-d h:i:s"),
			//'fecha_entreg' 	=> date("Y-m-d h:i:s"),
			//'tiempoproc' 	=> "0",
			'creado_el' 	=> date("Y-m-d h:i:s"),
			//'modi_el' 		=> "0",
			'orden_estado'	=> $order_estado
		);

		$this->db->insert(self::pos_ordenes, $data);
		$id_orden = $this->db->insert_id();

		$this->guardar_orden_detalle($id_orden, $orden);
		$this->incremento_correlativo($siguiente_correlativo);

		/* GUARDAR IMPUESTOS GENERADOS EN LA VENTA */
		$this->save_venta_impuestos( $id_orden , $orden , 2);

		if ($order_estado == 2) {
			$this->descontar_de_bodega($orden);
		}

		return $correlativo_final;
	}

	function save_venta_impuestos($id_orden , $datos , $impTipo){
		/* 
			Insertando los impuestos generados en la vista de Ventas rapidas.
			$impTipo = 1 -> Orden
			$impTipo = 2 -> Venta Rapida
		*/

		if(isset($datos['impuestos'])){
			foreach ($datos['impuestos'] as $impuestos_datos) {

				foreach ($impuestos_datos as $key => $value) {
					
					$data = array(
						'id_orden' => $id_orden, 
						'ordenEspecial' => $value['ordenEspecial'],
						'ordenImpName' => $value['ordenImpName'],
						'ordenImpTotal' => $value['ordenImpTotal'],
						'ordenImpVal' => $value['ordenImpVal'],
						'ordenSimbolo' => $value['ordenSimbolo'],
						'orden_imp_tipo' => $impTipo ,
						'orden_imp_estado' => 1
					);

					$this->db->insert(self::pos_orden_impuestos, $data ); 
				}
			}	
		}		
	}

	function guardar_orden_detalle($id_orden, $datos)
	{
		foreach ($datos['orden'] as $key => $orden) {

			if ($orden['descuento']) {
				$descuento_porcentaje = $orden['descuento'];
			} else {
				$descuento_porcentaje = 0.00;
			}

			$data = array(
				'id_orden' 		=> $id_orden,
				'producto' 		=> $orden['producto'],
				'producto_id' 	=> $orden['producto_id'],
				'producto2' 	=> $orden['producto2'],
				//'inventario_id' => $orden['inventario_id'],
				'id_bodega' 	=> $orden['id_bodega'],
				'bodega' 		=> $orden['bodega'],
				'combo' 		=> $orden['combo'],
				//'combo_total'	=> $orden['combo_total'],
				'id_producto_combo' => $orden['id_producto_combo'],
				'id_producto_detalle' => $orden['id_producto_detalle'],
				'invisible' 	=> $orden['invisible'],
				'descripcion' 	=> $orden['descripcion'],
				'presenta_ppal' => $orden['presentacion'],
				'cantidad' 	=> $orden['cantidad'],
				'presentacion' 	=> $orden['presentacion'],
				'presentacionFactor' => $orden['presentacionFactor'],
				'tipoprec' 		=> $orden['presentacion'],
				'precioUnidad' 	=> $orden['precioUnidad'],
				'factor' 		=> $orden['presentacionFactor'],
				'total' 		=> (double) $orden['total'] - (double) $orden['descuento_calculado'],
				'total_anterior'=> $orden['total_anterior'],
				'impSuma'		=> $orden['impSuma'],
				'gen' 			=> $orden['gen'],
				'tipo'			=> $orden['tipo'],
				'descuento' 	=> $orden['descuento'],
				'por_desc' 		=> $descuento_porcentaje,
				'descuento_limite' 	=> $orden['descuento_limite'],
				'descuento_calculado' => $orden['descuento_calculado'],
				'comenta' 		=> $orden['descripcion'],
				'iva' 			=> $orden['iva'],
				'categoria' 	=> $orden['categoria'],
				'creado_el' 	=> date("Y-m-d h:i:s"),
				//'id_bomba' 		=> $orden[''],
				//'id_kit' 		=> $orden[''],
				//'tp_c' 			=> $orden[''],
				//'p_inc_imp0' 	=> $orden['orden'][0][''],				
				//'modi_el' 		=> date("Y-m-d h:i:s"),
			);

			$this->db->insert(self::pos_ordenes_detalle, $data);
		}
	}

	function descontar_de_bodega($orden)
	{

		$cantidad = 0;
		foreach ($orden['orden'] as $key => $productos) {

			$cantidad = $this->get_cantidad_bodega($productos['producto_id'], $productos['id_bodega']);

			$cantidad_nueva = ($cantidad[0]->Cantidad - $productos['cantidad']);

			$data = array(
				'Cantidad'	=>  $cantidad_nueva
			);

			$this->db->where('Producto', $productos['producto_id']);
			$this->db->where('Bodega', $productos['id_bodega']);
			$this->db->update(self::producto_bodega, $data);
		}
	}

	function regreso_a_bodega($orden)
	{

		$cantidad = 0;
		foreach ($orden['orden'] as $key => $productos) {

			$cantidad = $this->get_cantidad_bodega($productos['producto_id'], $productos['id_bodega']);

			$cantidad_nueva = ($cantidad[0]->Cantidad + $productos['cantidad']);

			$data = array(
				'Cantidad'	=>  $cantidad_nueva
			);

			$this->db->where('Producto', $productos['producto_id']);
			$this->db->where('Bodega', $productos['id_bodega']);
			$this->db->update(self::producto_bodega, $data);
		}
	}

	function get_cantidad_bodega($id_producto, $id_bodega)
	{

		$this->db->select('*');
		$this->db->from(self::producto_bodega);
		$this->db->where('Producto', $id_producto);
		$this->db->where('Bodega', $id_bodega);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function update($orden, $id_usuario, $cliente , $dataParametros)
	{

		$total_orden = $orden['orden'][0]['total'];

		//Precio Orden con Impuesto
		$cliente_aplica_impuesto = $cliente[0]->aplica_impuestos;
		if ($cliente_aplica_impuesto == 1) {
			$total_orden += ($orden['orden'][0]['total'] * $orden['orden'][0]['impuesto_porcentaje']);
		}

		$desc_val = ($orden['orden'][0]['por_desc'] * $orden['orden'][0]['total']);

		$data = array(
			'id_caja' 		=> $dataParametros['terminal_id'], 
			'num_caja' 		=> $dataParametros['terminal_numero'], 
			'd_inc_imp0' 	=> $dataParametros['impuesto'], 
			'id_tipod' 		=> $dataParametros['orden_documento'], 
			'documento' 	=> $dataParametros['factura_documento'],
			'id_sucursal' 	=> $dataParametros['sucursal_destino'], 
			'num_correlativo' => $dataParametros['orden_numero'], 
			'id_cliente' 	=> $dataParametros['cliente_codigo'], 
			'nombre' 		=> $dataParametros['cliente_nombre'], 
			'direccion' 		=> $dataParametros['cliente_direccion'], 
			'numero_documento' 	=> $dataParametros['numero_documento_persona'], //numero_documento
			'id_condpago' 	=> $dataParametros['modo_pago_id'], 
			'comentarios' 	=> $dataParametros['comentarios'], 
			'id_sucursal_origin' 	=> $dataParametros['sucursal_origin'], 
			'id_usuario' 	=> $id_usuario,
			'fecha' 		=> $dataParametros['fecha'],
			'digi_total' 	=> $total_orden,
			'desc_porc' 	=> $orden['orden'][0]['por_desc'],
			'id_bodega' 	=> $orden['orden'][0]['bodega'],
			'desc_val' 		=> $desc_val,
			'total_doc' 	=> $total_orden,
			'fh_inicio' 	=> date("Y-m-d h:i:s"),
			'fh_final' 		=> date("Y-m-d h:i:s"),
			'id_venta' 		=> 0, // Actualizara al procesar la venta
			'facturado_el' 	=> 0, // Actualizara al procesar la venta
			'anulado' 		=> 0, // Actualizara al procesar alguna accion
			//'anulado_el' 	=> "", // Actualizara al procesar alguna accion
			//'anulado_conc'=> "", // Actualizara al procesar alguna accion
			//'cod_estado'	=> "0",
			//'estado_el' 	=> "0",
			//'reserv_producs' => "0",
			//'reserv_conc' 	=> "0",
			//'fecha_inglab' 	=> date("Y-m-d h:i:s"),
			//'fecha_entreg' 	=> date("Y-m-d h:i:s"),
			//'tiempoproc' 	=> "0",
			//'creado_el' 	=> date("Y-m-d h:i:s"),
			'modi_el' 		=> date("Y-m-d h:i:s"),
			'orden_estado'	=> $dataParametros['orden_estado']
		);

		$orden_id = $orden['orden'][0]['id_orden'];

		/* 1.0 Si Orden es reservada Y se esta eliminado se regresara productos a bodega */

		$estado_orden = $this->get_orden( $dataParametros['orden_numero'] );

		if ($estado_orden[0]->orden_estado == 2) {

			//$this->regreso_a_bodega($orden);
		}
		// 1.0 End


		$this->db->where('id', $orden_id);
		$this->db->update(self::pos_ordenes, $data);

		$this->delete_orden_detalle($orden_id);
		$this->guardar_orden_detalle($orden_id, $orden);

		return array($dataParametros['orden_numero']);
	}

	function cerrar_orden( $correlativo_orden ){

		$data = array(
			'orden_estado' => 6,
		);

		$this->db->where('num_correlativo', $correlativo_orden);
		$this->db->update(self::pos_ordenes, $data);

	}

	function delete_orden_detalle($ordern_id)
	{
		$data = array(
			'id_orden' => $ordern_id,
		);

		$this->db->delete(self::pos_ordenes_detalle, $data);
	}

	function get_siguiente_correlativo($sucursal , $documento)
	{
		$this->db->select('*');
		$this->db->from(self::pos_correlativos);
		$this->db->where('Sucursal', $sucursal);
		$this->db->where('TipoDocumento', $documento);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function incremento_correlativo($siguiente_correlativo)
	{
		//Aunmentar la Secuencia.
		$id_correlativo = $siguiente_correlativo[0]->id_correlativos;
		$correlativo = $siguiente_correlativo[0]->siguiente_valor;
		$correlativo = $correlativo + 1;

		$data = array(
			'siguiente_valor' => $correlativo
		);
		$this->db->where('id_correlativos', $id_correlativo);
		$this->db->update(self::pos_correlativos, $data);
	}

	// Fin ordenes


	//	Creacion de un nuevo producto
	function nuevo_producto($producto, $usuario)
	{

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


		$this->db->insert(self::producto, $data);
		$id_producto = $this->db->insert_id();

		$this->producto_categoria($id_producto, $producto['sub_categoria']);

		// cinsertamos los proveedores en un array para recorrerlos
		$proveedor_array = array($producto['proveedor1'], $producto['proveedor2'], $producto['marca']);

		$this->producto_proveedor($id_producto, $proveedor_array);

		// Insertando Atributos para el producto
		$this->producto_atributos($id_producto, $producto);

		// Insertando los detalles de los precios
		$this->producto_precios($id_producto, $producto);
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

			$atributo = (int) $key;

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

			$imageName = getimageSize($_FILES['11']['tmp_name']);

			// llamando el insert de los valores de los atributos del producto
			$this->producto_atributo_valor($id_producto_atributo, $imageName['mime']);
		}
	}

	function producto_precios($id_producto, $producto)
	{

		foreach ($producto as $key => $value) {
			$costo;
			$similar_key = 'presentacion';

			// Contador es el ultimo caracter numerico del string del campo que se envie				
			similar_text($key, $similar_key, $percent);

			if (round($percent) >= 90  and isset($producto['14'])) {

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
			}
		}
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
		$imagen = file_get_contents($_FILES['11']['tmp_name']);
		$imageProperties = getimageSize($_FILES['11']['tmp_name']);

		$data = array(
			'id_producto' => $id_producto,
			'producto_img_blob' => $imagen,
			'imageType' => $imageProperties['mime'],
			'estado_producto_img' => 1,
			'creado_producto_img' => date("Y-m-d h:i:s")
		);
		$this->db->insert(self::producto_img, $data);
	}

	function get_categorias()
	{
		$this->db->select('*');
		$this->db->from(self::categoria);
		$this->db->where('id_categoria_padre IS NULL');
		$this->db->where('categoria_estado = 1');
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

	function get_producto($id_producto)
	{

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
				where P.id_entidad=" . $id_producto);
		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_precios($id_producto)
	{
		$query = $this->db->query("SELECT *
				FROM `producto_detalle` as `P` where P.Producto=" . $id_producto. " and P.estado_producto_detalle =1");
		return $query->result();
	}

	// Orden Editar

	function get_orden($order_id)
	{
		$this->db->select('*,o.comentarios as orden_comentario');
		$this->db->from(self::pos_ordenes . ' as o');
		$this->db->join(self::sucursal . ' as s', 'on s.id_sucursal = o.id_sucursal');
		$this->db->join(self::sys_empleado . ' as e', 'on e.id_empleado = o.id_vendedor', 'left');
		$this->db->join(self::pos_empresa . ' as em', 'on em.id_empresa = s.Empresa_Suc', 'left');
		$this->db->join(self::cliente.' as c',' on c.id_cliente = o.id_cliente');
		$this->db->join(self::sys_persona.' as p',' on p.id_persona = e.Persona_E');
		$this->db->where('o.num_correlativo', $order_id);
		$this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_impuestos( $order_id )
	{

		$this->db->select('*');
		$this->db->from(self::pos_orden_impuestos);
		$this->db->where('id_orden', $order_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_impuestos_venta( $order_id )
	{

		$this->db->select('*');
		$this->db->from(self::pos_ventas_impuestos);
		$this->db->where('id_venta', $order_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function get_orden_detalle($order_id)
	{
		$valores =  explode(",", $order_id);
		
		$this->db->select('*');
		$this->db->from(self::pos_ordenes . ' as o');
		$this->db->join(self::pos_ordenes_detalle . ' as do',' on o.id = do.id_orden');
		//$this->db->where('o.orden_estado = 1');
		$this->db->where_in('o.num_correlativo', $valores );
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function producto_combo($producto_id)
	{
		// Validar si Producto es combo para llevar todos los productos relacionados.
		$this->db->select('*');
		$this->db->from(self::pos_combo . ' as c');
		$this->db->where('c.Producto_Combo', $producto_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function getConfg($componente_conf)
	{
		$this->db->select('*');
		$this->db->from(self::sys_conf . ' as c');
		$this->db->where('c.modulo_conf', 1); // 1 = ordenes modulo
		$this->db->where('c.componente_conf', $componente_conf); // 1 = ordenes modulo
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function getConfgImpuesto($impuesto_conf)
	{
		$this->db->select('*');
		$this->db->from(self::sys_conf . ' as c');
		$this->db->where('c.modulo_conf', 1); // 1 = ordenes modulo
		$this->db->where('c.componente_conf', $impuesto_conf); // 1 = ordenes modulo
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function getConfgDescuento($descuento_conf){
		$this->db->select('*');
		$this->db->from(self::sys_conf . ' as c');
		$this->db->where('c.modulo_conf', 1); // 1 = ordenes modulo
		$this->db->where('c.componente_conf', $descuento_conf); // 1 = ordenes modulo
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function insert_api($orden_estados)
    {
        $this->db->truncate(self::pos_orden_estado2);
		
        $data = [];
        foreach ($orden_estados as $key => $orden_estado) {
            $data[] = $orden_estado;
		}
		$data = $this->db->insert_batch(self::pos_orden_estado2, $data);
		var_dump($this->db->error());
	}
	
	public function ordenesIntegracion()
	{
		/* obtener ordenes que no se han integrado au */
		$this->db->select('o.*');
		$this->db->from(self::pos_ordenes.' as o');
		$this->db->join(self::pos_ordenes_integracion.' as i', ' ON o.id = i.id_orden_local', 'left');
		$this->db->where('i.id_orden_local is null');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function ordenesRegistro($ordenesIntegradas)
	{
		/**
		 * Aqui se ingresan todas las ordenes que fueron procesadas por el endPoint the ordenes a produccion
		 */
		$config = $this->config_integrador_empresa();
		$ordenIds = [];
		foreach ($ordenesIntegradas as $key => $value) {
			$ordenesIntegradas[$key]->id_empresa = $config[0]->valor_config;
			$ordenesIntegradas[$key]->creado = date("Y-m-d H:i:s");
			$this->db->trans_begin();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$ordenIds[] = $ordenesIntegradas[$key]->id_orden_local;
				$this->db->insert(self::pos_ordenes_integracion,$value);
				$this->db->trans_commit();
			}

		}
		return $ordenIds;
	}

	public function config_integrador_empresa()
	{
		$this->db->select('*');
		$this->db->from(self::sys_integrador_config);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function get_ordenes_in($ordenIds)
	{
		$this->db->select('*');
		$this->db->from(self::pos_ordenes_detalle);
		$this->db->where_in('id_orden', $ordenIds);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function get_ordenes_impuestos($ordenIds)
	{
		$this->db->select('*');
		$this->db->from(self::pos_orden_impuestos);
		$this->db->where_in('id_orden', $ordenIds);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}
}
