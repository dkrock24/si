<?php
class Usuario_model extends CI_Model {
	const empleado =  'sys_empleado';
    const sucursal = 'pos_sucursal';
    const persona = 'sys_persona';
    const usuario_roles = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa = 'pos_empresa';
    const sys_usuario = 'sys_usuario';
    const sys_role = 'sys_role';

    function get_usuarios( $limit, $id ){;
        $this->db->select('*');
        $this->db->from(self::sys_usuario.' as u');
        $this->db->join(self::sys_role.' as r', 'u.id_rol = r.id_rol');
        $this->db->join(self::empleado.' as e', 'e.id_empleado = u.Empleado');
        $this->db->join(self::sucursal.' as s', 's.id_sucursal = e.Sucursal');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->Empresa_Suc);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        return $this->db->count_all(self::sys_usuario);
    }

	function get_empleado( $id_usuario ){
		$this->db->select('*');
        $this->db->from(self::empleado);
        $this->db->join(self::sucursal,' on '.self::empleado.'.Sucursal='.self::sucursal.'.id_sucursal');
        $this->db->join(self::persona,' on '.self::persona.'.id_persona='.self::empleado.'.Persona_E');

        $this->db->where(self::empleado.'.Persona_E = ', $id_usuario);
        $this->db->where(self::empleado.'.estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_empleados_by_sucursal( $sucursal ){
        $this->db->select('*');
        $this->db->from(self::empleado);
        $this->db->join(self::sucursal,' on '.self::empleado.'.Sucursal='.self::sucursal.'.id_sucursal');
        $this->db->join(self::persona,' on '.self::persona.'.id_persona='.self::empleado.'.Persona_E');

        $this->db->where(self::empleado.'.Sucursal = ', $sucursal);
        $this->db->where(self::empleado.'.estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_usuario_roles( $usuario_id ){

        $this->db->select('*');
        $this->db->from(self::usuario_roles);  
        $this->db->where(self::usuario_roles.'.usuario_rol_usuario',$usuario_id);   
        $query = $this->db->get(); 
        //echo $this->->queries[0];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function permiso_empresa( $empleado_id ){

        $this->db->select('*');
        $this->db->from(self::empleado_sucursal.' as es');  
        $this->db->join(self::sucursal.' as s',' on s.id_sucursal = es.es_sucursal');
        $this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->where('es.es_empleado',$empleado_id);
        $this->db->group_by('e.id_empresa');
        $query = $this->db->get(); 
        //echo $this->db->queries[2];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function crear_usuario($datos){

        $imagen="";
        $imagen = file_get_contents($_FILES['foto']['tmp_name']);
        $imageProperties = getimageSize($_FILES['foto']['tmp_name']);

        $data = array(
            'nombre_usuario'    => $datos['nombre_usuario'],
            'contrasena_usuario'=> sha1( $datos['contrasena_usuario']),
            'img'               => $imagen,
            'img_type'          => $imageProperties['mime'],
            'hora_inicio'       => $datos['hora_inicio'],
            'hora_salida'       => $datos['hora_salida'],
            'usuario_encargado'         => $datos['encargado'],
            'id_rol'            => $datos['id_rol'],
            'Empleado'          => $datos['persona'],
            'estado'            => $datos['estado'],
        );
        
        $insert = $this->db->insert(self::sys_usuario, $data);  
        return $insert;
    }

    function validar_usuario( $id_empleado ){

        $this->db->select('*');
        $this->db->from(self::sys_usuario);  
        $this->db->where('Empleado',$id_empleado);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_usuario_id( $usuario_id ){
         $this->db->select('*');
        $this->db->from(self::sys_usuario);  
        $this->db->where('id_usuario',$usuario_id);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($datos){
        $imagen="";

        if($_FILES['foto']['tmp_name']){
            $imageProperties = getimageSize($_FILES['foto']['tmp_name']);    
        }        

        $data = array(
            'nombre_usuario'    => $datos['nombre_usuario'],
            'contrasena_usuario'=> sha1( $datos['contrasena_usuario']),
            'hora_inicio'       => $datos['hora_inicio'],
            'hora_salida'       => $datos['hora_salida'],
            'usuario_encargado'         => $datos['encargado'],
            'id_rol'            => $datos['id_rol'],
            'Empleado'          => $datos['persona'],
            'estado'            => $datos['estado'],
        );

        if(isset($_FILES['foto']) && $_FILES['foto']['tmp_name']!=null){
            
            $imagen = file_get_contents($_FILES['foto']['tmp_name']);

            $data = array_merge( $data,array('img' => $imagen, 'img_type'=> $imageProperties['mime'] ));
        }
                $this->db->where('id_usuario', $datos['id_usuario']);  
        $insert = $this->db->update(self::sys_usuario, $data);  
        return $insert;
    }
}