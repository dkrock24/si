<?php
class Terminal_model extends CI_Model {

    const pos_terminal = 'pos_terminal';
    const pos_terminal2 = 'pos_terminal2';
    const pos_terminal_cajero = 'pos_terminal_cajero';
    const pos_terminal_cajero2 = 'pos_terminal_cajero2';
    const sucursal = "pos_sucursal";
    const caja = 'pos_caja';
    const usuario = 'sys_usuario';
    const empleado = 'sys_empleado';
    const persona = 'sys_persona';
    const pos_orden_estado = 'pos_orden_estado';

    public function __construct()
	{
		parent::__construct();    
		$this->load->model('admin/Caja_model');
	}

    public function get_terminal_registrada($usuario_id , $_unique_uuid)
    {
        $this->db->select('*');
        $this->db->from(self::pos_terminal. ' terminal');
        $this->db->join(self::caja.' as caja', ' on caja.id_caja = terminal.Caja');
        $this->db->where('terminal.ip_o_mack', $_unique_uuid);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /**
     * Crear Usuario en terminales cuando no existen
     *
     * @param int $usuario_id
     * @param string $_unique_uuid
     * @param string $dispositivo_info
     * @return void
     */
    public function crear_terminal_dispositivo($usuario_id , $_unique_uuid, $dispositivo_info, $usuario_datos)
    {
        /** Buscar si existe usuario/dispositivo en dispositivos de usuario */
        $sucursal_id = $this->session->usuario[0]->Sucursal;
        $cajas = $this->Caja_model->get_caja_sucursal($sucursal_id);

        if ($cajas) {
            $terminal = array(
                'Caja' => $cajas[0]->id_caja,
                'series' => $dispositivo_info['general'],
                'marca' => $dispositivo_info['so'],
                'nombre' => $usuario_datos['nombre_input'],
                'licencia' => $usuario_datos['licencia_input'],
                'modelo' => $dispositivo_info['so'],
                'Sucursal' => $sucursal_id,
                'Usuario' => $usuario_id,
                'ip_o_mack' => $_unique_uuid,
                'navegador' => $dispositivo_info['browser'],
                'sys_autorz' => 0,
                'emp_autorz' => 3,
                'dispositivo' => $dispositivo_info['device'],
                'dispositivo_tactil' => $dispositivo_info['dispositivo_tactil'],
                'estado_terminal' => 0,
                'sist_operativo' => $dispositivo_info['so'],
                'fh_inicio' => date('Y-m-d h:s:i'),
                'fecha_creado' => date('Y-m-d h:s:i')
            );
            /** Insertar usuario/dispositivo nuevo */
            $insert = $this->crear($terminal);

            if(!$insert){
                $insert = $this->db->error();
            } else {
                return true;
            }
        } else {
            $caja = array(
                'Empresa' => $this->session->empresa[0]->id_empresa,
                'Sucursal' => $sucursal_id,
                'nombre_caja' => "Caja Generica",
                'cod_interno_caja' => 000,
                'pred_id_tpdoc' => null,
                'fecha_oper_caja' => date('Y-m-d h:s:i'),
                'estado_caja' => 1
            );
            $this->Caja_model->crear_caja($caja);

            $this->crear_terminal_dispositivo($usuario_id , $_unique_uuid, $dispositivo_info, $usuario_datos);
        }
    }

    public function get_all_terminal( $limit, $id , $filters){;
        $this->db->select('*, u.nombre_usuario');
        $this->db->from( self::pos_terminal.' as terminal');
        $this->db->join( self::sucursal.' as sucursal',' on terminal.Sucursal=sucursal.id_sucursal' );
        $this->db->join(self::caja . ' as caja',' on  caja.id_caja = terminal.Caja');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = terminal.estado_terminal');
        $this->db->join(self::usuario. ' u',' on u.id_usuario = terminal.Usuario');
        $this->db->where('sucursal.Empresa_Suc', $this->session->empresa[0]->id_empresa);
        $this->db->order_by('sucursal.id_sucursal','asc');
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

    public function get_terminal_lista(){
        $this->db->select('*');
        $this->db->from( self::pos_terminal.' as terminal');
        $this->db->join( self::sucursal.' as sucursal',' on terminal.Sucursal=sucursal.id_sucursal' );
        $this->db->where('sucursal.Empresa_Suc', $this->session->empresa[0]->id_empresa);

        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filter){
        $this->db->where('sucursal.Empresa_Suc', $this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from( self::pos_terminal.' as terminal');
        $this->db->join( self::sucursal.' as sucursal',
                                    ' on terminal.Sucursal=sucursal.id_sucursal' );
        $this->db->join(self::caja . ' as caja',' on  caja.id_caja = terminal.Caja');
        $result = $this->db->count_all_results();
        return $result;
    }

    public function crear( $data ){
        $insert = $this->db->insert( self::pos_terminal , $data );
        if(!$insert){
            $insert = $this->db->error();
        }
        return $insert;
    }

    public function get_terminal( $terminal_id ){
        $this->db->where('t.id_terminal', $terminal_id );
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa );
        $this->db->from( self::pos_terminal.' as t');
        $this->db->join(self::sucursal. ' as s', ' on s.id_sucursal = t.Sucursal');
        $query = $this->db->get();
        return $query->result();
    }

    public function update( $data ){
        $this->db->where('id_terminal' , $data['id_terminal']);
        $insert = $this->db->update( self::pos_terminal , $data );

        if(!$insert){
            $insert = $this->db->error();
        }
        return $insert;
        
    }

    public function eliminar( $id ) {
        $this->db->where('id_terminal' , $id );
        $insert = $this->db->delete( self::pos_terminal );   

        if(!$insert){
            $insert = $this->db->error();
        }
        return $insert;
    }

    public function get_terminal_by_caja($id_caja){
        $this->db->where('Caja', $id_caja );
        $this->db->from( self::pos_terminal);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_terminal_users( $id_terminal ){

        $this->db->select('*');
        $this->db->from(self::usuario.' as u');        
        $this->db->join(self::pos_terminal_cajero.' as tc', ' u.id_usuario = tc.Cajero_terminal ','Left');
        $this->db->join(self::pos_terminal.' as t', ' t.id_terminal = tc.Terminal ','Left');
        $this->db->join(self::sucursal.' as s', ' s.id_sucursal = t.Sucursal ','Left');
        $this->db->join(self::empleado.' as e', ' e.id_empleado = u.Empleado ');
        $this->db->join(self::persona.' as p', ' p.id_persona = e.Persona_E ');
        $this->db->where('tc.Terminal = ', $id_terminal);             

        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_users($data, $id_terminal){

        $this->db->select('*');
        $this->db->from(self::usuario.' as u');
        $this->db->join(self::empleado.' as e', ' e.id_empleado = u.Empleado ');
        $this->db->join(self::sucursal.' as s', ' s.id_sucursal = e.Sucursal ');
        $this->db->join(self::persona.' as p', ' p.id_persona = e.Persona_E ');
        $this->db->join(self::pos_terminal_cajero.' as terminal', ' terminal.Cajero_terminal = u.id_usuario');
        $this->db->where('s.Empresa_Suc ', $this->session->empresa[0]->id_empresa);
        $this->db->where('terminal.Terminal ', $id_terminal);
        $this->db->order_by('s.id_sucursal',' desc');
        
        $query = $this->db->get(); 
        //echo $this->db->queries[7];die;
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }

    }

    public function get_user_terminal( $data ){

        $this->db->select('*');
        $this->db->from(self::pos_terminal_cajero);

        $this->db->where('Terminal', $data['terminal']);             
        $this->db->where('Cajero_terminal', $data['usuario']);
        //$this->db->where('dispositivo_terminal', $data['dispositivo']);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_user_terminal_desactivar( $data ){

        $this->db->select('*');
        $this->db->from(self::pos_terminal_cajero);
        $this->db->where('Terminal', $data['terminal']);             
        $this->db->where('Cajero_terminal', $data['usuario']);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function agregar_usuario($data){
        
        $existe = $this->get_user_terminal($data);
        $flag = false;

        if(!$existe){

            $array = array(
                'Terminal' => $data['terminal'],
                'Cajero_terminal' => $data['usuario'],
                'estado_terminal_cajero' => 0
            );

            $this->db->insert( self::pos_terminal_cajero , $array );

            $flag = true;
        }
        return $flag;
    }

    public function sincronizar_usuarios($terminal)
    {
        $usuarios = $this->get_usuarios();

        foreach ($usuarios as $key => $usuario) {

            $data = array(
                'terminal' => $terminal,
                'usuario' => $usuario->id_usuario
            );

            $existe  = $this->get_user_terminal_desactivar($data);

            if(!$existe) {

                $array = array(
                    'Terminal' => $terminal,
                    'Cajero_terminal' => $usuario->id_usuario,
                    'estado_terminal_cajero' => 0
                );
    
                $this->db->insert( self::pos_terminal_cajero , $array );
            }
        }
    }

    public function get_usuarios()
    {
        $this->db->select('*');
        $this->db->from(self::usuario. ' as u');
        $this->db->join(self::empleado.' as e', ' e.id_empleado = u.Empleado ');
        $this->db->join(self::sucursal.' as s', ' s.id_sucursal = e.Sucursal ');
        $this->db->where('s.Empresa_Suc', $this->session->empresa[0]->id_empresa);             
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function unload($terminal , $estado){

        $usuario = $this->session->userdata['usuario'][0]->id_usuario;

        $condition = array(
            'Terminal' => $terminal,
            'Cajero_terminal' => $usuario
        );

        $array = array(
            'activa' => $estado,
        );

        $this->db->where(  $condition );
        $this->db->update( self::pos_terminal_cajero , $array );

    }

    public function eliminar_usuario( $data ){

        $flag = true;

        $existe = $this->get_user_terminal_desactivar($data);
        $valor  = 1;

        if($existe){
            if( $existe[0]->estado_terminal_cajero == 1 ){
                $valor = 0;
                $flag = false;
            }
        }

        $array = array(
            'estado_terminal_cajero' => $valor
        );

        $condition = array(
            'Terminal' => $data['terminal'],
            'Cajero_terminal' => $data['usuario']
        );

        $this->db->where(  $condition );
        $insert = $this->db->update( self::pos_terminal_cajero , $array );

        if(!$insert){
            $insert = $this->db->error();
        }
        
        return $flag;
    }

    function insert_api($terminales)
    {
        $this->db->truncate(self::pos_terminal2);

        $data = [];
        foreach ($terminales as $key => $terminal) {
            $data[] = $terminal;
        }
        $this->db->insert_batch(self::pos_terminal2, $data);
    }

    function insert_cajero_api($terminales_cajeros)
    {
        $this->db->truncate(self::pos_terminal_cajero2);

        $data = [];
        foreach ($terminales_cajeros as $key => $cajeros) {
            $data[] = $cajeros;
        }
        $this->db->insert_batch(self::pos_terminal_cajero2, $data);
    }
}