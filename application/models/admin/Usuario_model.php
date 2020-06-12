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
    const sys_cargo_laboral = ' sys_cargo_laboral';

    function get_usuarios( $limit, $id , $filters){;
        $this->db->select('r.*,s.*,u.nombre_usuario,u.contrasena_usuario,u.hora_inicio,u.hora_salida,u.usuario_encargado,u.Empleado,u.id_usuario,e.alias,e.id_empleado');
        $this->db->from(self::sys_usuario.' as u');
        $this->db->join(self::sys_role.' as r', 'u.id_rol = r.id_rol');
        $this->db->join(self::empleado.' as e', 'e.id_empleado = u.Empleado');
        $this->db->join(self::sucursal.' as s', 's.id_sucursal = e.Sucursal');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
//        echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function get_usuarios_sucursal( ){;
        $this->db->select('*');
        $this->db->from(self::sys_usuario.' as u');
        $this->db->join(self::empleado.' as e', 'e.id_empleado = u.Empleado');
        $this->db->join(self::persona.' as p', 'p.id_persona = e.Persona_E');
        $this->db->join(self::sucursal.' as s', 's.id_sucursal = e.Sucursal');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function get_cajeros( $role ){;
        $this->db->select('*');
        $this->db->from(self::empleado.' as e');
        $this->db->join(self::persona.' as p', 'p.id_persona = e.Persona_E');
        $this->db->join(self::sys_cargo_laboral.' as c', 'c.id_cargo_laboral = e.Cargo_Laboral_E');
        $this->db->where('c.cargo_laboral' , $role );
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filter){
        //return $this->db->count_all(self::sys_usuario);
        $this->db->where('r.Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::sys_usuario.' as u');
        $this->db->join(self::sys_role.' as r',' on r.id_rol = u.id_rol');
        $result = $this->db->count_all_results();
        return $result;
    }

	function get_empleado( $id_usuario ){
		$this->db->select('*');
        $this->db->from(self::empleado);
        $this->db->join(self::sucursal,' on '.self::empleado.'.Sucursal='.self::sucursal.'.id_sucursal');
        $this->db->join(self::persona,' on '.self::persona.'.id_persona='.self::empleado.'.Persona_E');
        $this->db->join(self::sys_usuario.' as u',' on u.Empleado='.self::empleado.'.id_empleado');

        $this->db->where('u.Empleado = ', $id_usuario);
        $this->db->where('Empresa_Suc = ', $this->session->empresa[0]->id_empresa);
        $this->db->where(self::empleado.'.estado = 1');
        $query = $this->db->get();
        //echo $this->db->queries[3];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_empleados_by_sucursal( $sucursal ){
        $this->db->select('id_empleado, primer_nombre_persona, segundo_nombre_persona, primer_apellido_persona');
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

    function get_usuario_roles2( $usuario_id ){

        $this->db->select(' r.*, ur.* , ur.id_rol AS rol ');
        $this->db->from(self::sys_role.' as ur');  
        $this->db->join(self::usuario_roles.' as r', ' ON r.usuario_rol_role = ur.id_rol', 'left'); 
        $this->db->where('ur.Empresa',$this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function permiso_empresa( $empleado_id ){

       //var_dump($empleado_id);

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
        $insert_id = $this->db->insert_id();
        $this->insert_role_usuario( $insert_id , $datos );

        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function insert_role_usuario($usuario, $datos){

        foreach ($datos as $key => $value) {
            $number = (int)$key;
            if($number){
                $data = array(
                    'usuario_rol_usuario' => $usuario,
                    'usuario_rol_role' => $number,
                    'usuario_rol_creado' => date("Y-m-d h:i:s"),
                    'usuario_rol_estado' => 1
                );
                $this->db->insert(self::usuario_roles, $data ); 
            }
        }
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
        $this->db->from(self::sys_usuario.' as u');
        $this->db->join(self::empleado.' as e',' on u.Empleado = e.id_empleado ');
        $this->db->join(self::persona.' as p',' on p.id_persona = e.Persona_E ');
        $this->db->where('u.id_usuario',$usuario_id);
        
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($datos){
        $imagen="";
        $passwd= "";

        if($_FILES['foto']['tmp_name']){
            $imageProperties = getimageSize($_FILES['foto']['tmp_name']);    
        }

        $data = array(
            'nombre_usuario'    => $datos['nombre_usuario'],
            'hora_inicio'       => $datos['hora_inicio'],
            'hora_salida'       => $datos['hora_salida'],
            'usuario_encargado' => $datos['encargado'],
            'id_rol'            => $datos['id_rol'],
            'Empleado'          => $datos['persona'],
            'estado'            => $datos['estado'],
        );

        if($datos['contrasena_usuario'] !=""){
            $data += ['contrasena_usuario' => sha1( $datos['contrasena_usuario']) ];            
        }

        if(isset($_FILES['foto']) && $_FILES['foto']['tmp_name']!=null){
            
            $imagen = file_get_contents($_FILES['foto']['tmp_name']);

            $data = array_merge( $data,array('img' => $imagen, 'img_type'=> $imageProperties['mime'] ));
        }
                $this->db->where('id_usuario', $datos['id_usuario']);  
        $insert = $this->db->update(self::sys_usuario, $data);  

        $this->delete_role_usuario($datos['id_usuario']);
        $this->update_role_usuario($datos['id_usuario'] , $datos);

        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function update_role_usuario($usuario, $datos){

        foreach ($datos as $key => $value) {
            $number = (int)$key;
            if($number){
                $data = array(
                    'usuario_rol_usuario' => $usuario,
                    'usuario_rol_role' => $number,
                    'usuario_rol_creado' => date("Y-m-d h:i:s"),
                    'usuario_rol_estado' => 1
                );
                $this->db->insert(self::usuario_roles, $data ); 
            }
        }
    }

    function delete_role_usuario($usuario){
        
        $data = array(
            'usuario_rol_usuario' => $usuario
        );

        $this->db->where('usuario_rol_usuario', $usuario );
        $result = $this->db->delete(self::usuario_roles, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result ;

    }

    function autenticar_usuario_descuento( $credencials ){

        $user       = $this->get_user_by_credencials($credencials);
        $encargado  = $this->session->usuario[0]->encargado;
        $flag       = false;
        
        if( $user ){
            
            if( $user[0]->encargado ==  $encargado){
                $flag = true;
            }
        }

        return $flag;

    }

    function get_user_by_credencials($credencials){

        $this->db->select('u.id_usuario,u.id_rol,e.encargado');
        $this->db->from(self::sys_usuario.' as u');
        $this->db->join(self::empleado.' as e',' on u.Empleado = e.id_empleado ');
        //$this->db->join(self::persona.' as p',' on p.id_persona = e.Persona_E ');
        $this->db->where('u.nombre_usuario',$credencials['user']);
        $this->db->where('u.contrasena_usuario', sha1($credencials['passwd']));
        //echo $this->db->queries[1];

        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}