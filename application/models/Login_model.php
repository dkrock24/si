<?php
class Login_model extends CI_Model 
{
    /**
     * definicion de las tablas existentes en la BD que almacena los parametros
     * globales de inicio de session y la que se encarga hacia donde tiene que 
     * autenticarlo
     */
    
    const users         = 'core_usuario';
    const user_db       = 'core_db_usuario';
    const db            = 'core_system_information';
    const sys_usuario   = 'sys_usuario';
    const sys_role      = 'sys_role';
    const sys_empleado  = 'sys_empleado';
    const sys_sucursal  = 'pos_sucursal';
    const sys_login     = 'sys_login';
        
    public function login( $usuario , $passwd )
    {   
        // hacemos la llamada a la BD por defecto que valida el usuario y empresa
        $db = $this->load->database('client', TRUE);
        $this->load->model('admin/Encrypt_model', 'admin');
        $pass = $this->admin->encrypt($passwd);

        $db->select('*');
        $db->from(self::users);
        $db->join(self::user_db,' on '. self::users .'.id_usu = '. self::user_db.'.id_usuario');
        $db->join(self::db,' on '. self::user_db .'.id_db = '. self::db.'.id');
        $db->where(self::users.'.nombre_usu',$usuario);    
        $db->where(self::users.'.password_usu',$pass);   
        $query = $db->get(); 
        //echo $db->queries[0];
        
        if($query->num_rows() > 0 ){
    
            return $query->result();
        }else{

            return 0;
        } 
    }

    public function autenticacion( $usuario , $passwd ){

        $db = $this->load->database('default', TRUE);
        $this->load->model('admin/Encrypt_model', 'admin');
        $pass = $this->admin->encrypt($passwd);

        $db->select('*, u.img_type as t, u.img as c');
        $db->from(self::sys_usuario.' as u');
        $db->join(self::sys_empleado,' on '. self::sys_empleado .'.id_empleado = u.Empleado');
        $db->join(self::sys_role,' on '. self::sys_role .'.id_rol = u.id_rol');
        $db->join(self::sys_sucursal,' on '. self::sys_sucursal .'.id_sucursal = '. self::sys_empleado.'.Sucursal');

        $db->where('u.nombre_usuario',$usuario);    
        $db->where('u.contrasena_usuario',$pass);   
        $query = $db->get(); 
                    
        if($query->num_rows() > 0 ){
            $this->login_log($query->result());
            return $query->result();
        }else{

            return 0;
        } 
    }

    public function usuarios()
    {   
        
        $this->db->select('*');
        $this->db->from(self::users); 
        $query = $this->db->get();  
        
        if($query->num_rows() > 0 ){
            return $query->result();
        }else{
            return 0;
        } 
    }

    private function login_log($user_login)
    {
        $colores = array("text-danger","text-info", "text-primary", "text-success", "text-warning", "text-purple");

        $data = array(
            'id_usuario' => $user_login[0]->id_usuario,
            'id_sucursal' => $user_login[0]->id_sucursal,
            'color_login' => $colores[rand(1,5)]
        );

        $insert = $this->db->insert(self::sys_login, $data);  
        if(!$insert){
            $insert = $this->db->error();
        }
    }
}
