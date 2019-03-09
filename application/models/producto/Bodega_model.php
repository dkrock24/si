<?php
class Bodega_model extends CI_Model {

	const pos_bodega = 'pos_bodega';
	const pos_sucursal = 'pos_sucursal';
	const pos_empresa = 'pos_empresa';	
	const sys_empleado_sucursal = 'sys_empleado_sucursal';	
    const pos_producto_bodega = 'pos_producto_bodega';
    const producto = 'producto';
	
	function getBodegas( $id_usuario , $limit, $id){
		$this->db->select('*');
        $this->db->from(self::pos_bodega.' as b');
        $this->db->join(self::pos_sucursal.' as s', 'on b.Sucursal = s.id_sucursal');
        $this->db->join(self::pos_empresa.' as e', 'on s.Empresa_Suc = e.id_empresa');
        $this->db->join(self::pos_producto_bodega.' as pb', 'on pb.Bodega = b.id_bodega');
        $this->db->join(self::producto.' as p', 'on p.id_entidad = pb.Producto');
        $this->db->join(self::sys_empleado_sucursal.' as es', 'on es.es_sucursal = s.id_sucursal');
        $this->db->where('es.es_empleado', $id_usuario );
        $this->db->limit($limit, $id);
        $this->db->group_by('b.id_bodega');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function record_count($id_usuario){
        $this->db->select('count(*) as total');
        $this->db->from(self::pos_bodega.' as b');
        $this->db->join(self::pos_sucursal.' as s', 'on b.Sucursal = s.id_sucursal');
        $this->db->join(self::pos_empresa.' as e', 'on s.Empresa_Suc = e.id_empresa');
        $this->db->join(self::sys_empleado_sucursal.' as es', 'on es.es_sucursal = s.id_sucursal');
        $this->db->where('es.es_empleado', $id_usuario );
        $this->db->group_by('b.id_bodega');
        $query = $this->db->get();
        //echo $this->db->queries[0];
        
        if($query->num_rows() > 0 )
        {
            $total = $query->result();
            return $total[0]->total;
        }
    }

	function saveBodegas($datos){

		$data = array(
          	'nombre_bodega' 	=> 	$datos['nombre_bodega'],
            'direccion_bodega' 	=> $datos['direccion_bodega'],
            'encargado_bodega' 	=> $datos['encargado_bodega'],
            'predeterminada_bodega' => $datos['predeterminada_bodega'],
            'Sucursal' 			=> $datos['Sucursal'],
            'bodega_estado' 	=> $datos['bodega_estado'],
        );
        
        $this->db->insert(self::pos_bodega, $data);  

	}

	function getBodegaById($bodega_id){

		$this->db->select('*');
        $this->db->from(self::pos_bodega.' as b');
        $this->db->join(self::pos_sucursal.' as s', 'on b.Sucursal = s.id_sucursal');
        $this->db->join(self::pos_empresa.' as e', 'on s.Empresa_Suc = e.id_empresa');
        $this->db->join(self::sys_empleado_sucursal.' as es', 'on es.es_sucursal = s.id_sucursal');
        $this->db->where('b.id_bodega', $bodega_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

	function update_bodega($datos){

		$data = array(
          	'nombre_bodega' 	=> 	$datos['nombre_bodega'],
            'direccion_bodega' 	=> $datos['direccion_bodega'],
            'encargado_bodega' 	=> $datos['encargado_bodega'],
            'predeterminada_bodega' => $datos['predeterminada_bodega'],
            'Sucursal' 			=> $datos['Sucursal'],
            'bodega_estado' 	=> $datos['bodega_estado'],
        );
        $this->db->where('id_bodega', $datos['id_bodega']);
        $this->db->update(self::pos_bodega, $data);  
	}

    function getProductoByBodega( $data ){

        $this->db->select('*');
        $this->db->from(self::pos_bodega.' as b');
        $this->db->join(self::pos_sucursal.' as s', 'on b.Sucursal = s.id_sucursal');
        $this->db->join(self::pos_producto_bodega.' as pb', 'on pb.Bodega = b.id_bodega');
        $this->db->join(self::producto.' as p', 'on p.id_entidad = pb.Producto');

        $this->db->where('pb.Producto', $data['producto'] );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}