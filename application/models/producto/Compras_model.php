<?php
class Compras_model extends CI_Model
{
	const producto =  'producto';
	const producto_detalle = 'prouducto_detalle';
	const pos_bodega = "pos_bodega";
	const pos_compras = "pos_compras";
	const pos_compras_detalle = "pos_compras_detalle";
	const sys_traslados = "sys_traslados";
	const sys_traslados_detalle = "sys_traslados_detalle";
	const pos_doc_temp = 'pos_doc_temp';
	const pos_temp_suc = 'pos_temp_sucursal';
	const sucursal = 'pos_sucursal';
	const pos_empresa = 'pos_empresa';
	const pos_tipo_documento = 'pos_tipo_documento';

	function getCompras($limit, $id, $filters)
	{
		if ($filters) {
			$filters = " and " . $filters;
		}
		$query = $this->db->query("select c.*,s.*,b.*,prov.*, CONCAT(p.primer_nombre_persona, ' ', p.primer_apellido_persona) as recibe ,
			CONCAT(p2.primer_nombre_persona, ' ', p2.primer_apellido_persona) as envia , p.id_persona as id1, p2.id_persona as id2,
			td.nombre as Documento
			from pos_compras as c
			left join sys_persona as p On p.id_persona = c.Usuario 
			left join sys_persona as p2 On p2.id_persona = c.Empleado
			left join pos_sucursal as s On  s.id_sucursal = c.Sucursal
			left join pos_bodega as b On b.Sucursal = s.id_sucursal
			left join pos_proveedor as prov On prov.id_proveedor = c.Proveedor
			left join pos_tipo_documento as td On td.id_tipo_documento = c.Tipo_Documento			
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
				LEFT JOIN prouducto_detalle AS `pde` ON pde.Producto = P.id_entidad				
				WHERE P.Empresa = ". $this->session->empresa[0]->id_empresa ." and 
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
		,  pinv.id_inventario
		, tipo_imp_prod.tipos_impuestos_idtipos_impuestos, impuestos.porcentage ,
		 `sub_c`.`id_categoria` as 'categoria',pde.presentacion,pde.factor,pde.precio,pde.unidad,pde.cod_barra,pde.id_producto_detalle
		FROM `producto` as `P`
		LEFT JOIN `categoria_producto` as `CP` ON `CP`.`id_producto` = `P`.`id_entidad`
		LEFT JOIN `categoria` as `sub_c` ON `sub_c`.`id_categoria` = `CP`.`id_categoria`
		LEFT JOIN `categoria` as `c` ON `c`.`id_categoria` = `sub_c`.`id_categoria_padre`
		LEFT JOIN `pos_empresa` as `e` ON `e`.`id_empresa` = `P`.`Empresa`
		LEFT JOIN `giros_empresa` as `ge` ON `ge`.`id_giro_empresa` = `P`.`Giro`
		LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
		LEFT JOIN `pos_giros` as `g` ON `g`.`id_giro` = `ge`.`Giro`
		LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
		LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
		LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
		LEFT JOIN prouducto_detalle AS pde ON pde.Producto = P.id_entidad

		WHERE pde.id_producto_detalle = " . $producto_id);
			//echo $this->db->queries[0];
		return $query->result();
	}

	function guardar_compra($datos , $compra){

		$usuario_id = $this->session->usuario[0]->id_empleado;
		$fecha 		 = date_create();		
		
		$data = array(
			'Usuario' 		=> $usuario_id,
			'Empleado' 		=> $compra['empleado'],
			'Sucursal' 		=> $compra['sucursal'],
			'Bodega' 		=> $compra['bodega'],
			'Proveedor' 	=> $compra['proveedor'],
			'modo_pago_id' 	=> $compra['modo_pago_id'],			
			'numero_serie' 	=> date_timestamp_get($fecha),
			'fecha_compra' 	=> $compra['fecha_compra'],
			'Tipo_Documento'=> $compra['id_tipo_documento'],
			'Empresa'		=> $this->session->empresa[0]->id_empresa,
            'fecha_creacion'=> date("Y-m-d h:i:s"),
			'status_open_close' => $compra['compra_estado'],
        );
		$this->db->insert(self::pos_compras, $data ); 

		$compra_id = $this->db->insert_id();

		$this->guardar_compra_detalle($compra_id ,$datos);

		return $compra_id;
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

	function editar_compra($compra_id)
	{
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

		$valores =   $id;
		
		$this->db->select('*');
		$this->db->from(self::pos_compras . ' as c');
		$this->db->join(self::pos_compras_detalle . ' as cd',' on c.id_compras = cd.id_compra');
		$this->db->join(self::producto. ' as p', ' on p.id_entidad = cd.id_producto');
		$this->db->join(self::producto_detalle. ' as pd', ' on pd.id_producto_detalle = cd.id_producto_detalle');
		
		$this->db->where('c.id_compras', $id );
		$query = $this->db->get();
		//echo $this->db->queries[1];

		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	// SAVE UPDATE

	function update_compra($datos , $compra){

		$usuario_id 	= $this->session->usuario[0]->id_empleado;
		
		$data = array(
			'Usuario' 		=> $usuario_id,
			'Empleado' 		=> $compra['empleado'],
			'Sucursal' 		=> $compra['sucursal'],
			'Bodega' 		=> $compra['bodega'],
			'Proveedor' 	=> $compra['proveedor'],
			'modo_pago_id' 	=> $compra['modo_pago_id'],
			'fecha_compra' 	=> $compra['fecha_compra'],
			'Tipo_Documento'=> $compra['id_tipo_documento'],
            'fecha_actualizacion'=> date("Y-m-d h:i:s"),
			'status_open_close' => $compra['compra_estado'],
		);
		$this->db->where('id_compras', $compra['id_compras']);
		$this->db->update(self::pos_compras, $data ); 

		$delete_result = $this->elimnar_compra_detalle($compra['id_compras']);

		$this->guardar_compra_detalle($compra['id_compras'] ,$datos);		

		return $compra['id_compras'];
	}

	function elimnar_compra_detalle($compra_id){

		$flag = false;

		$data = array('id_compra' => $compra_id);
		$this->db->delete(self::pos_compras_detalle, $data);

		$result = $this->db->affected_rows();
		if($result){
			$flag = true;
		}

		return $flag;
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
