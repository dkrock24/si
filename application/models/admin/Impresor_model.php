<?php
class Impresor_model extends CI_Model {
	const empleado  =  'sys_empleado';
    const sucursal  = 'pos_sucursal';
    const persona   = 'sys_persona';
    const usuario_roles     = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_empresa       = 'pos_empresa';
    const pos_impresor        = 'pos_impresor';
    const pos_orden_estado  = 'pos_orden_estado';
    const impresor_terminal = 'pos_impresor_terminal';
    const pos_terminal = ' pos_terminal';
    const pos_tipo_documento = 'pos_tipo_documento';

    public function get_impresor(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::pos_impresor);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = pos_impresor.impresor_estado');
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

    public function get_all_impresor(){
        $this->db->select('*');
        $this->db->from(self::pos_impresor);
        $this->db->where('impresor_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_impresor_empresa(){
        $this->db->select('*');
        $this->db->from(self::pos_impresor.' as i');
        $this->db->join(self::pos_empresa.' as e','on e.id_empresa = i.impresor_empresa');
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_impresor_terminal(){

        $this->db->select('i.*,it.*,t.nombre as terminal_nombre, t.codigo as terminal_codigo, d.nombre as documento_nombre');
        $this->db->from(self::pos_impresor.' as i');
        $this->db->join(self::impresor_terminal.' as it','on it.impresor_id = i.id_impresor');
        $this->db->join(self::pos_terminal.' as t','on t.id_terminal = it.terminal_id');
        $this->db->join(self::pos_tipo_documento.' as d','on d.id_tipo_documento = it.documento_id');
        $this->db->join(self::pos_empresa.' as e','on e.id_empresa = i.impresor_empresa');
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::pos_impresor);
    }

    public function save($impresor , $documentos, $terminales){

        $data = $impresor;
        $data['impresor_empresa'] = $this->session->empresa[0]->id_empresa;

        $result = $this->db->insert(self::pos_impresor, $data ); 

        if(!$result){
            $result = $this->db->error();
            return $result;
        }

        $id_impresor = $this->db->insert_id();

        $this->procesar_impresor_terminal_documento($id_impresor, $documentos, $terminales);

        return $result;
    }

    function procesar_impresor_terminal_documento($id_impresor, $documentos, $terminales) {

        foreach ($terminales as $terminal) {
            
            foreach ($documentos as $documento) {

                $_terminal  = $terminal->id_terminal;
                $_documento = $documento->id_tipo_documento;

                $record = $this->check_impresor_terminal_exist($id_impresor, $_terminal, $_documento);

                if( !$record ) {
                    
                    $data = array(
                        'impresor_id'       => $id_impresor,
                        'terminal_id'       => $_terminal,
                        'documento_id'      => $_documento,
                        'impresor_terminal_estado'   => 0,
                        'impresor_principal'=> 1,
                    );
                    
                    $this->db->insert(self::impresor_terminal, $data);
                }
            }
        }
    }

    public function impresor_estado($id) {
        
        $id = $id['impresor'];

        $valor = $this->check_impresor_estado($id);
        $valor = $valor[0]->impresor_terminal_estado;

        $estado = $valor == 0 ? 1 : 0;

        $data = array(
            'impresor_terminal_estado'   => $estado,
        );
        
        $this->db->where('id_impresor_terminal', $id);
        $result = $this->db->update(self::impresor_terminal, $data);

        return $estado;
    }

    private function check_impresor_estado($id) {
        
        $this->db->select('impresor_terminal_estado');
        $this->db->from(self::impresor_terminal);
        $this->db->where('id_impresor_terminal',  $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    private function check_impresor_terminal_exist($id_impresor, $_terminal, $_documento){
        
        $this->db->select('*');
        $this->db->from(self::impresor_terminal);
        $this->db->where('terminal_id',  $_terminal);
        $this->db->where('documento_id', $_documento);
        $this->db->where('impresor_id',  $id_impresor);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_impresor_id( $impresor_id ){
        $this->db->select('*');
        $this->db->from(self::pos_impresor);
        $this->db->where('id_impresor', $impresor_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function update($impresor){

        $data = $impresor;

        $this->db->where('id_impresor', $impresor['id_impresor'] );
        $result =  $this->db->update(self::pos_impresor, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    public function eliminar( $id ){
        
        $data = array(
            'id_impresor' => $id
        );

        $this->db->where('id_impresor', $id);
        $result =  $this->db->delete(self::pos_impresor, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

}
