<?php
class Venta_model extends CI_Model {

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
		const pos_ventas = 'pos_ventas';
		const pos_venta_pagos = 'pos_venta_pagos';
		const pos_correlativos = 'pos_correlativos';
		const sys_empleado = 'sys_empleado';
		const pos_ordenes_detalle = 'pos_orden_detalle';
		const pos_venta_detalle = 'pos_venta_detalle';
		const pos_ventas_impuestos = 'pos_ventas_impuestos';
		const pos_combo = 'pos_combo';
		const sys_conf = 'sys_conf';		

		// Ordenes
		const pos_tipo_documento = 'pos_tipo_documento';

		function getVentas($limit, $id ){

			$query = $this->db->query("select ventas.id,ventas.id_sucursal,ventas.id_vendedor,ventas.id_condpago,ventas.num_caja,
			ventas.num_correlativo,ventas.fecha,ventas.anulado,ventas.modi_el, cliente.nombre_empresa_o_compania , sucursal.nombre_sucursal,orden_estado
			,tdoc.nombre as tipo_documento,total_doc, usuario.nombre_usuario, pago.nombre_modo_pago, oe.orden_estado_nombre

			from pos_ventas as ventas 

			left join pos_cliente as cliente on cliente.id_cliente = ventas.id_cliente
			left join pos_sucursal as sucursal on sucursal.id_sucursal=ventas.id_sucursal
			left join pos_tipo_documento as tdoc on tdoc.id_tipo_documento = ventas.id_tipod
			left join sys_usuario as usuario on usuario.id_usuario = ventas.id_usuario
			left join pos_formas_pago as pago on pago.id_modo_pago = ventas.id_condpago 
			left join pos_orden_estado as oe  on oe.id_orden_estado= ventas.orden_estado
			where sucursal.Empresa_Suc=".$this->session->empresa[0]->id_empresa." Order By ventas.creado_el DESC Limit ". $id.','.$limit);

		    //echo $this->db->queries[1];
		    return $query->result();
		}

		function record_count(){

	        $this->db->where('s.Empresa_Suc',$this->session->empresa[0]->id_empresa);
			$this->db->from(self::pos_ventas.' as v');
			$this->db->join(self::sucursal.' as s',' on v.id_sucursal = s.id_sucursal');
			$result = $this->db->count_all_results();
        	return $result;
	    }

		function get_tipo_documentos(){
			$this->db->select('*');
	        $this->db->from(self::pos_tipo_documento);
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_productos_valor($sucursal ,$bodega, $texto){
	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`id_categoria`, `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, A.nam_atributo, A.id_prod_atributo , pv2.valor as cod_barra, b.nombre_bodega
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
				WHERE pa.Atributo = 4 and pb.Cantidad>1 and b.id_bodega='".$bodega."' and b.Sucursal='".$sucursal."' 
				  order by P.id_entidad");

		        //echo $this->db->queries[0];
		        return $query->result();
		}

		function get_productos_existencias($texto){
	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, A.nam_atributo, A.id_prod_atributo , pv2.valor as cod_barra, b.nombre_bodega
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
				WHERE pa.Atributo = 4 and P.Empresa=".$this->session->empresa[0]->id_empresa." group by P.id_entidad order by P.id_entidad");

		        //echo $this->db->queries[0];
		        return $query->result();
		}

		function get_producto_completo($producto_id , $id_bodega ){
	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, A.nam_atributo, A.id_prod_atributo , pv2.valor as valor,b.id_bodega, b.nombre_bodega, pinv.id_inventario
	        		, tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage ,
	        		 `sub_c`.`id_categoria` as 'categoria'

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

				WHERE P.id_entidad = ". $producto_id ." and b.id_bodega =". $id_bodega);
		        //echo $this->db->queries[0];
		        return $query->result();

		}

		function get_producto_precios($producto_id){
	        
	        $query = $this->db->query("SELECT * from prouducto_detalle as pd
				WHERE pd.Producto = ". $producto_id);

		        //echo $this->db->queries[1];
		        return $query->result();

		}

		function get_bodega($usuario){

			$query = $this->db->query("
				SELECT b.* FROM sys_empleado_sucursal es 
				left join sys_usuario as u on u.id_usuario = es.es_empleado
				left join pos_bodega as b on b.Sucursal = es.es_sucursal
				where u.id_usuario= ". $usuario );

		        //echo $this->db->queries[1];
		        return $query->result();
		}

		function get_bodega_sucursal($Sucursal){

			$query = $this->db->query("
				SELECT b.* FROM sys_empleado_sucursal es 
				left join sys_usuario as u on u.id_usuario = es.es_empleado
				left join pos_bodega as b on b.Sucursal = es.es_sucursal
				where b.Sucursal= ". $Sucursal );

		        //echo $this->db->queries[1];
		        return $query->result();
		}

		function correlativo_final($correlativo , $ingresado){
			
			$valor = 0;
			if($correlativo==$ingresado){
				$valor = $correlativo;
			}else{
				$valor = $ingresado;
			}
			return $valor;
		}

		/*
			Funcionaes usadas
			1 - guardar_venta
		*/

		function guardar_venta( $orden , $id_usuario , $cliente , $form , $documento , $sucursal , $correlativo_documento){

			$total_orden = $orden['orden'][0]['total'];
			$total_orden = (float) $total_orden;

			$efecto_inventario = $documento[0]->efecto_inventario;

			if($efecto_inventario == 1){ // Si suma en inventario la venta, es devolucion
				$total_orden = $total_orden* -1;
			}

			//$total_iva = $orden['orden'][0]['por_iva'];
			//$total_iva = (float) $total_iva;

		
			//$order_estado = $orden['estado'];

			//Precio Orden con Impuesto
			$cliente_aplica_impuesto = $cliente[0]->aplica_impuestos;

			//$desc_val = ($total_iva * $total_orden);

			$siguiente_correlativo = $this->get_siguiente_correlativo( $sucursal , $documento );
			
			if($siguiente_correlativo[0]){

				$numero = 0;
				if( isset( $correlativo_documento ) ){
					$numero = $correlativo_documento ;
				}

				$correlativo_final = $this->correlativo_final($siguiente_correlativo[0]->siguiente_valor , $numero );
				
				$data = array(
					'id_caja' 		=> $form['caja_id'], //terminal_id
					'id_cajero'		=> $this->session->db[0]->id_usuario,
					'num_caja' 		=> $form['caja_numero'], //terminal_numero
					'd_inc_imp0' 	=> $form['impuesto'], //impuesto
					'id_tipod' 		=> $documento[0]->id_tipo_documento, //modo_pago_id
					'id_sucursal' 	=> $form['sucursal_destino'], //sucursal_destino
					'num_correlativo'=>$correlativo_final,
					'id_cliente' 	=> $form['cliente_codigo'], //cliente_codigo
					'nombre' 		=> $form['cliente_nombre'], //cliente_nombre
					'direccion' 	=> $form['cliente_direccion'], //cliente_direccion
					'id_condpago' 	=> $form['modo_pago_id'], //modo_pago_id
					'comentarios' 	=> "",//comentarios
					'id_sucursal_origin' => $form['sucursal_origin'], //sucursal_origin	
					'id_vendedor' 	=> $form['vendedor'], //vendedor
					'id_usuario' 	=> $id_usuario,
					'fecha' 		=> date("Y-m-d h:i:s"),	            
					'digi_total' 	=> $total_orden,
					'impSuma'		=> $orden['orden'][0]['impSuma'],
					'iva'			=> $orden['orden'][0]['iva'],
					'desc_porc' 	=> $orden['orden'][0]['descuento_limite'],
					'id_bodega' 	=> $orden['orden'][0]['id_bodega'],
					'desc_val' 		=> $orden['orden'][0]['descuento_calculado'],
					'total_doc' 	=> $total_orden,
					'fh_inicio' 	=> date("Y-m-d h:i:s"),
					'fh_final' 		=> date("Y-m-d h:i:s"),
					'id_venta' 		=> 0, // Actualizara al procesar la venta
					'facturado_el' 	=> 0, // Actualizara al procesar la venta
					'anulado' 		=> 0, // Actualizara al procesar alguna accion
					'creado_el' 	=> date("Y-m-d h:i:s"),
					'fecha_inglab' 	=> date("Y-m-d h:i:s"),
					'orden_estado'	=> $orden['estado'] // Facturada
					//'anulado_el' 	=> "", // Actualizara al procesar alguna accion
					//'anulado_conc'=> "", // Actualizara al procesar alguna accion
					//'cod_estado'	=> "0",
					//'estado_el' 	=> "0",
					//'reserv_producs' => "0",
					//'reserv_conc' 	=> "0",
					//'fecha_entreg' 	=> date("Y-m-d h:i:s"),
					//'tiempoproc' 	=> "0",
					//'modi_el' 		=> "0",
					
				);

				/* GUARDAR ENCABEZADO DE LA VENTA */
				$this->db->insert(self::pos_ventas, $data ); 
				$id_orden = $this->db->insert_id();

				/* GUARDAR DETALLE DE LA VENTA - PRODUCTOS */
				$this->guardar_venta_detalle( $id_orden , $orden , $efecto_inventario );	
				
				/* GUARDAR FORMATOS DE PAGO */
				$this->save_forma_pago($id_orden , $orden['pagos']);

				/* GUARDAR IMPUESTOS GENERADOS EN LA VENTA */
				$this->save_venta_impuestos( $id_orden , $orden , 2);	

				/* INCREMENTO CORRELATIVOS AUTOMATICOS */
				if($correlativo_documento == $siguiente_correlativo[0]->siguiente_valor){
					$this->incremento_correlativo( $siguiente_correlativo[0]->siguiente_valor, $sucursal , $documento[0]->id_tipo_documento);
				}

				/* PROCESAR EFECTOS DE INVENTARIO SOBRE TIPO DOCUMENTO EN BODEGA */
				//$this->efecto_bodega($id_orden , $orden ,$documento);
			}else{
				echo "No hay correlativo";
			}

			return $id_orden;

		}

		function getTerminal($id_caja){
			$this->load->model('admin/Terminal_model', 'temrinal');
			$result = $this->terminal->get_terminal_by_caja($id_caja);
			return $result;
		}

		function save_venta_impuestos($id_venta , $datos , $impTipo){
			/* 
				Insertando los impuestos generados en la vista de Ventas rapidas.
				$impTipo = 1 -> Orden
				$impTipo = 2 -> Venta Rapida
			*/

			if(isset($datos['impuestos'])){
				foreach ($datos['impuestos'] as $impuestos_datos) {

					foreach ($impuestos_datos as $key => $value) {
						
						$data = array(
							'id_venta' => $id_venta, 
							'ordenEspecial' => $value['ordenEspecial'],
							'ordenImpName' => $value['ordenImpName'],
							'ordenImpTotal' => $value['ordenImpTotal'],
							'ordenImpVal' => $value['ordenImpVal'],
							'ordenSimbolo' => $value['ordenSimbolo'],
							'vent_imp_tipo' => $impTipo ,
							'vent_imp_estado' => 1
						);

						$this->db->insert(self::pos_ventas_impuestos, $data ); 
					}
				}	
			}		
		}

		function save_forma_pago($id_venta , $formas_pago ){

			foreach ($formas_pago as $key => $value) {
						
				$data = array(
					'venta_pagos' => $id_venta, 
					'id_forma_pago' => $value['id'],
					'nombre_metodo_pago' => $value['type'],
					'valor_metodo_pago' => $value['amount'],
					'banco_metodo_pago' => $value['banco'],
					'numero_metodo_pago' => $value['valor'],
					'series_metodo_pago' => $value['serie'],
					'estado_venta_pago' => 1
				);

				$this->db->insert(self::pos_venta_pagos, $data ); 
			}
		}

		function guardar_venta_detalle( $id_orden , $datos ,$efecto_inventario ){
			
			foreach ($datos['orden'] as $key => $orden) {

				if($orden['descuento']){
					$descuento_porcentaje = $orden['descuento'];
				}else{
					$descuento_porcentaje = 0.00;
				}
				
				$data = array(
		            'id_venta' 		=> $id_orden,
		            'producto' 		=> $orden['producto'],
		            'producto_id' 	=> $orden['producto_id'],
		            'producto2' 	=> $orden['producto2'],
		            'inventario_id' => $orden['inventario_id'],
		            'id_bodega' 	=> $orden['id_bodega'],
		            'bodega' 		=> $orden['bodega'],
		            'combo' 		=> $orden['combo'],
		            'combo_total'	=> $orden['combo_total'],
		            'invisible' 	=> $orden['invisible'],
		            'descripcion' 	=> $orden['descripcion'],
		            'presenta_ppal' => $orden['presentacion'],
		            'cantidad' 		=> $orden['cantidad'],
		            'presentacion' 	=> $orden['presentacion'],
		            'tipoprec' 		=> $orden['presentacion'],
		            'precioUnidad' 	=> ($efecto_inventario == 1) ?  ($orden['precioUnidad']*-1): $orden['precioUnidad'],
		            'factor' 		=> $orden['presentacionFactor'],
		            'total' 		=> ($efecto_inventario == 1) ? ( $orden['total'] * -1 ) : $orden['total'] ,
		            'gen' 			=> $orden['gen'],
		            'descuento' 	=> ($efecto_inventario == 1) ? ( $orden['descuento'] * -1 ) :$orden['descuento'] ,
		            'por_desc' 		=> $descuento_porcentaje,
		            'descuento_limite' 		=> $orden['descuento_limite'],
		            'descuento_calculado' 	=> $orden['descuento_calculado'],
		            'presentacionFactor' 	=> $orden['presentacionFactor'],
		            'id_producto_combo' 	=>$orden['id_producto_combo'],
		            'id_producto_detalle' 	=> $orden['id_producto_detalle'],
		            'comenta' 		=> $orden['descripcion'],
		            'creado_el' 	=> date("Y-m-d h:i:s"),
		            'modi_el' 		=> date("Y-m-d h:i:s"),
		            //'id_bomba' 		=> $orden[''],
		            //'id_kit' 		=> $orden[''],
		            //'tp_c' 			=> $orden[''],
		           	'p_inc_imp0' 	=> $orden['iva']
		            
	        	);

	        	$this->db->insert(self::pos_venta_detalle, $data ); 
			}
		}

		

		function regreso_a_bodega( $orden ){

			$cantidad = 0;
			foreach ($orden['orden'] as $key => $productos) {

				$cantidad = $this->get_cantidad_bodega($productos['producto_id'], $productos['id_bodega']);
				
				$cantidad_nueva = ($cantidad[0]->Cantidad + $productos['cantidad']);
				
				$data = array(
					'Cantidad'	=>  $cantidad_nueva
				);

				$this->db->where('Producto', $productos['producto_id'] );
				$this->db->where('Bodega', $productos['id_bodega'] );
				$this->db->update(self::producto_bodega, $data ); 

			}
		}

		function get_cantidad_bodega( $id_producto , $id_bodega ){

			$this->db->select('*');
	        $this->db->from(self::producto_bodega);
	        $this->db->where('Producto', $id_producto );
	        $this->db->where('Bodega', $id_bodega );
	        $query = $this->db->get(); 

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }

		}

		function update($orden , $id_usuario , $cliente){

			$total_orden = $orden['orden'][0]['total'];

			//Precio Orden con Impuesto
			$cliente_aplica_impuesto = $cliente[0]->aplica_impuestos;
			if($cliente_aplica_impuesto ==1){
				$total_orden += ($orden['orden'][0]['total'] *$orden['orden'][0]['impuesto_porcentaje']);
			}

			$desc_val = ($orden['orden'][0]['por_desc'] * $orden['orden'][0]['total']);

			$siguiente_correlativo = $orden['encabezado'][14]['value'];

			$data = array(
				'id_caja' 		=> $orden['encabezado'][0]['value'], //terminal_id
				'num_caja' 		=> $orden['encabezado'][1]['value'], //terminal_numero
				'd_inc_imp0' 	=> $orden['encabezado'][2]['value'], //impuesto
				'id_tipod' 		=> $orden['encabezado'][4]['value'], //modo_pago_id
				'id_sucursal' 	=> $orden['encabezado'][5]['value'], //sucursal_destino
				'num_correlativo'=>$siguiente_correlativo,//$orden['encabezado'][5]['value'], //numero correlativo
				'id_cliente' 	=> $orden['encabezado'][7]['value'], //cliente_codigo
				'nombre' 		=> $orden['encabezado'][8]['value'], //cliente_nombre
				'direccion' 		=> $orden['encabezado'][9]['value'], //cliente_direccion
				'id_condpago' 	=> $orden['encabezado'][10]['value'], //modo_pago_id
				'comentarios' 	=> $orden['encabezado'][11]['value'],//comentarios
				'id_sucursal_origin' 	=> $orden['encabezado'][13]['value'], //sucursal_origin	
	            //'id_cajero' 	=> $orden['encabezado'][13]['value'], //vendedor
	            //'id_vendedor' 	=> $orden['encabezado'][15]['value'], //vendedor

	            'id_usuario' 	=> $id_usuario,
	            'fecha' 		=> date("Y-m-d h:i:s"),	            
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
	            'orden_estado'	=> $orden['estado']
        	);

			$orden_id = $orden['orden'][0]['id_orden'];

			/* 1.0 Si Orden es reservada Y se esta eliminado se regresara productos a bodega */

			$estado_orden = $this->get_orden($orden_id);

			if($estado_orden[0]->orden_estado == 2){

				$this->regreso_a_bodega($orden);
			}
			// 1.0 End


			$this->db->where('id', $orden_id );
        	$this->db->update(self::pos_ordenes, $data );

        	$this->delete_orden_detalle( $orden_id );		
        	$this->guardar_orden_detalle( $orden_id , $orden );		
		}

		function delete_orden_detalle( $ordern_id ){
			$data = array(
	            'id_orden' => $ordern_id,
	        );

        	$this->db->delete(self::pos_ordenes_detalle, $data);

		}

		function get_siguiente_correlativo($sucursal , $documento){
			$this->db->select('*');
	        $this->db->from(self::pos_correlativos);
			$this->db->where('Sucursal',$sucursal);
			$this->db->where('TipoDocumento',$documento[0]->id_tipo_documento);
	        $query = $this->db->get(); 
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function incremento_correlativo($numero,  $sucursal , $documento ){
			
			//Aunmentar la Secuencia del tipo de documento en la sucursal.
	        
	        $correlativo = (int) $numero+1;

	        $data = array(
	            'siguiente_valor' => $correlativo
			);
						
			$this->db->where('Sucursal', $sucursal );
			$this->db->where('TipoDocumento', $documento );
			$this->db->update(self::pos_correlativos, $data );

		}

		// Fin ordenes
		
		
        
        

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

		// Orden Editar

		function get_orden( $order_id ){

			$this->db->select('*');
	        $this->db->from(self::pos_ordenes.' as o');
	        $this->db->join(self::sucursal.' as s', 'on s.id_sucursal = o.id_sucursal');
	        $this->db->join(self::sys_empleado.' as e', 'on e.id_empleado = o.id_cajero', 'left');
	        $this->db->join(self::pos_empresa.' as em', 'on em.id_empresa = s.Empresa_Suc', 'left');
	        $this->db->join(self::empresa_giro.' as eg', 'on eg.Empresa = em.id_empresa', 'left');
	        $this->db->join(self::pos_giros.' as pg', 'on pg.id_giro = eg.Giro', 'left');
	        


	        $this->db->where('o.id', $order_id );
	        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function get_orden_detalle( $order_id ){

			$this->db->select('*');
	        $this->db->from(self::pos_ordenes_detalle.' as do');
	        $this->db->where('do.id_orden', $order_id );	        
	        $query = $this->db->get(); 
	        //echo $this->db->queries[0];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function producto_combo( $producto_id ){

			// Validar si Producto es combo para llevar todos los productos relacionados.

			$this->db->select('*');
	        $this->db->from(self::pos_combo.' as c');
	        $this->db->where('c.Producto_Combo', $producto_id );
	        $query = $this->db->get();
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function getConfg($componente_conf){

			$this->db->select('*');
	        $this->db->from(self::sys_conf.' as c');
	        $this->db->where('c.modulo_conf', 1 ); // 1 = ordenes modulo
	        $this->db->where('c.componente_conf', $componente_conf ); // 1 = ordenes modulo
	        $query = $this->db->get();
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		function getConfgImpuesto($impuesto_conf){

			$this->db->select('*');
	        $this->db->from(self::sys_conf.' as c');
	        $this->db->where('c.modulo_conf', 2 ); // 1 = ordenes modulo
	        $this->db->where('c.componente_conf', $impuesto_conf ); // 1 = ordenes modulo
	        $query = $this->db->get();
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}


		// Venta

		function getVentaId($id_venta){

			$query = $this->db->query("select ventas.id,ventas.id_cajero,ventas.id_sucursal,ventas.id_vendedor,ventas.id_condpago,ventas.num_caja,id_tipod,id_condpago,
			ventas.num_correlativo,ventas.fecha,ventas.anulado,ventas.modi_el, cliente.nombre_empresa_o_compania , sucursal.nombre_sucursal,orden_estado
			,tdoc.nombre as tipo_documento, usuario.nombre_usuario, pago.nombre_modo_pago, oe.orden_estado_nombre, empresa.nombre_comercial, empresa.direccion
			, giro.nombre_giro as giro, emp.alias, t.nombre as terminal ,ventas.id_cliente , ventas.total_doc ,cliente.nit_cliente, cliente.nrc_cli

			from pos_ventas as ventas

			left join pos_cliente as cliente on cliente.id_cliente = ventas.id_cliente
			left join pos_sucursal as sucursal on sucursal.id_sucursal=ventas.id_sucursal
			left join pos_empresa as empresa on empresa.id_empresa = sucursal.Empresa_Suc
			left join pos_giros as giro on giro.Empresa = empresa.id_empresa
			left join sys_empleado as emp on emp.id_empleado = ventas.id_cajero

			left join pos_caja as caja on caja.id_caja = ventas.id_caja
			left join pos_terminal as t on t.Caja = caja.id_caja

			left join pos_tipo_documento as tdoc on tdoc.id_tipo_documento = ventas.id_tipod
			left join sys_usuario as usuario on usuario.id_usuario = ventas.id_usuario
			left join pos_formas_pago as pago on pago.id_modo_pago = ventas.id_condpago
			left join pos_orden_estado as oe  on oe.id_orden_estado= ventas.orden_estado
			where ventas.id=".$id_venta);

		    //echo $this->db->queries[1];
		    return $query->result();
		}

		function getVentaDetalleId($id_venta){
			$query = $this->db->query("select *

			from pos_venta_detalle as vd
			left join producto as p ON p.id_entidad = vd.producto_id	
			left join pos_bodega as b on b.id_bodega = vd.id_bodega		
			
			where vd.id_venta =".$id_venta);

		    //echo $this->db->queries[1];
		    return $query->result();
		}

		function getVentaPagosId( $id_venta ){
			$query = $this->db->query("select *

			from pos_venta_pagos where venta_pagos =".$id_venta);

		    //echo $this->db->queries[1];
		    return $query->result();
		}
    }