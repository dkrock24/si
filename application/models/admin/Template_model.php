<?php
class Template_model extends CI_Model {

	const cliente =  'pos_cliente';
    const formas_pago =  'pos_formas_pago';
    const tipos_documentos =  'pos_tipo_documento';
    const sys_persona =  'sys_persona';
    const pos_tipo_documento= 'pos_tipo_documento';
    const pos_formas_pago = 'pos_formas_pago';
    const pos_doc_temp = 'pos_doc_temp';
    const pos_sucursal = 'pos_sucursal';
    const pos_temp_sucursal = 'pos_temp_sucursal';


	function get_cliente(){
		$this->db->select('id_cliente,nombre_empresa_o_compania,nrc_cli,nit_cliente,nombre_empresa_o_compania,direccion_cliente,aplica_impuestos,TipoDocumento');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos,' on '.self::cliente.'.TipoDocumento='.self::tipos_documentos.'.id_tipo_documento');
        $this->db->join(self::formas_pago,' on '.self::cliente.'.TipoPago='.self::formas_pago.'.id_modo_pago');
        $this->db->where(self::cliente.'.estado = 1');
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_cliente_by_id2($id){
        $this->db->select('id_cliente,nombre_empresa_o_compania,nrc_cli,nit_cliente,nombre_empresa_o_compania,direccion_cliente,aplica_impuestos,porcentage_descuentos,TipoDocumento,TipoPago');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos,' on '.self::cliente.'.TipoDocumento='.self::tipos_documentos.'.id_tipo_documento');
        $this->db->join(self::formas_pago,' on '.self::cliente.'.TipoPago='.self::formas_pago.'.id_modo_pago');
        $this->db->where(self::cliente.'.estado = 1');

