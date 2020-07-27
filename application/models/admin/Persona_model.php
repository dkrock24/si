<?php
class Persona_model extends CI_Model {
	
	const sys_persona = 'sys_persona';	
    const sys_ciudad = 'sys_ciudad';
    const sys_sexo = 'sys_sexo';
    const sys_departamento = 'sys_departamento';
    const pos_empresa = 'pos_empresa';
    const sucursal = 'pos_sucursal';
    const pos_orden_estado = 'pos_orden_estado';
	
	function getPersona( $limit, $id , $filters ){

		$this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_ciudad.' as c', 'on p.Ciudad = c.id_ciudad');
        $this->db->join(self::sys_sexo.' as s', 'on p.Sexo = s.id_sexo');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = p.persona_estado');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function getAllPersona(){

        $this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_ciudad.' as c', 'on p.Ciudad = c.id_ciudad');
        $this->db->join(self::sys_sexo.' as s', 'on p.Sexo = s.id_sexo');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count($filter){

        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::sys_persona);
        $result = $this->db->count_all_results();
        return $result;

    }

    function get_encargado(){

        $this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_ciudad.' as c', 'on p.Ciudad = c.id_ciudad');
        $this->db->join(self::sys_sexo.' as s', 'on p.Sexo = s.id_sexo');
        $this->db->where(self::sys_persona.' as p.id_persona', 1);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

	function crear($datos){

		$data = array(
          	'primer_nombre_persona' 	=> strtoupper($datos['primer_nombre_persona']),
            'segundo_nombre_persona' 	=> strtoupper($datos['segundo_nombre_persona']),
            'primer_apellido_persona' 	=> strtoupper($datos['primer_apellido_persona']),
            'segundo_apellido_persona' 	=> strtoupper($datos['segundo_apellido_persona']),
            'fecha_cumpleaños_persona' 	=> $datos['fecha_cumpleaños_persona'],
            'dui'                       => $datos['dui'],
            'nit'                       => $datos['nit'],
            'direccion_residencia_persona1'=> $datos['direccion_residencia_persona1'],
            'direccion_residencia_persona2'=> $datos['direccion_residencia_persona2'],
            'tel'                       => $datos['tel'],
            'cel'                       => $datos['cel'],
            'mail'                      => $datos['mail'],
            'whatsapp'                  => $datos['whatsapp'],
            'Sexo'                      => $datos['Sexo'],
            'Ciudad'                    => $datos['ciudad'],
            'comentarios'               => $datos['comentarios'],
            'persona_estado'            => $datos['persona_estado'],
            'Ciudad'                    => $datos['ciudad'],
            'Empresa'                   => $this->session->empresa[0]->id_empresa
        );
        
        $result = $this->db->insert(self::sys_persona, $data);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

	function update($datos){

		$data = array(
            'primer_nombre_persona' 	=> strtoupper($datos['primer_nombre_persona']),
            'segundo_nombre_persona' 	=> strtoupper($datos['segundo_nombre_persona']),
            'primer_apellido_persona' 	=> strtoupper($datos['primer_apellido_persona']),
            'segundo_apellido_persona' 	=> strtoupper($datos['segundo_apellido_persona']),
            'fecha_cumpleaños_persona'  => $datos['fecha_cumpleaños_persona'],
            'dui'                       => $datos['dui'],
            'nit'                       => $datos['nit'],
            'direccion_residencia_persona1'=> $datos['direccion_residencia_persona1'],
            'direccion_residencia_persona2'=> $datos['direccion_residencia_persona2'],
            'tel'                       => $datos['tel'],
            'cel'                       => $datos['cel'],
            'mail'                      => $datos['mail'],
            'whatsapp'                  => $datos['whatsapp'],
            'Sexo'                      => $datos['Sexo'],
            'Ciudad'                    => $datos['Ciudad'],
            'comentarios'               => $datos['comentarios'],
            'persona_estado'            => $datos['persona_estado']
        );
        $this->db->where('id_persona', $datos['id_persona']);
        $result = $this->db->update(self::sys_persona, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
	}

    function eliminar($id){
        $data = array(
            'id_persona'     =>  $id
        );
        $this->db->where('id_persona', $id);
        $result = $this->db->delete(self::sys_persona, $data);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getPersonaId( $persona_id ){

        $this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_ciudad.' as c', 'on p.Ciudad = c.id_ciudad');
        $this->db->join(self::sys_departamento.' as d', 'on d.id_departamento = c.departamento');
        $this->db->join(self::sys_sexo.' as s', 'on p.Sexo = s.id_sexo');
        $this->db->where('p.id_persona', $persona_id );
        //$this->db->where('p.nrc', $this->session->empresa[0]->nrc);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

}