<?php
class Compras_model extends CI_Model
{
	const sys_compras = "sys_compras";
	const sys_traslados = "sys_traslados";
	const sys_traslados_detalle = "sys_traslados_detalle";

	function getTraslado($limit, $id, $filters)
	{
		if ($filters) {
			$filters = " and " . $filters;
		}
		$query = $this->db->query("select t.*, CONCAT(p.primer_nombre_persona, ' ', p.primer_apellido_persona) as recibe ,
			CONCAT(p2.primer_nombre_persona, ' ', p2.primer_apellido_persona) as envia , p.id_persona as id1, p2.id_persona as id2
			from sys_traslados as t
			left join sys_persona as p On p.id_persona = t.firma_llegada 
			left join sys_persona as p2 On p2.id_persona = t.firma_salida
			
			where  t.Empresa ="
			. $this->session->empresa[0]->id_empresa . $filters . " ORDER BY id_tras desc Limit " . $id . ',' . $limit);

		//echo $this->db->queries[1];
		return $query->result();
	}

	function record_count($filter)
	{
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa . ' ' . $filter);
		$this->db->from(self::sys_traslados);

		$result = $this->db->count_all_results();
		return $result;
	}

	function get_productos_valor($texto)
	{
		
		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*,  m.nombre_marca, pde.presentacion , pde.cod_barra as pres_cod_bar , pde.id_producto_detalle, pde.precio
				FROM `producto` as `P`
				LEFT JOIN `pos_marca` as `m` ON `m`.id_marca = `P`.Marca
				LEFT JOIN prouducto_detalle AS `pde` ON pde.Producto = P.id_entidad				
				WHERE (P.name_entidad LIKE '%$texto%' || P.codigo_barras LIKE '%$texto%' || P.descripcion_producto LIKE '%$texto%') ");

		//echo $this->db->queries[0];
		return $query->result();
	}

	function get_producto_completo($producto_id)
	{
		$query = $this->db->query("SELECT distinct(P.id_entidad ), `P`.*, `c`.`nombre_categoria` as 'nombre_categoria', `sub_c`.`nombre_categoria` as 'SubCategoria', e.nombre_razon_social, e.id_empresa, g.id_giro, g.nombre_giro, m.nombre_marca
		,  pinv.id_inventario
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
		LEFT JOIN pos_inventario AS pinv on pinv.Producto_inventario = P.id_entidad
		LEFT JOIN pos_tipos_impuestos_has_producto AS tipo_imp_prod on tipo_imp_prod.producto_id_producto = P.id_entidad
		LEFT JOIN pos_tipos_impuestos AS impuestos on impuestos.id_tipos_impuestos = tipo_imp_prod.tipos_impuestos_idtipos_impuestos
		LEFT JOIN prouducto_detalle AS pde ON pde.Producto = P.id_entidad

		WHERE pde.id_producto_detalle = " . $producto_id);
			//echo $this->db->queries[0];
		return $query->result();
	}
}
