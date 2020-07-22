<?php
class Empresa_model extends CI_Model {

	const empleado      = 'sys_empleado';
    const sucursal      = 'pos_sucursal';
    const persona       = 'sys_persona';  
    const pos_empresa   = 'pos_empresa';
    const sys_moneda    = 'sys_moneda';
    const usuario_roles = 'sys_usuario_roles';
    const empleado_sucursal = 'sys_empleado_sucursal';
    const pos_orden_estado = 'pos_orden_estado';

    function getEmpresas( $limit, $id , $filters){
        
        $this->db->select('id_empresa , nombre_razon_social ,nombre_comercial,nrc,nit,autorizacion,giro,direccion,slogan,resolucion,representante,
        ,website,tiraje,tel,moneda_nombre,natural_juridica,metodo_inventario,admin,codigo,empresa_creado,empresa_actualizado,empresa_estado,es.*');
        $this->db->from(self::pos_empresa.' e');
        $this->db->join(self::sys_moneda.' m', 'on e.Moneda = m.id_moneda');
        $this->db->join( self::pos_orden_estado .' as es', ' on es.id_orden_estado = e.empresa_estado' );
        
        if($this->session->empresa[0]->id_empresa == 1){
            //$this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
            $this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        }else{
            $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa );
            //$this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        }
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        
        $query = $this->db->get();
        //echo $this->db->queries[0];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count($filter){

        //return $this->db->count_all(self::correlativos);
        if($this->session->empresa[0]->id_empresa == 1){
            //$this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
            $this->db->where('e.codigo', $this->session->empresa[0]->codigo . ' '. $filter);
        }else{
            $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa . ' '. $filter );
            //$this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        }

        $this->db->from(self::pos_empresa.' as e');
        $result = $this->db->count_all_results();
        return $result;
    }

    function getEmpresaOnly( ){

        $this->db->select('*');
        $this->db->from(self::pos_empresa.' e');
        //$this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        $this->db->where('id_empresa', $this->session->empresa[0]->id_empresa);
        
        $query = $this->db->get();
        //echo $this->db->queries[3];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getEmpresasWithSucursal( $empleado_id ){
        
        if($empleado_id){
            $id_empleado = $empleado_id;
        }else{
            $id_empleado = (int)$this->session->usuario[0]->id_empleado;
        }  

        $this->db->select('*');
        $this->db->from(self::pos_empresa.' e');
        $this->db->join(self::sucursal.' s', 'on s.Empresa_Suc = e.id_empresa','left');
        $this->db->join(self::empleado_sucursal.' es', 'on es.es_sucursal = s.id_sucursal','left');
        $this->db->join(self::sys_moneda.' m', 'on e.Moneda = m.id_moneda');
        $this->db->where('e.codigo', $this->session->empresa[0]->codigo);
        
        $this->db->where('  (es.es_empleado = '.$empleado_id .')');
        //$this->db->group_by('s.id_sucursal');
        
        if($this->session->usuario[0]->id_rol == 1){
            //$this->db->where_in('e.admin', array($id_empleado));
        }else{
            //$this->db->where_in('e.admin', array($id_empleado) );
        }
        
        $query = $this->db->get();
        //echo $this->db->queries[3];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getEmpresasWithSucursal2( $datos ){
        
        $this->db->select('*');
        $this->db->from(self::pos_empresa.' e');
        $this->db->join(self::sucursal.' s', 'on s.Empresa_Suc = e.id_empresa','right');
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa);
        $this->db->where_not_in('s.id_sucursal', $datos);
        $this->db->order_by('e.id_empresa');
       
        $query = $this->db->get();
        //echo $this->db->queries[4];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
        
    }

	function get_empresa_by_id( $empresa_id ){

		$this->db->select('*');
        $this->db->from(self::pos_empresa);
        $this->db->where(self::pos_empresa.'.id_empresa = ', $empresa_id);
        $this->db->where(self::pos_empresa.'.empresa_estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function save($empresa){

        // Insertando Imagenes empresa
        $imagen="";
        if($_FILES['logo_empresa']['tmp_name']){
            $imagen = file_get_contents($_FILES['logo_empresa']['tmp_name']);
            $imageProperties = getimageSize($_FILES['logo_empresa']['tmp_name']);
        }

        $data = array();

        if( isset($empresa['codigo']) ){
            $data['codigo'] = $empresa['codigo'];
        }

        $data = array(
            'nombre_razon_social'   => $empresa['nombre_razon_social'],
            'nombre_comercial'      => $empresa['nombre_comercial'],
            'nrc'                   => $empresa['nrc'],
            'nit'                   => $empresa['nit'],
            'giro'                  => $empresa['giro'],
            'logo_empresa'          => $imagen,
            'direccion'             => $empresa['direccion'],
            'slogan'                => $empresa['slogan'],
            'representante'         => $empresa['representante'],
            'website'               => $empresa['website'],
            'tel'                   => $empresa['tel'],    
            'Moneda'                => $empresa['Moneda'],
            'natural_juridica'      => $empresa['natural_juridica'],
            'metodo_inventario'     => $empresa['metodo_inventario'],
            'empresa_creado'        => date("Y-m-d h:i:s"),
            'empresa_estado'        => $empresa['empresa_estado']
        );
        $result = $this->db->insert(self::pos_empresa, $data ); 
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getEmpresaId( $empresa_id ){
        $this->db->select('*');
        $this->db->from( self::pos_empresa.' e' );
        $this->db->join( self::sys_moneda.' m', 'on e.Moneda = m.id_moneda' );
        //$this->db->where('e.id_empresa', $this->session->empresa[0]->Empresa_Suc);
        $this->db->where( 'e.id_empresa', $empresa_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($empresa){

        // Insertando Imagenes Empresa
        $imagen="";
        $imagen = @file_get_contents($_FILES['logo_empresa']['tmp_name']);
        $imageProperties = @getimageSize($_FILES['logo_empresa']['tmp_name']);

        $data = array();

        if( isset($empresa['codigo']) ){
            $data['codigo'] = $empresa['codigo'];
        }

        $data = array(
            'nombre_razon_social'   => $empresa['nombre_razon_social'],
            'nombre_comercial'      => $empresa['nombre_comercial'],
            'nrc'                   => $empresa['nrc'],
            'nit'                   => $empresa['nit'],
            'giro'                  => $empresa['giro'],
            'direccion'             => $empresa['direccion'],
            'slogan'                => $empresa['slogan'],
            'representante'         => $empresa['representante'],
            'website'               => $empresa['website'],
            'tel'                   => $empresa['tel'],
            'Moneda'                => $empresa['Moneda'],
            'natural_juridica'      => $empresa['natural_juridica'],
            'metodo_inventario'     => $empresa['metodo_inventario'],
            'empresa_creado'        => date("Y-m-d h:i:s"),
            'empresa_estado'        => $empresa['empresa_estado']
        );

        if(isset($_FILES['logo_empresa']) && $_FILES['logo_empresa']['tmp_name']!=null){
            
            $data = array_merge( $data,array('logo_empresa' => $imagen, 'logo_type'=> $imageProperties['mime'] ));
        }

        $this->db->where('id_empresa', $empresa['id_empresa'] ); 
        $result = $this->db->update(self::pos_empresa, $data ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }    

    function eliminar($id){
        
        $data = array(
            'id_empresa' => $id
        );

        $this->db->where('id_empresa', $id); 
        $result = $this->db->delete(self::pos_empresa, $data ); 
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}