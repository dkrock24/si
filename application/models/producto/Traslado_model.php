<?php
class Traslado_model extends CI_Model
{

	const producto =  'producto';
	const atributo =  'atributo';
	const atributo_opcion =  'atributos_opciones';
	const categoria =  'categoria';
	const producto_valor =  'producto_valor';
	const categoria_producto =  'categoria_producto';
	const producto_atributo =  'producto_atributo';
	const pos_giros =  'pos_giros';
	const empresa_giro =  'giros_empresa';
	const pos_empresa = 'pos_empresa';
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
	const producto_bodega = 'pos_producto_bodega';
	const pos_ordenes = 'pos_ordenes';
	const pos_correlativos = 'pos_correlativos';
	const sys_empleado = 'sys_empleado';
	const pos_ordenes_detalle = 'pos_orden_detalle';
	const pos_combo = 'pos_combo';
	const sys_conf = 'sys_conf';
	const pos_temp_suc = 'pos_temp_sucursal';
	const pos_doc_temp = 'pos_doc_temp';
	const sys_persona = 'sys_persona';
	const sys_empleado_sucursal = 'sys_empleado_sucursal';	
	const sys_usuario = 'sys_usuario';	
	const pos_bodega = "pos_bodega";
	const empleado = "sys_empleado";
	const pos_orden_impuestos = "pos_orden_impuestos";
	const pos_ventas_impuestos = "pos_ventas_impuestos";
	const sys_traslados = "sys_traslados";
	const sys_traslados_detalle = "sys_traslados_detalle";

	// Ordenes
	const pos_tipo_documento = 'pos_tipo_documento';

	function getTraslado($limit, $id , $filters )
	{
		if($filters){
			$filters = " and ".$filters;
		}
		$query = $this->db->query("select t.*, CONCAT(p.primer_nombre_persona, ' ', p.primer_apellido_persona) as recibe ,
									CONCAT(p2.primer_nombre_persona, ' ', p2.primer_apellido_persona) as envia , p.id_persona as id1, p2.id_persona as id2
									from sys_traslados as t
									left join sys_persona as p On p.id_persona = t.firma_llegada 
									left join sys_persona as p2 On p2.id_persona = t.firma_salida
									
									where  t.Empresa =" 
									. $this->session->empresa[0]->id_empresa . $filters. " ORDER BY id_tras desc Limit " . $id . ',' . $limit);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function save_traslado( $producto, $encabezado )
	{
		$fecha = date_create();

		$registros = array();

		foreach ($encabezado as $key => $value) {
			$registros[$value['name']] = $encabezado[$key]['value'];
		}

		$data = array(
			'id_usuario_tras' 	=> $this->session->usuario[0]->id_usuario,
			'correlativo_tras' 	=> date_timestamp_get($fecha),
			'firma_salida' 		=> $registros['firma_salida'],
			'firma_llegada' 	=> $registros['recibe_nombre'],
			'fecha_salida' 		=> $registros['fecha_salida'],
			'fecha_llegada' 	=> $registros['fecha_llegada'],
			'transporte_placa' 	=> $registros['transporte_placa'],
			'sucursal_origin' 	=> $registros['sucursal_origin'],
			'sucursal_destino' 	=> $registros['sucursal_destino'],
			'bodega_destino' 	=> $registros['bodega_destino'],
			'descripcion_tras' 	=> $registros['descripcion_tras'],
			'creado_tras' 		=> date("Y-m-d H:i:s"),
			'Empresa' 			=> $this->session->empresa[0]->id_empresa,
			'estado_tras' 		=> $registros['estado_tras'],
		);

		$this->db->insert(self::sys_traslados, $data);

		$traslado_id = $this->db->insert_id();

		$this->traslado_detalle( $traslado_id ,$producto );

		return $traslado_id;
	}

	function traslado_detalle( $traslado_id ,$producto ){	

		foreach ($producto as $key => $value) {

			$data = array(
				'traslado' 				=> $traslado_id,
				'id_producto_tras' 		=> $value['id_producto_detalle'],
				'codigo_producto_tras' 	=> $value['producto'],
				'cantidad_product_tras' => $value['cantidad'],
				'bodega_origen' 		=> $value['id_bodega'],				
				'descripcion_producto_tras' => $value['descripcion'],
				'estado_tras_detalle' 	=> 0,
			);
	
			$this->db->insert(self::sys_traslados_detalle, $data);
			
		}		

	}

	function record_count($filter)
	{

		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa. ' '. $filter);
		$this->db->from(self::sys_traslados );
		
		$result = $this->db->count_all_results();
		return $result;
	}


