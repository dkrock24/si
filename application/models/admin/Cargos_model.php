<?php
class Cargos_model extends CI_Model {
	
	const sys_persona       = 'sys_persona';	
    const sys_empleado      = 'sys_empleado';  
    const sys_cargo_laboral = 'sys_cargo_laboral';
    const sys_cargo_laboral2 = 'sys_cargo_laboral2';
    const pos_orden_estado  = 'pos_orden_estado';
	
	function get_cargos($cargo = NULL){

		$this->db->select('*');
        $this->db->from(self::sys_cargo_laboral.' as p');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        if($cargo){
            $this->db->where('p.cargo_laboral',$cargo);
        }
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

     function get_all_cargo( $limit, $id, $filters ){;
        $this->db->select('*');
        $this->db->from(self::sys_cargo_laboral);
        $this->db->join(self::pos_orden_estado.' as es', ' on es.id_orden_estado = sys_cargo_laboral.cargo_estado');
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filter){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::sys_cargo_laboral);
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear_cargo($datos){

        $registros = $this->get_cargos($datos['cargo_laboral']);

        if(!$registros){
            $data = array(
                'Empresa'                   => $this->session->empresa[0]->id_empresa,
                'cargo_estado'              => $datos['estado'],
                'cargo_laboral'             => $datos['cargo_laboral'],
                'descripcion_cargo_laboral' => $datos['descripcion_cargo_laboral'],
                'salario_mensual_cargo_laboral'=> $datos['salario_mensual_cargo_laboral']
            );
            
            $insert = $this->db->insert(self::sys_cargo_laboral, $data);  
            if(!$insert){
                $insert = $this->db->error();
            }
    
            return $insert;
        }else{
            return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
        }
    }

    function get_cargo_id( $cargo_id ){;
        $this->db->select('*');
        $this->db->from(self::sys_cargo_laboral);
        $this->db->where('id_cargo_laboral', $cargo_id);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function update($datos){

        $data = array(
            'cargo_estado' => $datos['estado'],
            'cargo_laboral' => $datos['cargo_laboral'],
            'descripcion_cargo_laboral'=> $datos['descripcion_cargo_laboral'],
            'salario_mensual_cargo_laboral' => $datos['salario_mensual_cargo_laboral'],
        );
        
        $this->db->where('id_cargo_laboral', $datos['id_cargo_laboral']);  
        $insert = $this->db->update(self::sys_cargo_laboral, $data);  
        
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function eliminar($id){
         $data = array(
            'id_cargo_laboral'    => $id
        );
        
        $this->db->where('id_cargo_laboral', $id );  
        $result = $this->db->delete(self::sys_cargo_laboral, $data);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function insert_api($cargos)
    {
        $this->db->truncate(self::sys_cargo_laboral2);

        $data = [];
        foreach ($cargos as $key => $cargo) {
            $data[] = $cargo;
        }
        $this->db->insert_batch(self::sys_cargo_laboral2, $data);
    }
}