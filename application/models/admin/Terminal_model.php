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
    const usuario_dispositivo = 'pos_usuario_dispositivo';

	public function validar_usuario_terminal( $usuario_id , $terminal_nombe ){
		$this->db->select('*');
        $this->db->from(self::pos_terminal.' as terminal');
        $this->db->join(self::pos_terminal_cajero.' as cajero ',' on cajero.Terminal = terminal.id_terminal ');
        $this->db->join(self::caja.' as caja', ' on caja.id_caja = terminal.Caja');
        $this->db->join(self::usuario_dispositivo.' as dispositivo', ' on dispositivo.usuario_id = cajero.Cajero_terminal');
        $this->db->where('dispositivo.usuario_id = '. $usuario_id);
        $this->db->where('dispositivo.dispositivo_nombre = ', $terminal_nombe);
        //$this->db->where('cajero.estado_terminal_cajero = ', 1);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    public function selecionar_usuario_terminal( $usuario_id , $terminal_nombe ){
		$this->db->select('*');
        $this->db->from(self::pos_terminal.' as terminal');
        $this->db->join(self::pos_terminal_cajero.' as cajero ',' on cajero.Terminal = terminal.id_terminal ');
        $this->db->join(self::caja.' as caja', ' on caja.id_caja = terminal.Caja');
        $this->db->join(self::usuario_dispositivo.' as dispositivo', ' on dispositivo.usuario_id = cajero.Cajero_terminal');
        $this->db->where('dispositivo.usuario_id = '. $usuario_id);
        $this->db->where('dispositivo.dispositivo_nombre = ', $terminal_nombe);
        $this->db->where('cajero.estado_terminal_cajero = ', 1);
        $this->db->where('dispositivo.dispositivo_estado = ', 1);
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
     * @param string $terminal_nombe
     * @return void
     */
    public function insertar_usuario_terminal($usuario_id , $terminal_nombe)
    {
        /** Buscar si existe usuario/dispositivo en dispositivos de usuario */
        $dispositivos = $this->get_dispositivos($usuario_id, $terminal_nombe);

        if ( !$dispositivos ) {
            
            $data = array(
                'usuario_id' => $usuario_id,
                'dispositivo_nombre' => $terminal_nombe,
                'dispositivo_estado' => 0,
                'creado' => date('Y-m-d h:s:i')
            );

            /** Insertar usuario/dispositivo nuevo */
            $insert = $this->db->insert( self::usuario_dispositivo , $data );
                
            if(!$insert){
                $insert = $this->db->error();
            } else {
                return true;
            }
        }
    }

    private function get_dispositivos($usuario_id , $terminal_nombe) 
    {
        $this->db->select('*');
        $this->db->from( self::usuario_dispositivo);
        $this->db->where('usuario_id', $usuario_id);
        $this->db->where('dispositivo_nombre', $terminal_nombe);

        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    public function get_all_terminal( $limit, $id , $filters){;
        $this->db->select('*');
        $this->db->from( self::pos_terminal.' as terminal');
        $this->db->join( self::sucursal.' as sucursal',' on terminal.Sucursal=sucursal.id_sucursal' );
        $this->db->join(self::caja . ' as caja',' on  caja.id_caja = terminal.Caja');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = terminal.estado_terminal');
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

    public function dispositivo( $data ){

        if ($data['option'] == "post") {

            $device = $this->get_dispositivos($data['usuario_id'], $data['dispositivo_nombre']);

            if (!$device) {
                $dispositivo = array(
                    'usuario_id' => $data['usuario_id'],
                    'dispositivo_nombre' => $data['dispositivo_nombre'],
                    'dispositivo_estado' => 1,
                    'creado' => date('Y-m-d h:i:s')
                );
    
                $insert = $this->db->insert( self::usuario_dispositivo , $dispositivo );
    
                if(!$insert){
                    $insert = $this->db->error();
                }
            }
        }

        if ($data['option'] == "delete") {

            $condition = array(
                'usuario_id' => $data['usuario_id'],
                'id' => $data['id_terminal']
            );
    
            $this->db->where(  $condition );
            $insert = $this->db->delete( self::usuario_dispositivo);
        }

        if ($data['option'] == "inactivar") {

            $this->db->select('*');
            $this->db->from(self::usuario_dispositivo);
            $this->db->where('id', $data['id_terminal']);             
            $query = $this->db->get();
            $device = $query->result();

            $value_estado = $device[0]->dispositivo_estado == 0 ? 1 : 0;

            $condition = array(
                'id' => $data['id_terminal']
            );
    
            $array = array(
                'dispositivo_estado' => $value_estado,
            );
    
            $this->db->where(  $condition );
            $this->db->update( self::usuario_dispositivo , $array );
        }

        $this->db->select('*');
        $this->db->from(self::usuario_dispositivo);
        $this->db->where('usuario_id', $data['usuario_id']);             
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
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