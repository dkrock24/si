<?php
class Cargos_model extends CI_Model {
	
	const sys_persona = 'sys_persona';	
    const sys_empleado = 'sys_empleado';  
    const sys_cargo_laboral = 'sys_cargo_laboral';
	
	function get_cargos(){

		$this->db->select('*');
        $this->db->from(self::sys_cargo_laboral.' as p');
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

     function get_all_cargo( $limit, $id ){;
        $this->db->select('*');
        $this->db->from(self::sys_cargo_laboral);
        $this->db->where('Empresa', $this->session->empresa[0]->Empresa_Suc);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        return $this->db->count_all(self::sys_cargo_laboral);
    }

    function crear_cargo($datos){

        $data = array(
            'cargo_laboral'    => $datos['cargo_laboral'],
            'descripcion_cargo_laboral'=> $datos['descripcion_cargo_laboral'],
            'salario_mensual_cargo_laboral'       => $datos['salario_mensual_cargo_laboral'],
            'estado'            => $datos['estado'],
        );
        
        $insert = $this->db->insert(self::sys_cargo_laboral, $data);  
        return $insert;
    }

    function get_cargo_id( $cargo_id ){;
        $this->db->select('*');
        $this->db->from(self::sys_cargo_laboral);
        $this->db->where('id_cargo_laboral', $cargo_id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function update($datos){

        $data = array(
            'cargo_laboral'    => $datos['cargo_laboral'],
            'descripcion_cargo_laboral'=> $datos['descripcion_cargo_laboral'],
            'salario_mensual_cargo_laboral'       => $datos['salario_mensual_cargo_laboral'],
            'estado'            => $datos['estado'],
        );
        
        $this->db->where('id_cargo_laboral', $datos['id_cargo_laboral']);  
        $insert = $this->db->update(self::sys_cargo_laboral, $data);  
        return $insert;
    }



}