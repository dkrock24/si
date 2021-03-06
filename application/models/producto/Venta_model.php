<?php
class Venta_model extends CI_Model {

		const producto				 =  'producto';
		const atributo				 =  'atributo';
		const atributo_opcion		 =  'atributos_opciones';
		const categoria				 =  'categoria';
		const producto_valor		 =  'producto_valor';
		const categoria_producto	 =  'categoria_producto';		
		const producto_atributo		 =  'producto_atributo';
		const pos_giros				 =  'pos_giros';
		const empresa_giro			 =  'giros_empresa';
		const pos_empresa			 = 'pos_empresa';
		const giro_plantilla		 =  'giro_pantilla';
		const pos_linea				 = 'pos_linea';
		const proveedor				 = 'pos_proveedor';
		const producto_proveedor	 = 'pos_proveedor_has_producto';
		const marcas				 = 'pos_marca';
		const cliente				 = 'pos_cliente';
		const sucursal				 = 'pos_sucursal';
		const producto_detalle		 = 'producto_detalle';
		const impuestos				 = 'pos_tipos_impuestos';
		const impuestos_cliente		 = 'pos_impuesto_cliente';
		const impuestos_documento	 = 'pos_impuesto_documento';
		const impuestos_categoria	 = 'pos_impuesto_categoria';
		const impuestos_proveedor	 = 'pos_impuesto_proveedor';
		const producto_img			 = 'pos_producto_img';
		const pos_proveedor_has_producto = 'pos_proveedor_has_producto';
		const producto_bodega		 = 'pos_producto_bodega';
		const pos_ordenes			 = 'pos_ordenes';
		const pos_ventas			 = 'pos_ventas';
		const pos_venta_pagos		 = 'pos_venta_pagos';
		const pos_correlativos		 = 'pos_correlativos';
		const sys_empleado			 = 'sys_empleado';
		const pos_ordenes_detalle	 = 'pos_orden_detalle';
		const pos_venta_detalle		 = 'pos_venta_detalle';
		const pos_ventas_impuestos	 = 'pos_ventas_impuestos';
		const pos_combo				 = 'pos_combo';
		const sys_conf				 = 'sys_conf';		
		const pos_tipo_documento 	 = 'pos_tipo_documento';
		const pos_doc_temp			 = 'pos_doc_temp';
		const pos_ventas_integracion = 'pos_ventas_integracion';
		const sys_integrador_config  = 'sys_integrador_config';
		// Ordenes		

		private $_orden_id;

		private $_orden;

		private $_totalDocumento;

		private $_templateLineas;

		private $_orden_concetrada = [];

		private $impuestoCategoria = [];

		private $impuestoProveedor = [];

		private $impuestoCliente   = [];

		private $impuestoDocumento = [];

		private $impuestosLista    = [];

		private $impDocumento = [];
		private $impCliente   = [];
		private $impCategoria = [];

		public function __construct()
		{
			$this->impuestoCategoria = $this->getCategoriaImpuesto();
			$this->impuestoProveedor = $this->getProveedorImpuesto();
			$this->impuestoCliente   = $this->getClienteImpuesto();
			$this->impuestoDocumento = $this->getDocumentoImpuesto();
		}

