<?php
class Persona_model extends CI_Model {
	
	const sys_persona = 'sys_persona';	
    const sys_ciudad = 'sys_ciudad';
    const sys_sexo = 'sys_sexo';
	
	function getPersona(){

		$this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_ciudad.' as c', 'on p.Ciudad = c.id_ciudad');
        $this->db->join(self::sys_sexo.' as s', 'on p.Sexo = s.id_sexo');
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
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