        $this->db->where('id_cliente = '.$id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_clientes_id( $cliente_id ){

        $this->db->select('*');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos,' on '.self::cliente.'.TipoDocumento='.self::tipos_documentos.'.id_tipo_documento');
        $this->db->join(self::formas_pago,' on '.self::cliente.'.TipoPago='.self::formas_pago.'.id_modo_pago');
        $this->db->join(self::sys_persona.' as p', ' on p.id_persona = Persona');
        $this->db->where('p.Empresa', $this->session->empresa[0]->Empresa_Suc);
        //$this->db->where('estado = 1');
        $this->db->where('id_cliente = '.$cliente_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllTemplate( $limit, $id){ 
        $this->db->select('*');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura=ts.Template');
        $this->db->join(self::tipos_documentos.' dt',' on dt.id_tipo_documento=ts.Documento');
        $this->db->join(self::pos_sucursal.' s',' on ts.Sucursal=s.id_sucursal','left');
        
        //$this->db->where(self::pos_sucursal.'.Empresa_Suc', $this->session->empresa[0]->Empresa_Suc);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_template(){ 

        $this->db->select('*');
        $this->db->from(self::pos_doc_temp.' as td');
        //$this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura=ts.Template');
        //$this->db->join(self::tipos_documentos.' dt',' on dt.id_tipo_documento=ts.Documento');
        //$this->db->join(self::pos_sucursal.' s',' on ts.Sucursal=s.id_sucursal','left');
        $this->db->where('td.Empresa', $this->session->empresa[0]->Empresa_Suc);
        
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getTemplateBySucursal($factura_id){
        //$this->db->select('td.id_factura,td.factura_nombre,td.factura_descripcion , dt.nombre, s.nombre_sucursal,ts.id_temp_suc,ts.estado_suc_tem');
        $this->db->select('*');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura=ts.Template');
        $this->db->join(self::tipos_documentos.' dt',' on dt.id_tipo_documento=ts.Documento');
        $this->db->join(self::pos_sucursal.' s',' on ts.Sucursal=s.id_sucursal');
        $this->db->where('ts.Template', $factura_id );
        
        $query = $this->db->get();  
        //echo $this->db->queries[0];       
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function associar_sucursal( $data ){
        $d = $data['documento_id'];
        $f = $data['factura_id'];
        foreach ($data as $key => $b) 
        {
            $sucursal_id = $key;
            
            if(is_numeric($sucursal_id)){

                $encontrados = $this->get_template_sucursal($sucursal_id ,$d , $f);
                
                if($encontrados){
                    foreach ($encontrados as $st) {

                        if( ($st->Sucursal==$sucursal_id && $st->Template== $f && $st->Documento==$d) ){
                           
                        }else{
                            
                            $data = array(
                                'Sucursal' => $sucursal_id,
                                'Template'=> $f,
                                'Documento' => $d,
                                'estado_suc_tem' => 0
                            );                   
                            $this->db->insert(self::pos_temp_sucursal, $data);
                        }                           
                    }
                }else{
                    
                    $data = array(
                                'Sucursal' => $sucursal_id,
                                'Template'=> $f,
                                'Documento' => $d,
                                'estado_suc_tem' => 0
                            );                   
                    $this->db->insert(self::pos_temp_sucursal, $data);
                }
            }
        }
    }

    function get_template_sucursal( $sucursal , $documento , $factura ){
        $this->db->select('*');
        $this->db->from(self::pos_temp_sucursal);
        $this->db->where('Sucursal', $sucursal );
        $this->db->where('Documento', $documento );
        $this->db->where('Template', $factura );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function activacion_sucursal( $datos ){
        // Activar o Desactivar Template de la socursal
        
        $d = $datos['documento_id'];
        $f = $datos['factura_id'];

        $sucursales_validas = $this->get_template_activacion( $d, $f  );

        $data = array('estado_suc_tem' => 0 );
        $this->db->where('Documento', $d);                  
        $this->db->where('Template', $f );
        $this->db->update(self::pos_temp_sucursal, $data);

        foreach ($datos as $key => $b) 
        {
            $sucursal_id = $key;
            
            if(is_numeric($sucursal_id)){

                foreach ($sucursales_validas as $sv) 
                {
                    if( $sv->Sucursal==$sucursal_id ){
                        
                        $data = array('estado_suc_tem' => 1 );                    
                        $this->db->where('id_temp_suc', $sv->id_temp_suc );
                        $this->db->update(self::pos_temp_sucursal, $data);
                    }
                }

            }
        }  
    }

    function get_template_activacion(  $documento , $factura ){
    
        $this->db->select('*');
        $this->db->from(self::pos_temp_sucursal);
        $this->db->where('Documento', $documento );
        $this->db->where('Template', $factura );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getTipoDocumento(){
        $this->db->select('*');
        $this->db->from(self::pos_tipo_documento);
        $this->db->where('Empresa', $this->session->empresa[0]->Empresa_Suc);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getTipoPago(){
        $this->db->select('*');
        $this->db->from(self::pos_formas_pago);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count(){
        return $this->db->count_all(self::pos_doc_temp);
    }

    function crear_template($datos){

        $html = addslashes($datos['template_html']);
        
        $data = array(
            'factura_nombre'        =>  $datos['factura_nombre'],
            'factura_descripcion'   => $datos['factura_descripcion'],
            'factura_template'      => $datos['template_html'],
            'factura_lineas'        => $datos['factura_lineas'],
            'factura_estatus'       => $datos['factura_estatus'],
            'factura_creado'        => date("Y-m-d h:i:s")
        );
        
        $this->db->insert(self::pos_doc_temp, $data);  
    }

    function getFormatoId($formato_id){

        $this->db->select('*');
        $this->db->from(self::pos_doc_temp);
        $this->db->where('id_factura', $formato_id );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($datos){

        $data = array(
            'website_cli'     =>  $datos['website_cli'],
            'nrc_cli'    => $datos['nrc_cli'],
            'nit_cliente'   => $datos['nit_cliente'],
            'clase_cli'  => $datos['clase_cli'],
            'mail_cli'  => $datos['mail_cli'],
            'TipoPago'                       => $datos['TipoPago'],
            'TipoDocumento'=> $datos['TipoDocumento'],
            'nombre_empresa_o_compania'=> $datos['nombre_empresa_o_compania'],
            'numero_cuenta'                       => $datos['numero_cuenta'],
            'aplica_impuestos'                       => $datos['aplica_impuestos'],
            'direccion_cliente'                      => $datos['direccion_cliente'],
            'porcentage_descuentos'                  => $datos['porcentage_descuentos'],
            'estado'                      => $datos['estado'],
            'creado'                    => date("Y-m-d h:i:s"),
            'Persona'               => $datos['Persona'],
            'natural_juridica'            => $datos['natural_juridica']
        );

        if(isset($_FILES['logo_cli']) && $_FILES['logo_cli']['tmp_name']!=null){
             // Insertando Imagenes Empresa
            $imagen="";
            $imagen = file_get_contents($_FILES['logo_cli']['tmp_name']);
            $imageProperties = getimageSize($_FILES['logo_cli']['tmp_name']);

            $data = array_merge( $data,array('logo_cli' => $imagen, 'logo_type'=> $imageProperties['mime'] ));
        }

        $this->db->where('id_cliente', $datos['id_cliente'] ); 
        $this->db->update(self::cliente, $data ); 
    }

    //Test Printer
    function printer( $orden_id , $sucursal_id , $documento_id){
        
        $this->db->select('*');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura = ts.Template');
        
        $this->db->where('ts.Sucursal', $sucursal_id);
        $this->db->where('ts.Documento', $documento_id);
        $this->db->where('ts.estado_suc_tem', 1);

        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}