		public function getVentas($limit, $id , $filters ){

			if($filters){
				$filters = " and ".$filters;
			}

			$query = $this->db->query("select ventas.id,ventas.id_sucursal,ventas.id_vendedor,ventas.id_condpago,ventas.num_caja,
			ventas.num_correlativo,DATE_FORMAT(ventas.fecha, '%m/%d/%y | %H:%i') as fecha,ventas.anulado,ventas.modi_el, 
			cliente.nombre_empresa_o_compania , sucursal.nombre_sucursal,orden_estado
			,tdoc.nombre as tipo_documento,ventas.serie_correlativo,ventas.documento_numero,
			FORMAT((SELECT SUM(vp.valor_metodo_pago) FROM pos_venta_pagos AS vp WHERE vp.venta_pagos = ventas.id),2) as total_doc,
			usuario.nombre_usuario, 
			(SELECT GROUP_CONCAT(vp.nombre_metodo_pago SEPARATOR '/') FROM pos_venta_pagos AS vp WHERE vp.venta_pagos = ventas.id ) as nombre_modo_pago,
			oe.orden_estado_nombre, FORMAT(ventas.desc_val,2) as desc_val

			from pos_ventas as ventas 

			left join pos_cliente as cliente on cliente.id_cliente = ventas.id_cliente
			left join pos_sucursal as sucursal on sucursal.id_sucursal=ventas.id_sucursal
			left join pos_tipo_documento as tdoc on tdoc.id_tipo_documento = ventas.id_tipod
			left join sys_usuario as usuario on usuario.id_usuario = ventas.id_usuario
			left join pos_formas_pago as pago on pago.id_modo_pago = ventas.id_condpago 
			left join pos_orden_estado as oe  on oe.id_orden_estado= ventas.orden_estado
			where ventas.id_sucursal = ". $this->session->usuario[0]->id_sucursal ."
			and sucursal.Empresa_Suc=".$this->session->empresa[0]->id_empresa  . $filters." Order By ventas.creado_el DESC Limit ". $id.','.$limit);

		    //echo $this->db->queries[1];
		    return $query->result();
		}

		public function record_count(){

			$this->db->where('s.Empresa_Suc',$this->session->empresa[0]->id_empresa);
			$this->db->where('v.id_sucursal',$this->session->usuario[0]->id_sucursal);
			$this->db->from(self::pos_ventas.' as v');
			$this->db->join(self::sucursal.' as s',' on v.id_sucursal = s.id_sucursal');
			$result = $this->db->count_all_results();
        	return $result;
	    }

		public function get_tipo_documentos(){
			$this->db->select('*');
	        $this->db->from(self::pos_tipo_documento);
	        $query = $this->db->get(); 
	        //echo $this->db->queries[1];
	        
	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		public function get_productos_valor($sucursal ,$bodega, $texto){
	        
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

		public function get_productos_existencias($texto){
	        
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

		public function get_producto_completo($producto_id , $id_bodega ){
	        
	        $query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
	        		, A.nam_atributo, A.id_prod_atributo , pv2.valor as valor,b.id_bodega, b.nombre_bodega, pbodega.id_pro_bod AS id_inventario
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
				-- LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
				LEFT JOIN pos_producto_bodega AS pbodega ON (pbodega.Producto = P.id_entidad && pbodega.Bodega = $id_bodega)
				LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
				LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos

				WHERE P.id_entidad = ". $producto_id ." and b.id_bodega =". $id_bodega);
		        //echo $this->db->queries[0];
		        return $query->result();

		}

		public function get_producto_precios($producto_id){
	        
	        $query = $this->db->query("SELECT * from producto_detalle as pd
				WHERE pd.Producto = ". $producto_id);

		        //echo $this->db->queries[1];
		        return $query->result();

		}

		public function get_bodega($usuario){

			$query = $this->db->query("
				SELECT b.* FROM sys_empleado_sucursal es 
				left join sys_usuario as u on u.id_usuario = es.es_empleado
				left join pos_bodega as b on b.Sucursal = es.es_sucursal
				where u.id_usuario= ". $usuario );

		        //echo $this->db->queries[1];
		        return $query->result();
		}

		public function get_bodega_sucursal($Sucursal){

			$query = $this->db->query("
				SELECT b.* FROM sys_empleado_sucursal es 
				left join sys_usuario as u on u.id_usuario = es.es_empleado
				left join pos_bodega as b on b.Sucursal = es.es_sucursal
				where b.Sucursal= ". $Sucursal );

		        //echo $this->db->queries[1];
		        return $query->result();
		}

		public function correlativo_final($correlativo , $ingresado){
			
			$valor = 0;
			if ($correlativo == $ingresado) {
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

		public function guardar_venta( $orden , $id_usuario , $cliente , $form , $documento , $sucursal , $correlativo_documento, $totalDocumentos, $templateLineas){

			$correlativos_extra = 0;
			$total_orden 		= $orden['orden'][0]['total'];
			$total_orden 		= $total_orden;
			$efecto_inventario 	= $documento[0]->efecto_inventario;
			$this->_orden 		= $orden;
			$this->_totalDocumento = $totalDocumentos;
			$this->_templateLineas = $templateLineas;
			$idsVentas = array();

			/** Obtener Impuestos para cada entidad */
			$this->impDocumento = $this->evaluarDocumentoImpuesto($documento);
			$this->impCliente   = $this->evaluarClienteImpuesto($cliente[0]->id_cliente);

			/** Divir la orden por cantidad de lineas que el documento permite */
			$this->splitOrder();
			
			if($efecto_inventario == 1){ // Si suma en inventario la venta, es devolucion
				//$total_orden = $total_orden* -1;
			}			

			$siguiente_correlativo = $this->get_siguiente_correlativo( $sucursal , $documento );

			if ($siguiente_correlativo[0]) {

				$numero = 0;
				if( isset( $correlativo_documento ) ){
					$numero = $correlativo_documento ;
				}
				
				$correlativo_incremental = 0;
				foreach ($this->_orden_concetrada as $key => $items) {
					$siguiente_correlativo = $this->get_siguiente_correlativo( $sucursal , $documento );
					$correlativo_final     = $this->correlativo_final($siguiente_correlativo[0]->siguiente_valor , $numero );

					
					/**
					 *  Lista de correlativos cuando  es mas de  un documento
					 */
					if (isset($orden['correlativos_extra'])) {

						if (!$correlativo_incremental) {
							$correlativosLista = $orden['correlativos_extra'];
							$correlativo_final = $correlativosLista[$key-1];
						}else{
							$correlativo_final++;
						}
					}

					$data = array(
						'id_caja' 				=> $form['caja_id'], //terminal_id
						'id_cajero'				=> $this->session->db[0]->id_usuario,
						'num_caja' 				=> $form['caja_numero'], //terminal_numero
						'd_inc_imp0' 			=> $form['impuesto'], //impuesto
						'id_sucursal' 			=> $form['sucursal_destino'], //sucursal_destino
						'id_tipod' 				=> $documento[0]->id_tipo_documento, //modo_pago_id
						'num_correlativo'		=> $correlativo_final,
						'serie_correlativo'		=> $siguiente_correlativo[0]->numero_de_serire,
						'documento_numero'		=> $siguiente_correlativo[0]->numero_de_serire.$correlativo_final,
						'comentarios' 			=> "",
						'id_usuario' 			=> $id_usuario,
						'fecha' 				=> date("Y-m-d h:i:s"),	            
						'digi_total' 			=> $total_orden,
						'total_doc' 			=> $total_orden,
						'dinero_cobrado'		=> $orden['orden'][0]['total_dinero'],
						'dinero_cambio'			=> $orden['orden'][0]['total_cambio'],
						'iva'					=> $orden['orden'][0]['iva'],
						'desc_porc' 			=> $orden['orden'][0]['descuento_limite'],
						'id_bodega' 			=> $orden['orden'][0]['id_bodega'],
						'desc_val' 				=> $orden['orden'][0]['descuento_calculado'],
						'nombre' 				=> $form['cliente_nombre'], //cliente_nombre
						'id_cliente' 			=> $form['cliente_codigo'], //cliente_codigo
						'id_sucursal_origin' 	=> $form['sucursal_origin'], //sucursal_origin	
						'direccion' 			=> $form['cliente_direccion'], //cliente_direccion
						'id_condpago' 			=> $form['modo_pago_id'], //modo_pago_id
						'id_vendedor' 			=> $form['vendedor'], //vendedor
						'id_venta_orden'		=> (isset($form['orden_numero'])) ? $form['orden_numero'] : 0 ,
						'doc_cliente_nombre'	=> $form['doc_cli_nombre'],
						'doc_cliente_identificacion' => $form['doc_cli_identificacion'],
						'devolucion_nombre' 	=> $form['devolucion_nombre'],
						'input_devolucion_id'   => $form['input_devolucion_id'],
						'devolucion_documento' 	=> $form['devolucion_documento'],
						'devolucion_dui' 		=> $form['devolucion_dui'],
						'devolucion_nit' 		=> $form['devolucion_nit'],
						'venta_vista_id'		=> $form['vista_id'],
						'fh_inicio' 			=> date("Y-m-d h:i:s"),
						'fh_final' 				=> date("Y-m-d h:i:s"),
						'creado_el' 			=> date("Y-m-d h:i:s"),
						'fecha_inglab' 			=> date("Y-m-d h:i:s"),
						'modi_el' 				=> date("Y-m-d h:i:s"),
						'orden_estado'			=> $orden['estado'], // Facturada
						'facturado_el' 			=> 0, // Actualizara al procesar la venta
						'anulado' 				=> 0, // Actualizara al procesar alguna accion
						//'anulado_el' 			=> "", // Actualizara al procesar alguna accion
						//'anulado_conc'		=> "", // Actualizara al procesar alguna accion
						//'cod_estado'			=> "0",
						//'estado_el' 			=> "0",
						//'reserv_producs' 		=> "0",
						//'reserv_conc' 		=> "0",
						//'fecha_entreg' 		=> date("Y-m-d h:i:s"),
						//'tiempoproc' 			=> "0",
						//'modi_el' 			=> "0",
						
					);

					/* GUARDAR ENCABEZADO DE LA VENTA */
					$result = $this->db->insert(self::pos_ventas, $data );
					if (!$result) {
						$result = $this->db->error();
						return $result;
					}

					$this->_orden_id = $this->db->insert_id();

					$idsVentas[] = $this->_orden_id;

					if ($result) {

						/* GUARDAR DETALLE DE LA VENTA - PRODUCTOS */
						$total_monto =  $this->guardar_venta_detalle( $efecto_inventario , $items);
						$this->impuestosLista = [];

						/* GUARDAR IMPUESTOS GENERADOS EN LA VENTA */
						$this->save_venta_impuestos( 2);
						
						
						/* INCREMENTO CORRELATIVOS AUTOMATICOS */
						//if ($correlativo_documento == $siguiente_correlativo[0]->siguiente_valor) {
							$this->incremento_correlativo( $siguiente_correlativo[0]->siguiente_valor, $sucursal , $documento[0]->id_tipo_documento);
						//}
					}
				}

				/* PROCESAR EFECTOS DE INVENTARIO SOBRE TIPO DOCUMENTO EN BODEGA */
				//$this->efecto_bodega($this->_orden_id , $orden ,$documento);
			}else{
				echo "No hay correlativo";
			}

			return $idsVentas;
		}

		public function save_venta_impuestos($impTipo){
			/* 
				Insertando los impuestos generados en la vista de Ventas rapidas.
				$impTipo = 1 -> Orden
				$impTipo = 2 -> Venta Rapida
			*/

			/*if(isset($this->_orden['impuestos'])){
				foreach ($this->_orden['impuestos'] as $impuestos_datos) {
					foreach ($impuestos_datos as $key => $value) {
						
						$data = array(
							'id_venta' 		=> $this->_orden_id, 
							'ordenEspecial' => $value['ordenEspecial'],
							'ordenImpName' 	=> $value['ordenImpName'],
							'ordenImpTotal' => $value['ordenImpTotal'],
							'ordenImpVal' 	=> $value['ordenImpVal'],
							'ordenSimbolo' 	=> $value['ordenSimbolo'],
							'vent_imp_tipo' => $impTipo ,
							'vent_imp_estado' => 1
						);

						$this->db->insert(self::pos_ventas_impuestos, $data );
					}
				}	
			}		*/
		}

		public function sumVentaImpuesto($producto)
		{
			/*$impuestoData = $this->evaluarProductoImpuesto($producto);

			if($impuestoData)
			{
				$data = array(
					'id_venta' 		=> $this->_orden_id, 
					'ordenEspecial' => $impuestoData['ordenEspecial'],
					'ordenImpName' 	=> $impuestoData['ordenImpName'],
					'ordenImpTotal' => $impuestoData['ordenImpTotal'],
					'ordenImpVal' 	=> $impuestoData['ordenImpVal'],
					'ordenSimbolo' 	=> $impuestoData['ordenSimbolo'],
					'vent_imp_tipo' => 2 ,
					'vent_imp_estado' => 1
				);
				$this->db->insert(self::pos_ventas_impuestos, $data );
			}*/
		}

		public function procesarCalculoImpuesto($categoriasImpuestos)
		{
			/** Evalauar impuesto de cada categoria con impDocumento, impCliente */
			$dataResult	= [];
			$contador 	= 0;
			foreach ($categoriasImpuestos as $uno => $categoria) {

				$result1 = array_filter(
					$this->impDocumento,
					function($documento,$valor) use ($categoria){
						if($documento->nombre == $categoria->nombre){
							return $categoria;
						}
					}, ARRAY_FILTER_USE_BOTH
				);

				$result2 = array_filter(
					$this->impCliente,
					function($cliente,$valor) use ($categoria){
						if($cliente->nombre == $categoria->nombre){
							return $categoria;
						}
					}, ARRAY_FILTER_USE_BOTH
				);

				//var_dump($result1);echo "<hr>";
				//var_dump($this->impCliente);echo "<hr>";
				if (!$result1 || !$result2) {
					unset($dataResult[$contador]);
				}else{
					$dataResult[$contador] = $categoria;
					$contador++;
				}
				$result1 = null;
				$result2 = null;
			}
			return $dataResult;
		}

		public function evaluarDocumentoImpuesto($documento)
		{
			$flag = false;
			$documentoId = $documento[0]->id_tipo_documento;
			//var_dump($this->impuestoDocumento);die;
			$data = array_filter(
				$this->impuestoDocumento,
				function($impuesto,$valor) use ($documentoId){
					if($impuesto->Documento == $documentoId && $impuesto->estado !=0){
						return $impuesto;
					}
				}, ARRAY_FILTER_USE_BOTH
			);
			return $data;
		}

		public function evaluarCategoriaImpuesto($categoria)
		{
			//var_dump("Viene con ->", $categoria['categoria']);
			$data = array_filter(
				$this->impuestoCategoria,
				function($impuesto,$valor) use ($categoria){
					if ($impuesto->Categoria == $categoria['categoria'] && $impuesto->estado !=0) {
						
						return $impuesto;
					}
				}, ARRAY_FILTER_USE_BOTH
			);
			//var_dump("Retorno ->", $data);
			return $data;
		}

		public function evaluarProveedorImpuesto($proveedor)
		{
			$data = array_filter(
				$this->impuestoProveedor,
				function($impuesto,$valor) use ($proveedor){
					if($impuesto->Proveedor == $proveedor['proveedor'] && $impuesto->estado !=0){
						return $impuesto->Proveedor;
					}
				}, ARRAY_FILTER_USE_BOTH
			);
			return $data;
		}

		public function evaluarClienteImpuesto($cliente)
		{

			$data = array_filter(
				$this->impuestoCliente,
				function($impuesto,$valor) use ($cliente){
					if($impuesto->Cliente == $cliente && $impuesto->estado !=0){
						return $impuesto;
					}
				}, ARRAY_FILTER_USE_BOTH
			);

			return $data;
		}

		public function save_forma_pago($total_monto ){

			foreach ($this->_orden['pagos'] as $key => $metodoPago) {

				if($metodoPago['amount'] != "") {
						
					$data = array(
						'venta_pagos' 		=> $this->_orden_id , 
						'id_forma_pago' 	=> $metodoPago['id'],
						'nombre_metodo_pago'=> $metodoPago['type'],
						'valor_metodo_pago' => $metodoPago['amount'],
						'banco_metodo_pago' => $metodoPago['banco'],
						'numero_metodo_pago'=> $metodoPago['valor'],
						'series_metodo_pago'=> $metodoPago['serie'],
						'estado_venta_pago' => 1
					);

					$this->db->insert(self::pos_venta_pagos, $data );

				}
					if (count($this->_orden_concetrada) > 1) {
						unset($this->_orden['pagos'][$key]);
						break;
					}
			}
		}

		/**
		 * @param $efecto_inventario
		 * @param $templateLineas
		 */
		public function guardar_venta_detalle( $efecto_inventario, $items){
			$contador    = 1;
			$total_monto = 0.00;
			$this->impuestosLista = [];
			foreach ($items as $orden) {

				$_total =  (double) $orden['total'] - (double) $orden['descuento_calculado'];
				$orden['total'] = $_total;

				$total_monto += ($efecto_inventario == 1) ? ( $_total * 1 ) : $_total;

				/** Obtener impuestos para entidad Categoria */
				$impCategoria = $this->evaluarCategoriaImpuesto($orden);
				
				/** Verificar si impuesto aplica */
				$impuestos = $this->procesarCalculoImpuesto($impCategoria);
				
				/** Calcular Impuesto IVA */
				$this->calculoImpuestoIva($orden, $impuestos, $total_monto);

				$descuento_porcentaje = $orden['descuento'] ? $orden['descuento'] : 0.00;				
				
				$data = array(
					'id_venta' 		=> $this->_orden_id,
					'producto' 		=> $orden['producto'],
					'producto_id' 	=> $orden['producto_id'],
					'producto2' 	=> $orden['producto2'],
					'inventario_id' => $orden['inventario_id'],
					'id_bodega' 	=> $orden['id_bodega'],
					'categoria'		=> $orden['categoria'],
					'bodega' 		=> $orden['bodega'],
					'combo' 		=> $orden['combo'],
					'combo_total'	=> $orden['combo_total'],
					'invisible' 	=> $orden['invisible'],
					'descripcion' 	=> $orden['descripcion'],
					'presenta_ppal' => $orden['presentacion'],
					'cantidad' 		=> $orden['cantidad'],
					'presentacion' 	=> $orden['presentacion'],
					'tipoprec' 		=> $orden['presentacion'],
					'precioUnidad' 	=> ($efecto_inventario == 1) ?  ($orden['precioUnidad']* 1): $orden['precioUnidad'],
					'factor' 		=> $orden['presentacionFactor'],
					'total' 		=> ($efecto_inventario == 1) ? ( $_total * 1 ) : $_total ,
					'impSuma'		=> $orden['impSuma'],
					'gen' 			=> $orden['gen'],
					'descuento' 	=> $orden['descuento'] ,
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
					'p_inc_imp0' 	=> $orden['iva'],		            
				);

				$this->db->insert(self::pos_venta_detalle, $data );
				$contador++;
			}

			foreach ($this->impuestosLista as $lista) 
			{
				$this->db->insert(self::pos_ventas_impuestos, $lista );
			}

			/* GUARDAR FORMATOS DE PAGO */
			$this->save_forma_pago( $total_monto);
			
			return $total_monto;
		}

		private function calculoImpuestoIva($item,$impuestos,$total_monto)
		{
			//var_dump($impuestos);die;
			$data = array();
			$total_positivo = 0;
			$_iva = array_filter(
				$impuestos,
				function($impuesto,$valor){
					if($impuesto->nombre == "IVA"){
						return $impuesto;
					}
				}, ARRAY_FILTER_USE_BOTH
			);
			
			if(isset($_iva[0])){
				$impuesto_iva = $_iva[0];
			}
			//var_dump($impuestos);die;
			
			$Total = 0;
			if ($_iva[0]->nombre == "IVA") {
				//$total_positivo =  ( $item['total'] * (-1) );
				$Total = ($impuesto_iva->porcentage * $item['total']) / ($impuesto_iva->porcentage + 1);

				if($item['tipo'] =='E'){
					$Total = $item['total'];
				}

				$impSimbolo = substr($item['gen'],0,1);

				$data = array(
					'id_venta' 		=> $this->_orden_id, 
					'ordenEspecial' => 0,
					'ordenImpName' 	=> $impuesto_iva->nombre,
					'ordenImpTotal' => $Total,
					'ordenImpVal' 	=> $impuesto_iva->porcentage,
					'ordenSimbolo' 	=> $impSimbolo,
					'vent_imp_tipo' => 2 ,
					'vent_imp_estado' => 1
				);

				if (!isset($this->impuestosLista[$impuesto_iva->nombre.$impSimbolo])) {
					$this->impuestosLista[$impuesto_iva->nombre.$impSimbolo] = $data;	
				}else{
					$this->impuestosLista[$impuesto_iva->nombre.$impSimbolo]['ordenImpTotal'] += $Total;
				}
			}

			$_impuesto = array_filter(
				$impuestos,
				function($impuesto,$valor){
					if($impuesto->nombre != "IVA"){
						return $impuesto;
					}
				}, ARRAY_FILTER_USE_BOTH
			);

			$flag = false;
			foreach ($_impuesto as $key => $impuesto) {
				$Total = 0.00;
				$total_positivo = abs($total_monto);
				if ( $impuesto->condicion == 1) {

					if ( $impuesto->condicion_simbolo == ">=") {
						if ( $total_positivo >= $impuesto->condicion_valor) {
							$Total = $impuesto->porcentage * $total_monto;
							$flag = true;
						}

					}else if($impuesto->condicion_simbolo == "<="){

						if ( $total_monto <= $impuesto->condicion_valor) {
							$Total = $impuesto->porcentage * $total_monto;
							$flag = true;
						}
					}
				}else{
					
					if($impuesto->especial == 1){
						$Total = $item['cantidad'] * $impuesto->porcentage;
					}else{
						$Total = $impuesto->porcentage * $item['total'];
					}
				}

				$data = array(
					'id_venta' 		=> $this->_orden_id, 
					'ordenEspecial' => 0,
					'ordenImpName' 	=> $impuesto->nombre,
					'ordenImpTotal' => $Total,
					'ordenImpVal' 	=> $impuesto->porcentage,
					'ordenSimbolo' 	=> substr($item['gen'],0,1),
					'vent_imp_tipo' => 2 ,
					'vent_imp_estado' => 1
				);

				if($impuesto->nombre != "IVA")
				{
					if (!isset($this->impuestosLista[$impuesto->nombre])) 
					{
						if ( $Total > 0 || $total_positivo > 0) {
							$this->impuestosLista[$impuesto->nombre] = $data;
						}
					}
					else
					{
						if ( $Total > 0 || $total_positivo > 0) {
							if($flag){
								$this->impuestosLista[$impuesto->nombre]['ordenImpTotal'] = $Total;
							}else{
								$this->impuestosLista[$impuesto->nombre]['ordenImpTotal'] += $Total;
							}
						}
					}
				}
			}

			/**
			 * Recarcular IVA para Combustibles
			 */
			$impCombustibles = (array) array_filter(
				$impuestos,
				function($impuesto,$valor){
					if($impuesto->es_combustible == 1){
						return $impuesto;
					}
				}, ARRAY_FILTER_USE_BOTH
			);

			if ($impCombustibles) {
				$impSimbolo = substr($item['gen'],0,1);
				$totalImpCombustible = array_sum(array_column($impCombustibles, 'porcentage'));
				$totalImpCombustible = $totalImpCombustible * $item['cantidad'];
				$totalIvaCombustible = $total_monto - $totalImpCombustible;
				$totalIvaCombustible = $totalIvaCombustible * $impuesto_iva->porcentage / ($impuesto_iva->porcentage + 1);

				$this->impuestosLista[$impuesto_iva->nombre.$impSimbolo]['ordenImpTotal'] = $totalIvaCombustible;
			}
			//var_dump($this->impuestosLista);die;
		}

		/** INICIAR CON LA DIVISION DE PRODUCTOS POR DOCUMENTOS Y SUS CALCULOS */

		private function splitOrder(){
			$contadorLinea = 1;
			$contadorDocumento = 1;

			foreach ($this->_orden['orden'] as $key => $ordenItem) {
				
				if ($contadorLinea <= (int) $this->_templateLineas) {

					$this->_orden_concetrada[$contadorDocumento][] = $ordenItem;
					
					if($contadorLinea == $this->_templateLineas){
						$contadorDocumento++;
						$contadorLinea=1;
					}else{
						$contadorLinea++;
					}
				}
			}
		}

		private function getImpuesto(){
			$this->db->select('*');
	        $this->db->from(self::impuestos);
	        $this->db->where('imp_empresa', $this->session->empresa[0]->id_empresa );
	        $query = $this->db->get(); 

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		private function getClienteImpuesto(){
			$this->db->select('impuesto.*,tipo_impuesto.*,cliente.id_cliente,emp.id_empresa');
			$this->db->from(self::impuestos_cliente.' as impuesto');
			$this->db->join('pos_tipos_impuestos as tipo_impuesto', 'tipo_impuesto.id_tipos_impuestos = impuesto.Impuesto');
			$this->db->join('pos_cliente as cliente', 'cliente.id_cliente = impuesto.Cliente');
			//$this->db->join('pos_empresa as empresa', 'empresa.id_empresa = cliente.id_cliente');
			$this->db->join('sys_persona as persona', 'persona.id_persona = cliente.Persona');
			$this->db->join('pos_empresa as emp', 'emp.id_empresa = persona.Empresa');
	        $this->db->where('emp.id_empresa', $this->session->empresa[0]->id_empresa );
			$query = $this->db->get();
			//echo $this->db->queries[2];die;

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		private function getDocumentoImpuesto(){
			$this->db->select('impuestos.*,tipo_impuesto.*,tipoDocumento.id_tipo_documento,empresa.id_empresa');
			$this->db->from(self::impuestos_documento.' as impuestos');
			$this->db->join('pos_tipos_impuestos as tipo_impuesto', 'tipo_impuesto.id_tipos_impuestos = impuestos.Impuesto');
			$this->db->join('pos_tipo_documento as tipoDocumento', 'tipoDocumento.id_tipo_documento = impuestos.Documento');
			$this->db->join('pos_empresa as empresa', 'empresa.id_empresa = tipoDocumento.Empresa');
	        $this->db->where('empresa.id_empresa', $this->session->empresa[0]->id_empresa );
			$query = $this->db->get();

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		public function get_impuestos_venta( $venta_id )
		{
			$this->db->select('*');
			$this->db->from(self::pos_ventas_impuestos);
			$this->db->where('id_venta', $venta_id);
			$query = $this->db->get();
			
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		private function getCategoriaImpuesto(){
			$this->db->select('categoria.*,impuesto.*,c.*,empresa.id_empresa');
			$this->db->from(self::impuestos_categoria.' as categoria');
			$this->db->join('pos_tipos_impuestos as impuesto', 'impuesto.id_tipos_impuestos = categoria.Impuesto');
	        $this->db->join('categoria as c', 'c.id_categoria = categoria.Categoria');
			$this->db->join('pos_empresa as empresa', 'empresa.id_empresa = c.Empresa');
	        $this->db->where('empresa.id_empresa', $this->session->empresa[0]->id_empresa );
	        $query = $this->db->get(); 

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}

		private function getProveedorImpuesto(){
			$this->db->select('*');
	        $this->db->from(self::impuestos_proveedor);
	        $this->db->where('EmpresaProveedor', $this->session->empresa[0]->id_empresa );
	        $query = $this->db->get(); 

	        if($query->num_rows() > 0 )
	        {
	            return $query->result();
	        }
		}
		/** FIN DIVISION DE PRODUCTOS POR DOCUMENTOS */

		public function regreso_a_bodega( $orden ){

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

		public function get_cantidad_bodega( $id_producto , $id_bodega ){

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

		public function update($orden , $id_usuario , $cliente){

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

		public function get_orden( $order_id ){

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

		public function guardar_orden_detalle($id_orden, $datos)
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
					'total' 		=> $orden['total'],
					'gen' 			=> $orden['gen'],				
					'descuento' 		=> $orden['descuento'],
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

		public function delete_orden_detalle( $ordern_id ){
			$data = array(
	            'id_orden' => $ordern_id,
	        );

        	$this->db->delete(self::pos_ordenes_detalle, $data);

		}

		public function get_siguiente_correlativo($sucursal , $documento){
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

		public function get_orden_detalle( $order_id ){

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

		public function incremento_correlativo($numero,  $sucursal , $documento ){
			
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

		public function producto_precios( $id_producto, $producto ){
			$costo = 0.00;
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

		public function sub_categoria( $id_categoria ){
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

		public function get_producto( $id_producto ){

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

		public function actualizar_producto( $producto ){

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
		public function actualizar_categoria_producto($id_sub_categoria , $id_producto ){
			$data = array(
	            'id_categoria' => $id_sub_categoria,	            
	        );

			$this->db->where('id_producto', $id_producto);
			$this->db->update(self::categoria_producto, $data );
		}

		// Actualizar producto
		public function actualizar_proveedor_producto($id_proveedor , $id_producto ){
			$data = array(
	            'proveedor_id_proveedor' => $id_proveedor,
	        );

			$this->db->where('producto_id_producto', $id_producto);
			$this->db->where('proveedor_id_proveedor', $id_proveedor);
			$this->db->update(self::pos_proveedor_has_producto, $data );
		}

		public function actualizar_proveedor_producto2($id_proveedor , $id_producto ){
			$data = array(
	            'proveedor_id_proveedor' => $id_proveedor,
	        );

			$this->db->where('producto_id_producto', $id_producto);
			$this->db->where('proveedor_id_proveedor', $id_proveedor);
			$this->db->update(self::pos_proveedor_has_producto, $data );
		}

		// Actualizar Atributos
		public function producto_atributo_actualizacion( $id_producto , $producto ){
			
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
		public function producto_precios_actualizacion( $id_producto , $producto ){

			$data = array(
	            'Producto' => $id_producto,
	        );

	        $this->db->delete(self::producto_detalle, $data); 

	        $this->producto_precios( $id_producto , $producto );
		}

		// Actualizar producto valor
		public function actualizar_producto_valor( $id_prod_atrri, $producto_valor ){
			$data = array(
	            'valor' => $producto_valor,
	        );

			$this->db->where('id_prod_atributo', $id_prod_atrri);
			$this->db->update(self::producto_valor, $data );
		}

		// Actualizar Imagen del producto
		public function producto_imagen_actualizar( $producto_id , $imagen ){

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

		public function getConfg($componente_conf){

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

		public function getConfgImpuesto($impuesto_conf){

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

		public function getVentaId($id_venta){

			$query = $this->db->query("select correlativo.*,ventas.id,ventas.id_cajero,ventas.id_sucursal,ventas.id_vendedor,ventas.id_condpago,ventas.num_caja,id_tipod,id_condpago,
			ventas.num_correlativo,ventas.fecha,ventas.anulado,ventas.modi_el, cliente.nombre_empresa_o_compania ,cliente.direccion_cliente, 
			sucursal.nombre_sucursal,orden_estado ,tdoc.nombre as tipo_documento,tdoc.copias, usuario.nombre_usuario, pago.nombre_modo_pago, 
			oe.orden_estado_nombre, empresa.nombre_comercial, empresa.direccion,empresa.nrc,empresa.nit,giro.nombre_giro, giro.nombre_giro as
			giro, emp.alias, t.nombre as terminal ,ventas.id_cliente , ventas.total_doc ,cliente.nit_cliente, cliente.nrc_cli,ventas.documento_numero,
			venta_vista_id,ventas.devolucion_documento,ventas.doc_cliente_nombre,doc_cliente_identificacion,ventas.devolucion_nombre,ventas.serie_correlativo,
			ventas.devolucion_dui, ventas.devolucion_nit, ventas.desc_val, ventas.dinero_cobrado,ventas.dinero_cambio, anulado,anulado_el, anulado_conc,modi_el,caja.*,
			(select pe.primer_nombre_persona as anulado_nombre from sys_usuario as us left join sys_empleado as em on us.Empleado = em.id_empleado 
			left join sys_persona as pe on pe.id_persona = em.Persona_E WHERE us.id_usuario = anulado_por ) as anulado_nombre

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
			LEFT JOIN pos_correlativos AS correlativo ON correlativo.TipoDocumento = ventas.id_tipod
			where correlativo.Sucursal = ventas.id_sucursal AND ventas.id=".$id_venta);

		    //echo $this->db->queries[1];die;
		    return $query->result();
		}

		public function getVentaDetalleId($id_venta){
			$query = $this->db->query("select *
				from pos_venta_detalle as vd
				left join producto as p ON p.id_entidad = vd.producto_id	
				left join pos_bodega as b on b.id_bodega = vd.id_bodega
				where vd.id_venta =".$id_venta);

		    //echo $this->db->queries[1];
		    return $query->result();
		}

		public function getVentaPagosId( $id_venta ){
			$query = $this->db->query("select *

			from pos_venta_pagos where venta_pagos =".$id_venta);

		    //echo $this->db->queries[1];
		    return $query->result();
		}

		public function get_venta($venta){

			//$valores =  explode(",", $venta);
		
			$this->db->select('*');
			$this->db->from(self::pos_ventas . ' as v');
			$this->db->join(self::pos_venta_detalle . ' as vd',' on v.id = vd.id_venta');
			//$this->db->where('o.orden_estado != 4');
			$this->db->where_in('v.id', $venta );
			$query = $this->db->get();
			//echo $this->db->queries[0];

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		public function get_venta_by_id($venta){

			$this->db->select('*');
			$this->db->from(self::pos_ventas . ' as v');
			$this->db->join(self::pos_venta_detalle . ' as vd',' on v.id = vd.id_venta');
			//$this->db->where('o.orden_estado != 4');
			$this->db->where_in('v.id', $venta );
			$query = $this->db->get();
			//echo $this->db->queries[0];

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		public function setVentaToAnulada($venta_data){
			$data = array(
				'anulado'		=> 1,
				'anulado_el'	=> date("Y-m-d h:i:s"),	
				'modi_el'		=> date("Y-m-d h:i:s"),	
				'anulado_por' 	=> $this->session->db[0]->id_usuario,
				'anulado_conc'	=> $venta_data['nota_anulacion'],
				'orden_estado'	=> 7
			);

			$this->db->where('id', $venta_data['id'] );
			$result = $this->db->update(self::pos_ventas, $data );
			
			if(!$result){
				$result = $this->db->error();
				return $result;
			}
			return $result;
		}

		/**
		 * Verificar si correlativo no se ha utilizado en ventas previas
		 *
		 * @param array $params
		 * @return void
		 */
		public function check_correlativo(array $params) {

			$this->db->select('v.*,td.nombre');
			$this->db->from(self::pos_ventas. ' as v');
			$this->db->join(self::pos_correlativos. ' as c', ' on c.Sucursal = v.id_sucursal');
			$this->db->join(self::pos_tipo_documento. ' as td', ' on td.id_tipo_documento = v.id_tipod');
			$this->db->where('v.id_sucursal', 		$params['input_sucursal']);
			$this->db->where('v.id_tipod',			$params['documento'] );
			$this->db->where('v.num_correlativo', 	$params['correlativo'] );
			$this->db->where('c.numero_de_serire = v.serie_correlativo');
			$query = $this->db->get();
			//echo $this->db->queries[4];

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		/**
		 * Verificar si correlativo no se ha utilizado en ventas previas
		 *
		 * @param array $params
		 * @return void
		 */
		public function check_venta(array $params) {

			$this->db->select('v.id');
			$this->db->from(self::pos_ventas. ' as v');
			$this->db->where('v.documento_numero', 	$params['id'] );
			$this->db->where('v.id_tipod', $params['documento_id'] );
			$query = $this->db->get();
			//echo $this->db->queries[4];

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		public function ventasIntegracion()
		{
			/* obtener ventas que no se han integrado aun */
			$this->db->select('v.*');
			$this->db->from(self::pos_ventas.' as v');
			$this->db->join(self::pos_ventas_integracion.' as i', ' ON v.id = i.id_venta_local', 'left');
			$this->db->where('i.id_venta_local is null');
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		public function ventasRegistro($ventasIntegradas)
		{
			/**
			 * Aqui se ingresan todas las ventas que fueron procesadas por el endPoint the ordenes a produccion
			 */
			$config = $this->config_integrador_empresa();
			$ventasIds = [];

			foreach ($ventasIntegradas as $key => $value) {
				$ventasIntegradas[$key]->id_empresa = $config[0]->valor_config;
				$ventasIntegradas[$key]->creado = date("Y-m-d H:i:s");
				
				$this->db->trans_begin();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
				} else {
					$ventasIds[] = $ventasIntegradas[$key]->id_venta_local;
					$this->db->insert(self::pos_ventas_integracion,$value);
					$this->db->trans_commit();
				}
			}
			return $ventasIds;
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

		public function get_ventas_in($ventaIds)
		{
			$this->db->select('*');
			$this->db->from(self::pos_venta_detalle);
			$this->db->where_in('id_venta', $ventaIds);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		public function get_ventas_impuestos($ventaIds)
		{
			$this->db->select('*');
			$this->db->from(self::pos_ventas_impuestos);
			$this->db->where_in('id_venta', $ventaIds);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}

		public function get_ventas_pagos($ventaIds)
		{
			$this->db->select('*');
			$this->db->from(self::pos_venta_pagos);
			$this->db->where_in('venta_pagos', $ventaIds);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}		
    }