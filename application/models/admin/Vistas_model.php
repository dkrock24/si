<?php
class Vistas_model extends CI_Model {

    const sys_vistas      = 'sys_vistas';
    const sys_componentes      = 'sys_componentes';
    const sys_vistas_componentes = 'sys_vistas_componentes';
    const sys_vistas_acceso = 'sys_vistas_acceso';
    const roles = 'sys_role';
    const menus = 'sys_menu_submenu';
    const sys_vistas_documento = 'sys_vistas_documento';
    const pos_tipo_documento = 'pos_tipo_documento';

	function get_vistas( $limit, $id ,$filters){

        $this->db->select('v.*,  count(vc.Vista) as total');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::sys_vistas_componentes.' as vc', ' on vc.Vista = v.id_vista','left');
        $this->db->join(self::sys_componentes.' as c', ' on c.id_vista_componente = vc.Componente','left');
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->group_by('v.id_vista');
        $this->db->limit($limit, $id);
        
        $query = $this->db->get();   
        //echo $this->db->queries[2];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function get_all_vistas(){

        $this->db->select('v.*,  count(vc.Vista) as total');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::sys_vistas_componentes.' as vc', ' on vc.Vista = v.id_vista','left');
        $this->db->join(self::sys_componentes.' as c', ' on c.id_vista_componente = vc.Componente','left');
        $this->db->group_by('v.id_vista');
        $this->db->order_by('v.vista_nombre', 'asc');
        $query = $this->db->get();           
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function get_vista_doc($documento){
        $this->db->select('*');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::sys_vistas_documento.' as vd', ' on vd.vista_id = v.id_vista','left');
        $this->db->join(self::pos_tipo_documento.' as td', ' on td.id_tipo_documento = vd.documento_id','left');
        $this->db->where('vd.documento_id', $documento);
        $this->db->order_by('v.vista_nombre', 'asc');
        $query = $this->db->get();           
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function get_vista_documento($vista){
        $this->db->select('*');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::sys_vistas_documento.' as vd', ' on vd.vista_id = v.id_vista','left');
        $this->db->join(self::pos_tipo_documento.' as td', ' on td.id_tipo_documento = vd.documento_id','left');
        $this->db->where('v.id_vista', $vista);
        $this->db->where('td.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();           
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function asociar($documento , $vista){
        $data = $this->validAsociar($documento , $vista);
        if(!$data){
            $data = array(
                'documento_id'  => $documento,
                'vista_id'      => $vista,
            );
            $this->db->insert(self::sys_vistas_documento, $data );
        }
    }

    function remover($documento , $vista){
        $this->db->where("documento_id", $documento );
        $this->db->where("vista_id", $vista );
        $this->db->delete(self::sys_vistas_documento );        
    }

    function validAsociar($documento , $vista){
        $this->db->select('*');
        $this->db->from(self::sys_vistas_documento);
        $this->db->where('documento_id', $documento);
        $this->db->where('vista_id', $vista);
        $query = $this->db->get();           
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filters){
        
        
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->from(self::sys_vistas);
        $result = $this->db->count_all_results();
        return $result;
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

    function record_count_componente( $vista_id ){
        $query = $this->db->where('Vista', $vista_id )->get('sys_vistas_componentes');
        return $query->num_rows();
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

    function getVistaId($id){
        $this->db->select('Vista');
        $this->db->from(self::sys_vistas_componentes);
        $this->db->where('id',$id);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function componente_eliminar($componente_vista_id){

        // Retornar Vista Id
        
        $Vista_id = $this->getVistaId($componente_vista_id);

        // eliminando Acceso a compoente vista
        $this->db->where('id_vista_componente', $componente_vista_id);
        $this->db->delete(self::sys_vistas_acceso); 

        // Eliminando Componente de la vista
        $this->db->where('id', $componente_vista_id);
        $this->db->delete(self::sys_vistas_componentes);
        
        return $Vista_id[0]->Vista;

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

        $roles = $this->getRoles($role);

        foreach ($roles as $key => $r) {
            
            $data = array(
                'id_role' => $r->id_rol,
                'id_vista_componente' =>  $id_componente,
                'vista_acceso_creado' => date("Y-m-d h:i:s"),
                'vista_acceso_estado' => 0
            );
            $this->db->insert(self::sys_vistas_acceso, $data );
        }
    }

    function getRoles($role){
        
        $this->db->select();
        $this->db->from(self::roles);
        $this->db->where('id_rol', $role );
        $query = $this->db->get();   

        $roles = $query->result();

        $this->db->select();
        $this->db->from(self::roles);
        $this->db->where('Empresa', $roles[0]->Empresa );
        $this->db->where('id_rol !=', $role );
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }         
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

    function buscar_vista( $vista ){

        $this->db->select('*');
        $this->db->from(self::sys_vistas.' as v');
        $this->db->join(self::menus.' as m',' on v.id_vista = m.id_vista');
        $this->db->where('v.vista_estado', 1);
        $this->db->like('v.vista_nombre', $vista , 'both');
        $query = $this->db->get();
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
        

    }

}