	function get_producto_completo($producto_id, $id_bodega)
	{

		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, b.id_bodega, b.nombre_bodega, pinv.id_inventario
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
				LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
				LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
				LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
				LEFT JOIN prouducto_detalle AS pde ON pde.Producto = P.id_entidad

				WHERE pde.id_producto_detalle = " . $producto_id . " and b.id_bodega =" . $id_bodega);
		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_producto_completo3($producto_id, $id_bodega)
	{

		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, A.nam_atributo, A.id_prod_atributo , pv2.valor as valor,b.id_bodega, b.nombre_bodega, pinv.id_inventario
	        		, tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage ,
	        		 `sub_c`.`id_categoria` as 'categoria',pde.presentacion,pde.factor,pde.precio,pde.unidad

				FROM `producto` as `P`
				LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
				LEFT JOIN `atributo` as `A` ON `A`.`id_prod_atributo` = `PA`.`Atributo`
				LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
				LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
				LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
				LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
				LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
				LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
				LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
				LEFT JOIN producto_valor AS pv2 on pv2.id_prod_atributo = PA.id_prod_atrri
				LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
				LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
				LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
				LEFT JOIN prouducto_detalle AS pde ON pde.Producto = P.id_entidad

				WHERE P.id_entidad = " . $producto_id . " and b.id_bodega =" . $id_bodega);
		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_producto_precios($producto_id)
	{

		$query = $this->db->query("SELECT * from prouducto_detalle as pd
				WHERE pd.Producto = " . $producto_id);

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

	function editar_traslado($traslado_id)
	{
		$query = $this->db->query("select e.nombre_razon_social,s.*, t.*, CONCAT(p.primer_nombre_persona, ' ', p.primer_apellido_persona) as recibe ,
									CONCAT(p2.primer_nombre_persona, ' ', p2.primer_apellido_persona) as envia , p.id_persona as id1, p2.id_persona as id2
									from sys_traslados as t
									left join sys_persona as p On p.id_persona = t.firma_llegada 
									left join sys_persona as p2 On p2.id_persona = t.firma_salida
									left join pos_sucursal as s on s.id_sucursal = t.sucursal_origin
									left join pos_empresa as e on e.id_empresa = s.Empresa_Suc
									
									where  t.Empresa =" 
									. $this->session->empresa[0]->id_empresa . ' and t.id_tras = ' . $traslado_id );

		//echo $this->db->queries[1];
		return $query->result();
	}

	function get_traslado_detalle( $id ){

		$valores =  explode(",", $id);
		
		$this->db->select('*');
		$this->db->from(self::sys_traslados . ' as t');
		$this->db->join(self::sys_traslados_detalle . ' as d',' on t.id_tras = d.traslado');
		$this->db->join(self::producto. ' as p', ' on p.id_entidad = d.id_producto_tras');		
		$this->db->where_in('t.id_tras', $valores );
		$query = $this->db->get();
		//echo $this->db->queries[0];

		if ($query->num_rows() > 0) {
			return $query->result();
		}

	}

	function printer($data ){

		$this->db->select('*');
		$this->db->from(self::pos_doc_temp.' as dt');
		$this->db->join(self::pos_temp_suc.' as st',' on dt.id_factura = st.Template');
		$this->db->join(self::sucursal.' as s',' on s.id_sucursal = st.Sucursal');		
		$this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');		
		$this->db->join(self::sys_traslados.' as t', ' on t.doc_tras = st.Documento');
        $this->db->join(self::pos_tipo_documento.' as d',' on d.id_tipo_documento = st.Documento');
        
        $this->db->where('st.Sucursal', $data[0]->sucursal_origin );
        $this->db->where('st.Documento', $data[0]->doc_tras );
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function update( $producto, $encabezado ){
		//var_dump($producto, $encabezado);

		$registros = array();

		foreach ($encabezado as $key => $value) {
			$registros[$value['name']] = $encabezado[$key]['value'];
		}

		$data = array(
			'id_usuario_tras' 	=> $this->session->usuario[0]->id_usuario,
			'firma_salida' 		=> $registros['firma_salida'],
			'firma_llegada' 	=> $registros['recibe_nombre'],
			'fecha_salida' 		=> $registros['fecha_salida'],
			'fecha_llegada' 	=> $registros['fecha_llegada'],
			'transporte_placa' 	=> $registros['transporte_placa'],
			'sucursal_origin' 	=> $registros['sucursal_origin'],
			'sucursal_destino' 	=> $registros['sucursal_destino'],
			'bodega_destino' 	=> $registros['bodega_destino'],
			'descripcion_tras' 	=> $registros['descripcion_tras'],
			'actualizado_tras' 	=> date("Y-m-d H:i:s"),			
			'estado_tras' 		=> $registros['estado_tras'],
		);
		$this->db->where('id_tras', $registros['id_tras']);
		$this->db->update(self::sys_traslados, $data);

		$this->update_detalle(  $registros['id_tras'] , $producto);
	}

	function update_detalle( $traslado ,$producto ){

		$data = array(
			'traslado' => $traslado,
		);

		$this->db->delete(self::sys_traslados_detalle, $data);

		foreach ($producto as $key => $value) {

			$data = array(
				'traslado' 				=> $traslado,
				'id_producto_tras' 		=> $value['id_producto_detalle'],
				'codigo_producto_tras' 	=> $value['producto'],
				'cantidad_product_tras' => $value['cantidad'],
				'bodega_origen' 		=> $value['id_bodega'],				
				'descripcion_producto_tras' => $value['descripcion'],
				'estado_tras_detalle' 	=> 0,
			);
	
			$this->db->insert(self::sys_traslados_detalle, $data);
			
		}		

	}



}