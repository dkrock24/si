<?php
class Vistas_model extends CI_Model {

    const sys_vistas      = 'sys_vistas';
    const sys_componentes      = 'sys_componentes';
    const sys_vistas_componentes = 'sys_vistas_componentes';
    const sys_vistas_acceso = 'sys_vistas_acceso';

	function get_vistas( $limit, $id ){

        $this->db->select('v.*,  count(c.Vista) as total');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::sys_componentes.' as c', ' on c.Vista = v.id_vista','left');
        $this->db->group_by('v.id_vista');
        $this->db->limit($limit, $id);
        //$this->db->where('vista_estado', 1);
        $query = $this->db->get();   
        //echo $this->db->queries[2];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        return $this->db->count_all(self::sys_vistas);
    }

    function vistas_componente_by_id( $vista_id, $limit, $id ){

        $this->db->select('*');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::sys_vistas_componentes.' as vc', ' on vc.Vista = v.id_vista','left');
        $this->db->join(self::sys_componentes.' as c', ' on c.id_vista_componente = vc.Componente','left');
        $this->db->where('vc.Vista', $vista_id);
        //$this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count_componente( $vista_id){
        return $this->db->count_all(self::sys_vistas_componentes, ' where Vista = '.$vista_id);
    }

    function crear($data){

        $data = array(
            'vista_nombre' => $data['vista_nombre'],
            'vista_codigo' => $data['vista_codigo'],
            'vista_accion' =>  $data['vista_accion'],
            'vista_descripcion' => $data['vista_descripcion'],
            'vista_url' => $data['vista_url'],
            'vista_creado' => date("Y-m-d h:i:s"),
            'vista_estado' => 1,
        );
        $this->db->insert(self::sys_vistas, $data );
    }

    function editar($data){
        $data = array(
            'vista_nombre' => $data['vista_nombre'],
            'vista_codigo' => $data['vista_codigo'],
            'vista_accion' =>  $data['vista_accion'],
            'vista_descripcion' => $data['vista_descripcion'],
            'vista_url' => $data['vista_url'],
            'vista_creado' => date("Y-m-d h:i:s"),
            'vista_estado' => 1,
        );
        $this->db->update(self::sys_vistas, $data );
    }

    function vistas_by_id( $vista_id ){

        $this->db->select('*');
        $this->db->from(self::sys_vistas);    
        $this->db->where('vista_estado', 1);
        $this->db->where('id_vista', $vista_id );
        $query = $this->db->get();   
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function update($datos){

        $data = array(
            'vista_nombre'  => $datos['vista_nombre'],
            'vista_codigo'  => $datos['vista_codigo'],
            'vista_accion'  =>  $datos['vista_accion'],
            'vista_descripcion' => $datos['vista_descripcion'],
            'vista_url'     => $datos['vista_url'],
            'vista_actualizado' => date("Y-m-d h:i:s"),
            'vista_estado'  =>  $datos['vista_estado'],
        );
        $this->db->where('id_vista', $datos['id_vista']);
        $this->db->update(self::sys_vistas, $data );
    }

    //Componentes Vistas

    function get_vistas_componentes(){

        $this->db->select('count(*)');
        $this->db->from(self::sys_vistas .' v');    
        $this->db->join(self::sys_componentes. ' vc', ' on v.id_vista = vc.Vista');  
        $this->db->group_by(self::sys_componentes .' vc.Vista');    
        $query = $this->db->get();   
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    /* Funciones para la seccion de componentes de vistas - CRUD */

    function get_all_componentes(){
        $this->db->select('*');
        $this->db->from(self::sys_componentes .' v');
        $query = $this->db->get();   
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function componente_crear( $componente ){
        $data = array(
            //'Vista' => $componente['vista_id'],
            'accion_nombre' => $componente['accion_nombre'],
            'accion_btn_nombre' =>  $componente['accion_btn_nombre'],
            'accion_descripcion' => $componente['accion_descripcion'],
            'accion_btn_css' => $componente['accion_btn_css'],
            'accion_btn_icon' => $componente['accion_btn_icon'],
            'accion_btn_url' => $componente['accion_btn_url'],
            'accion_btn_codigo' => $componente['accion_btn_codigo'],
            
            'accion_valor' => $componente['accion_valor'],           
            'accion_estado' => $componente['accion_estado'],           
        );
        $this->db->insert(self::sys_componentes, $data );
        $id_componente = $this->db->insert_id();

        $this->vista_componente_crear($id_componente , $componente['vista_id'] , $componente['role']);
        
    }

    function vista_componente_crear( $id_componente , $vista_id ,$role ){

        $last = $this->get_last_order_number($vista_id);

        $last_order = $last[0]->ultimo+1;
        
        $data = array(
            'Vista' => $vista_id,
            'Componente' =>  $id_componente,
            'order' => $last_order,
            'vista_componente_estado' => 1         
        );
        $this->db->insert(self::sys_vistas_componentes, $data );
        $id_componente = $this->db->insert_id();

        $this->vista_acceso_crear( $id_componente , $role );
    }

    function get_last_order_number( $vista_id ){
        $this->db->select('max(c.order) as ultimo');
        $this->db->from(self::sys_vistas_componentes.' as c');
        $this->db->where('c.Vista', $vista_id );
        $this->db->order_by('c.order','asc' );
        $query = $this->db->get();   
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function vista_acceso_crear( $id_componente , $role ){
        $data = array(
            'id_role' => $role,
            'id_vista_componente' =>  $id_componente,
            'vista_acceso_creado' => date("Y-m-d h:i:s"),
            'vista_acceso_estado' => 1        
        );
        $this->db->insert(self::sys_vistas_acceso, $data );
    }

    function copiar_componente( $vista_id , $componente_id , $role ){
        // Insertar componente copiado

        $last_order =1;

        $last = $this->get_last_order_number($vista_id);
        
        if($last){
            $last_order = $last[0]->ultimo+1;
        }

        $data = array(
            'Vista' => $vista_id,
            'Componente' =>  $componente_id,
            'order' => $last_order,
            'vista_componente_estado' => 1
        );
        $this->db->insert(self::sys_vistas_componentes, $data );
        $id_componente = $this->db->insert_id();

        $this->vista_acceso_crear( $id_componente , $role );
    }

}