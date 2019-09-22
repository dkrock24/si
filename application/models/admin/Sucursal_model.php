<?php
class Sucursal_model extends CI_Model {

	const pos_sucursal = 'pos_sucursal';
	const pos_empresa = 'pos_empresa';	
	const sys_empleado_sucursal = 'sys_empleado_sucursal';	
	
	function getSucursal(){
		$this->db->select('*');
        $this->db->from(self::pos_sucursal.' as b');
        $this->db->where('b.Empresa_Suc', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function getAllSucursalEmpresa( ){
        $this->db->select('*');
        $this->db->from(self::pos_sucursal.' as b');
        $this->db->where('b.Empresa_Suc', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getSucursalEmpresa( $empresa_id ){
        $this->db->select('*');
        $this->db->from(self::pos_sucursal.' as b');
        $this->db->where('b.Empresa_Suc', $empresa_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

	function getSucursalId( $empresa_id ){
		$this->db->select('*');
        $this->db->from(self::pos_sucursal.' as b');
        $this->db->where('b.id_sucursal', $empresa_id );
        //$this->db->where('b.codigo', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function getAllSucursal( $limit, $id ){
        $this->db->select('*');
        $this->db->from(self::pos_sucursal.' as s');
        $this->db->join(self::pos_empresa.' as e', ' on s.Empresa_Suc = e.id_empresa');
        $this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        $this->db->where('Empresa_Suc',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::pos_sucursal);
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear_sucursal( $datos ){

        $data = array(
            'nombre_sucursal' => $datos['nombre_sucursal'],
            'direct' => $datos['direct'],
            'encargado_sucursal' => $datos['encargado'],
            'tel' => $datos['tel'],
            'cel' => $datos['cel'],
            'estado' => $datos['estado'],
            'Ciudad_Suc' => $datos['Ciudad_Suc'],            
            //'Empresa_Suc' => $this->session->empresa[0]->Empresa_Suc
            'Empresa_Suc' => $datos['Empresa_Suc']            
        );
        return $insert = $this->db->insert(self::pos_sucursal, $data ); 
    }

    function actualizar_giro( $datos ){
        
        $data = array(
            'nombre_sucursal' => $datos['nombre_sucursal'],
            'direct' => $datos['direct'],
            'encargado' => $datos['encargado'],
            'tel' => $datos['tel'],
            'cel' => $datos['cel'],
            'estado' => $datos['estado'],
            'Ciudad_Suc' => $datos['Ciudad_Suc'],            
            'Empresa_Suc' => $datos['Empresa_Suc']
        );

        $this->db->where('id_sucursal', $datos['id_ciudad']);
        $insert = $this->db->update(self::pos_sucursal, $data);  
        return $insert;
    }

}