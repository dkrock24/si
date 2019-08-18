<?php
class Empleado_model extends CI_Model {
	
	const sys_persona = 'sys_persona';	
    const sys_empleado = 'sys_empleado';  
    const sys_ciudad = 'sys_ciudad';
    const sys_sexo = 'sys_sexo';
    const pos_sucursal = 'pos_sucursal';
    const sys_cargo_laboral = 'sys_cargo_laboral';
    const pos_empresa = 'pos_empresa';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const sucursal = 'pos_sucursal';


	function get_empleados(){

		$this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_empleado.' as e', 'on p.id_persona = e.Persona_E');
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_empleados2(){

        $this->db->select('p.primer_nombre_persona, p.segundo_nombre_persona,p.primer_apellido_persona,p.segundo_apellido_persona,p.dui,p.nit,p.tel,p.id_persona,e.id_empleado');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_empleado.' as e', 'on p.id_persona = e.Persona_E');
        $this->db->where('p.Empresa', $this->session->empresa[0]->Empresa_Suc);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function validar_persona( $id_persona ){

        $this->db->select('*');
        $this->db->from(self::sys_empleado);  
        $this->db->where('Persona_E',$id_persona);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllEmpleados( $limit, $id  ){

        $this->db->select('*');
        $this->db->from(self::sys_persona.' as p');
        $this->db->join(self::sys_empleado.' as e', 'on p.id_persona = e.Persona_E');
        $this->db->join(self::pos_sucursal.' as s', 'on s.id_sucursal = e.Sucursal');
        $this->db->join(self::sys_cargo_laboral.' as c', 'on c.id_cargo_laboral = e.Cargo_Laboral_E');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        $this->db->where('s.Empresa_Suc',$this->session->empresa[0]->Empresa_Suc);
        $this->db->from(self::sys_empleado.' as e');
        $this->db->join(self::sucursal.' as s',' on e.Sucursal = s.id_sucursal');
        $result = $this->db->count_all_results();
        return $result;
    }

	function crear($datos){

        $imagen="";
        $imagen = file_get_contents($_FILES['img_empleado']['tmp_name']);
        $imageProperties = getimageSize($_FILES['img_empleado']['tmp_name']);

		$data = array(
          	'fecha_contratacion_empleado' 	=> 	$datos['fecha_contratacion_empleado'],
            'horas_laborales_mensuales_empleado' 	=> $datos['horas_laborales_mensuales_empleado'],
            'turno' 	=> $datos['turno'],
            'alias' 	=> $datos['alias'],
            'seccion' 	=> $datos['seccion'],
            'puesto'    => $datos['puesto'],
            'encargado' => $datos['encargado'],
            'nivel'=> $datos['nivel'],
            'Cargo_Laboral_E'   => $datos['Cargo_Laboral_E'],
            'Persona_E' => $datos['Persona_E'],
            'Sucursal'  => $datos['Sucursal'],
            'creado'    => date("Y-m-d"),
            'estado'    => $datos['estado']
        );
         if(isset($_FILES['img_empleado']) && $_FILES['img_empleado']['tmp_name']!=null){
            
            $imagen = file_get_contents($_FILES['img_empleado']['tmp_name']);

            $data = array_merge( $data,array('img_empleado' => $imagen, 'img_type'=> $imageProperties['mime'] ));
        }
        
        $result = $this->db->insert(self::sys_empleado, $data);  
        $insert_id = $this->db->insert_id();

        $this->insert_empleado_sucursal($insert_id , $datos);
        return $result;

	}

    function insert_empleado_sucursal($empleado, $datos){

        foreach ($datos as $key => $value) {
            $number = (int)$key;
            if($number){
                $data = array(
                    'es_empleado' => $empleado,
                    'es_sucursal' => $number,
                    'es_creado' => date("Y-m-d h:i:s"),
                    'es_estado' => 1
                );
                $this->db->insert(self::empleado_sucursal, $data ); 
            }
        }
    }

	function update($datos){

        $imagen="";
        

        $data = array(
            'fecha_contratacion_empleado'   =>  $datos['fecha_contratacion_empleado'],
            'horas_laborales_mensuales_empleado'    => $datos['horas_laborales_mensuales_empleado'],
            'turno'     => $datos['turno'],
            'alias'     => $datos['alias'],
            'seccion'   => $datos['seccion'],
            'puesto'    => $datos['puesto'],
            'encargado' => $datos['encargado'],
            'nivel'=> $datos['nivel'],
            'Cargo_Laboral_E'   => $datos['Cargo_Laboral_E'],
            'Persona_E' => $datos['Persona_E'],
            'Sucursal'  => $datos['Sucursal'],
            'actualizado'    => date("Y-m-d"),
            'estado'    => $datos['estado']
        );
         if(isset($_FILES['img_empleado']) && $_FILES['img_empleado']['tmp_name']!=null){
            
            $imagen = file_get_contents($_FILES['img_empleado']['tmp_name']);
            $imageProperties = getimageSize($_FILES['img_empleado']['tmp_name']);

            $data = array_merge( $data,array('img_empleado' => $imagen, 'img_type'=> $imageProperties['mime'] ));
        }
        $this->db->where('id_empleado', $datos['id_empleado']);  
        $result = $this->db->update(self::sys_empleado, $data);  

        $this->update_empleado_sucursal($datos);

        return $result;
 
	}
    
    function update_empleado_sucursal($empleado){

        $id_empleado = $empleado['id_empleado'];

        $result = $this->delete_emp_suc($id_empleado);

        if($result){
            foreach ($empleado as $key => $value) {
                $number = (int)$key;
                if($number){
                    $data = array(
                        'es_empleado' => $id_empleado,
                        'es_sucursal' => $number,
                        'es_creado' => date("Y-m-d h:i:s"),
                        'es_estado' => 1
                    );
                    $this->db->insert(self::empleado_sucursal, $data ); 
                }
            }
        }        
    }

    function delete_emp_suc($empleado){
        
        $data = array(
            'es_empleado' => $empleado
        );

        $this->db->where('es_empleado', $empleado );
        $result = $this->db->delete(self::empleado_sucursal, $data ); 

        return $result ;

    }

    function getEmpleadoId( $empleado_id ){

        $this->db->select('*');
        $this->db->from(self::sys_empleado.' as e');
        $this->db->join(self::sys_persona.' as p', 'on p.id_persona = e.Persona_E');
        //$this->db->join(self::sys_persona.' as p2', 'on p2.id_persona = e.encargado');
        $this->db->join(self::sys_cargo_laboral.' as c', 'on c.id_cargo_laboral = e.Cargo_Laboral_E');
        $this->db->join(self::pos_sucursal.' as s', 'on s.id_sucursal = e.Sucursal');
        $this->db->join(self::pos_empresa.' as em', 'on em.id_empresa = s.Empresa_Suc');
        $this->db->where('em.id_empresa', $this->session->empresa[0]->Empresa_Suc);
        $this->db->where('e.id_empleado', $empleado_id );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

}