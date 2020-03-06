<?php
class Compras_model extends CI_Model
{
	const sys_compras = "sys_compras";
	const sys_traslados = "sys_traslados";
	const sys_traslados_detalle = "sys_traslados_detalle";

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
	
	function record_count($filter)
	{
		$this->db->where('Empresa', $this->session->empresa[0]->id_empresa. ' '. $filter);
		$this->db->from(self::sys_traslados );
		
		$result = $this->db->count_all_results();
		return $result;
	}
}