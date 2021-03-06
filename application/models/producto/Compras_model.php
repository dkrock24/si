<?php
class Compras_model extends CI_Model
{
	const sucursal		 	 = 'pos_sucursal';
	const producto		 	 =  'producto';
	const pos_bodega		 = "pos_bodega";
	const pos_compras		 = "pos_compras";
	const pos_empresa		 = 'pos_empresa';
	const pos_doc_temp		 = 'pos_doc_temp';
	const pos_temp_suc		 = 'pos_temp_sucursal';
	const sys_traslados		 = "sys_traslados";
	const producto_detalle	 = 'producto_detalle';
	const pos_tipo_documento = 'pos_tipo_documento';
	const pos_compras_detalle	= "pos_compras_detalle";
	const sys_traslados_detalle	= "sys_traslados_detalle";
	const pos_compras_impuestos = 'pos_compras_impuestos';
	const pos_orden_estado = 'pos_orden_estado';

	private $_orden;

	function getCompras($limit, $id, $filters)
	{
		if ($filters) {
			$filters = " and " . $filters;
		}
		$query = $this->db->query("select c.*,es.*,s.*,b.*,prov.*, CONCAT(p.primer_nombre_persona, ' ', p.primer_apellido_persona) as recibe ,
			CONCAT(p2.primer_nombre_persona, ' ', p2.primer_apellido_persona) as envia , p.id_persona as id1, p2.id_persona as id2,
			td.nombre as Documento,
			DATE_FORMAT(c.fecha_creacion, '%m/%d/%Y') as fecha_creacion,
			DATE_FORMAT(c.fecha_compra, '%m/%d/%Y') as fecha_compra
			from pos_compras as c
			left join sys_persona as p On p.id_persona = c.Usuario 
			left join sys_persona as p2 On p2.id_persona = c.Empleado
			left join pos_sucursal as s On  s.id_sucursal = c.Sucursal
			left join pos_bodega as b On b.Sucursal = s.id_sucursal
			left join pos_proveedor as prov On prov.id_proveedor = c.Proveedor
			left join pos_tipo_documento as td On td.id_tipo_documento = c.Tipo_Documento
			left join pos_orden_estado as es On es.id_orden_estado = c.status_open_close
			where  c.Empresa ="
			. $this->session->empresa[0]->id_empresa . $filters . " 
			AND  b.id_bodega = (SELECT bodega FROM pos_compras AS compras WHERE id_compras = c.id_compras)
			ORDER BY id_compras desc Limit " . $id . ',' . $limit);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function record_count($filter)
	{
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa . ' ' . $filter);
		$this->db->from(self::pos_compras);

		$result = $this->db->count_all_results();
		return $result;
	}

	function get_productos_valor($texto)
	{
		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*,  m.nombre_marca, pde.presentacion , pde.cod_barra as pres_cod_bar , pde.id_producto_detalle, pde.precio
				FROM `producto` as `P`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN producto_detalle AS `pde` ON pde.Producto = P.id_entidad				
				WHERE P.Empresa = ". $this->session->empresa[0]->id_empresa ." and pde.estado_producto_detalle=1 and 
				    (
					P.name_entidad LIKE '%$texto%'||
					P.codigo_barras LIKE '%$texto%'||
					P.descripcion_producto LIKE '%$texto%'
					)
				");

		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_producto_completo($producto_id)
	{
		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
		, b.id_bodega, b.nombre_bodega
		, tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage ,
		 `sub_c`.`id_categoria` as 'categoria',pde.presentacion,pde.factor,pde.precio,pde.unidad

		FROM `producto` as `P`
		LEFT JOIN `producto_atributo` as `PA` ON `P`.`id_entidad` = `PA`.`Producto`
		LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
		LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
		LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
		LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
		LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
		LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
		LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
		LEFT JOIN `pos_producto_bodega` as `pb` ON `pb`.`Producto` = `P`.`id_entidad`
		LEFT JOIN `pos_bodega` as `b` ON `b`.`id_bodega` = `pb`.`Bodega`
		LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
		LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
		LEFT JOIN producto_detalle AS pde ON pde.Producto = P.id_entidad

		WHERE pde.id_producto_detalle = " . $producto_id . " and pde.estado_producto_detalle =1");
		//echo $this->db->queries[3];die;
		return $query->result();
	}

	public function getCompra($referencia=null , $proveedor=null){
		$this->db->select('*');
		$this->db->from(self::pos_compras . ' as c');		
		$this->db->where('documento_referencia', $referencia );
		$this->db->where('Proveedor', $proveedor );
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	function guardar_compra($datos , $compra){

		$registros = $this->getCompra($compra['documento_referencia'],$compra['proveedor']);

		if(!$registros){
			$fecha 		= date_create();
			$usuario_id = $this->session->usuario[0]->id_empleado;
			$this->_orden = $datos;
			
			$data = array(
				'Usuario' 		=> $usuario_id,
				'Empleado' 		=> $usuario_id,
				'Sucursal' 		=> $compra['sucursal'],
				'Bodega' 		=> $compra['bodega'],
				'Proveedor' 	=> $compra['proveedor'],
				'modo_pago_id' 	=> $compra['modo_pago_id'],			
				'numero_serie' 	=> date_timestamp_get($fecha),
				'documento_referencia' => $compra['documento_referencia'],
				'fecha_compra' 	=> $compra['fecha_compra'],
				'Tipo_Documento'=> $compra['id_tipo_documento'],
				'Empresa'		=> $this->session->empresa[0]->id_empresa,
				'fecha_creacion'=> date("Y-m-d h:i:s"),
				'status_open_close' => $compra['compra_estado'],
			);
			
			$result = $this->db->insert(self::pos_compras, $data );
	
			if($result){
				$compra_id = $this->db->insert_id();
				$this->guardar_compra_detalle($compra_id ,$datos);
				$this->save_compra_impuestos($compra_id , 2);
				return $compra_id;
			}else{
				$result = $this->db->error();
			}
	
			return $result;
		}else{
			return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
		}		
	}

	function guardar_compra_detalle($compra_id ,$detalle){

		$records = $detalle['orden'];

		foreach ($records as $key => $datos) {
			$data = array(
				'id_compra' 			=> $compra_id,
				'id_producto' 			=> $datos['producto_id'],			
				'total_pro_compra' 		=> $datos['total'],
				'id_producto_detalle' 	=> $datos['id_producto_detalle'],
				'presentacionPrecio' 	=> $datos['presentacionPrecio'],
				'presentacionUnidad' 	=> $datos['presentacionUnidad'],
				'cantidad_pro_compra'	=> $datos['cantidad'],
				'presentacionFactor'	=> $datos['presentacionFactor'],
				'presentacionCodBarra'	=> $datos['presentacionCodBarra'],
				'combo'					=> $datos['combo'],
				'impuesto_id'			=> $datos['impuesto_id'],
				'por_iva'				=> $datos['por_iva'],
				'categoria'				=> $datos['categoria'],
				'total_anterior'		=> $datos['total_anterior'],
				'impSuma'				=> $datos['impSuma'],
			);
			$this->db->insert(self::pos_compras_detalle, $data );			
		}
	}

	function save_compra_impuestos($compra_id, $impTipo){
		/* 
			Insertando los impuestos generados en la vista de Ventas rapidas.
			$impTipo = 1 -> Orden
			$impTipo = 2 -> Venta Rapida
		*/
		if(isset($this->_orden['impuestos'])){
			foreach ($this->_orden['impuestos'] as $impuestos_datos) {

				foreach ($impuestos_datos as $key => $value) {
					
					$data = array(
						'id_compra' 		=> $compra_id, 
						'compraEspecial' 	=> $value['ordenEspecial'],
						'compraImpName' 	=> $value['ordenImpName'],
						'compraImpTotal' 	=> $value['ordenImpTotal'],
						'compraImpVal' 		=> $value['ordenImpVal'],
						'compraSimbolo' 	=> $value['ordenSimbolo'],
						'compra_imp_tipo' 	=> $impTipo ,
						'compra_imp_estado' => 1
					);

					$this->db->insert(self::pos_compras_impuestos, $data ); 
				}
			}	
		}		
	}

	function editar_compra($compra_id)
	{
		//var_dump($compra_id); die;
		$query = $this->db->query("select c.*,s.*,b.*,prov.*, CONCAT(p.primer_nombre_persona, ' ', p.primer_apellido_persona) as recibe ,
				CONCAT(p2.primer_nombre_persona, ' ', p2.primer_apellido_persona) as envia , p.id_persona as id1, p2.id_persona as id2,
				td.nombre as Documento, emp.*
				from pos_compras as c
				left join sys_persona as p On p.id_persona = c.Usuario 
				left join sys_persona as p2 On p2.id_persona = c.Empleado
				left join pos_sucursal as s On  s.id_sucursal = c.Sucursal
				left join pos_bodega as b On b.Sucursal = s.id_sucursal
				left join pos_proveedor as prov On prov.id_proveedor = c.Proveedor
				left join pos_tipo_documento as td On td.id_tipo_documento = c.Tipo_Documento
				left join pos_empresa as emp On emp.id_empresa = c.Empresa
				where  c.Empresa =" . $this->session->empresa[0]->id_empresa . ' and c.id_compras = ' . $compra_id );

		//echo $this->db->queries[1];
		return $query->result();
	}

	function get_compra_detalle( $id ){

		$this->db->select('*');
		$this->db->from(self::pos_compras . ' as c');
		$this->db->join(self::pos_compras_detalle . ' as cd',' on c.id_compras = cd.id_compra');
		$this->db->join(self::producto. ' as p', ' on p.id_entidad = cd.id_producto');
		$this->db->join(self::producto_detalle. ' as pd', ' on pd.id_producto_detalle = cd.id_producto_detalle');
		
		$this->db->where('c.id_compras', $id );
		$query = $this->db->get();
		//echo $this->db->queries[1];die;

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	// SAVE UPDATE

	function update_compra($datos , $compra){

		$usuario_id 	= $this->session->usuario[0]->id_empleado;
		$this->_orden 	= $datos;
		
		$data = array(
			'Usuario' 		=> $usuario_id,
			'Empleado' 		=> $compra['empleado'],
			'Sucursal' 		=> $compra['sucursal'],
			'Bodega' 		=> $compra['bodega'],
			'Proveedor' 	=> $compra['proveedor'],
			'modo_pago_id' 	=> $compra['modo_pago_id'],
			'fecha_compra' 	=> $compra['fecha_compra'],
			'Tipo_Documento'=> $compra['id_tipo_documento'],
            'fecha_actualizacion'	=> date("Y-m-d h:i:s"),
			'status_open_close' 	=> $compra['compra_estado'],
			'documento_referencia' 	=> $compra['documento_referencia'],
		);
		$this->db->where('id_compras', $compra['id_compras']);
		$result = $this->db->update(self::pos_compras, $data ); 

		$delete_result = $this->eliminar_compra_detalle($compra['id_compras']);

		if($delete_result){
			$this->guardar_compra_detalle($compra['id_compras'] ,$datos);
			$this->save_compra_impuestos($compra['id_compras'] , 2);
		}

		if(!$result){
            $result = $this->db->error();
        }else{
			$result = $compra['id_compras'];
		}

		return $result;
	}

	function eliminar_compra_detalle($compra_id){

		$flag = false;

		$data = array('id_compra' => $compra_id);
		$this->db->delete(self::pos_compras_detalle, $data);

		$result = $this->db->affected_rows();
		if($result){
			
			$data = array('id_compra' => $compra_id);
			$this->db->delete(self::pos_compras_impuestos, $data);

			$flag = true;
		}

		return $flag;
	}

	function eliminar($compra_id){

		$result = $this->eliminar_compra_detalle($compra_id);
		
		if($result){
			$data 	= array('id_compras' => $compra_id);
			$this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
			$result = $this->db->delete(self::pos_compras, $data);
		}		

		if(!$result){
            $result = $this->db->error();
        }
        return $result;
	}

	function printer($data ){

		$this->db->select('*');
		$this->db->from(self::pos_doc_temp.' as dt');
		$this->db->join(self::pos_temp_suc.' as st',' on dt.id_factura = st.Template');
		$this->db->join(self::sucursal.' as s',' on s.id_sucursal = st.Sucursal');		
		$this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');		
		$this->db->join(self::pos_compras.' as c', ' on c.Tipo_Documento = st.Documento');
        $this->db->join(self::pos_tipo_documento.' as d',' on d.id_tipo_documento = st.Documento');
        $this->db->where('st.Sucursal', $data[0]->Sucursal );
        $this->db->where('st.Documento', $data[0]->Tipo_Documento );
        $this->db->limit(1);
		$query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
}