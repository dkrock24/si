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
    const pos_empresa = 'pos_empresa';
    const pos_orden = 'pos_ordenes';
    const pos_ventas = 'pos_ventas';
    const sucursal = 'pos_sucursal';
    const pos_orden_estado = 'pos_orden_estado';

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
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        //$this->db->where('estado = 1');
        $this->db->where('id_cliente = '.$cliente_id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllTemplate( $limit, $id , $filters){ 
        $this->db->select('*');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = td.factura_estatus');
        //$this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura=ts.Template','left');
        //$this->db->join(self::tipos_documentos.' dt',' on dt.id_tipo_documento=ts.Documento','left');
        //$this->db->join(self::pos_sucursal.' s',' on ts.Sucursal=s.id_sucursal','left');
        //$this->db->join(self::pos_formas_pago.' p',' on p.id_modo_pago=ts.Pago','left');
        //$this->db->where('td.Empresa', $this->session->empresa[0]->id_empresa);
        //$this->db->order_by('s.nombre_sucursal','asc');
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->where('td.Empresa', $this->session->empresa[0]->id_empresa );
        $this->db->order_by('td.id_factura','desc');       
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
        $this->db->where('td.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getTemplateBySucursal( $template , $documento ){
        //$this->db->select('td.id_factura,td.factura_nombre,td.factura_descripcion , dt.nombre, s.nombre_sucursal,ts.id_temp_suc,ts.estado_suc_tem');
        $this->db->select('*');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura=ts.Template');
        $this->db->join(self::tipos_documentos.' dt',' on dt.id_tipo_documento=ts.Documento');
        $this->db->join(self::pos_sucursal.' s',' on ts.Sucursal=s.id_sucursal');
        $this->db->join(self::pos_formas_pago.' fp',' on fp.id_modo_pago=ts.Pago', 'left');
        $this->db->where('ts.Template', $template );
        $this->db->where('ts.Documento', $documento );
        
        $query = $this->db->get();  
        //echo $this->db->queries[0];       
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_sucursales(){
        $this->db->select('*');        
        $this->db->from(self::sucursal);
        $this->db->where('sucursal_estado = 1');
        $this->db->where('Empresa_Suc', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update_pago( $id_tabla , $id_pago ){
        
        $data = array('Pago' => $id_pago );

        $this->db->where('id_temp_suc' , $id_tabla );
        $this->db->delete(self::pos_temp_sucursal);
        //$this->db->update(self::pos_temp_sucursal, $data);
    }

    function eliminar( $id_template ){

        // Delete Template Sucursal
        $this->db->where('id_factura' , $id_template );
        $this->db->delete(self::pos_doc_temp);
        $data = $this->db->affected_rows();

        // Delete Template
        $this->db->where('id_factura' , $id_template );
        $this->db->delete(self::pos_doc_temp);
        $data = $this->db->affected_rows();

        $result = false;

        if($data){
            $result = true;
        }
        
        return  $result;
        
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

    function record_count($filter){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::pos_doc_temp);
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear_template($datos){

        $html = addslashes($datos['template_html']);
        
        $data = array(
            'factura_nombre'        =>  $datos['factura_nombre'],
            'factura_descripcion'   => $datos['factura_descripcion'],
            'factura_template'      => $datos['template_html'],
            'factura_lineas'        => $datos['factura_lineas'],
            'factura_estatus'       => $datos['factura_estatus'],
            'factura_creado'        => date("Y-m-d h:i:s"),
            'Empresa'               => $this->session->empresa[0]->id_empresa
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

        $html = addslashes($datos['template_html']);
        
        $data = array(
            'factura_nombre'        =>  $datos['factura_nombre'],
            'factura_descripcion'   => $datos['factura_descripcion'],
            'factura_template'      => $datos['template_html'],
            'factura_lineas'        => $datos['factura_lineas'],
            'factura_estatus'       => $datos['factura_estatus'],
            'factura_update'        => date("Y-m-d h:i:s")
        ); 

        $this->db->where('id_factura', $datos['id_factura'] );
        $this->db->update(self::pos_doc_temp, $data );
    }

    //Test Printer
    function printer( $orden , $sucursal_id , $documento_id , $pago){
        
        $this->db->select('td.*,ts.*,s.*,e.nombre_comercial,o.*,c.nombre_empresa_o_compania, d.nombre as documento_nombre');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura = ts.Template');
        $this->db->join(self::pos_sucursal.' as s',' on s.id_sucursal = ts.Sucursal');
        $this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->join(self::pos_orden.' as o',' on o.id_tipod = ts.Documento');
        $this->db->join(self::cliente.' as c',' on c.id_cliente = o.id_cliente');
        $this->db->join(self::pos_tipo_documento.' as d',' on d.id_tipo_documento = ts.Documento');
        
        $this->db->where('ts.Sucursal', $sucursal_id);
        $this->db->where('ts.Documento', $documento_id);
        //$this->db->where('ts.Pago', $pago);
        $this->db->where('ts.estado_suc_tem', 1);
        $this->db->limit(1);
        $query = $this->db->get();

        //echo $this->db->queries[11];
        //die;

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    //Test Printer Venta
    function printer_venta( $orden , $sucursal_id , $documento_id , $pago){
        
        $this->db->select('td.*,ts.*,s.*,e.nombre_comercial,o.*,c.nombre_empresa_o_compania, d.nombre as documento_nombre');
        $this->db->from(self::pos_doc_temp.' as td');
        $this->db->join(self::pos_temp_sucursal.' as ts',' on td.id_factura = ts.Template');
        $this->db->join(self::pos_sucursal.' as s',' on s.id_sucursal = ts.Sucursal');
        $this->db->join(self::pos_empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->join(self::pos_ventas.' as o',' on o.id_tipod = ts.Documento');
        $this->db->join(self::cliente.' as c',' on c.id_cliente = o.id_cliente');
        $this->db->join(self::pos_tipo_documento.' as d',' on d.id_tipo_documento = ts.Documento');
        
        $this->db->where('ts.Sucursal', $sucursal_id);
        $this->db->where('ts.Documento', $documento_id);
        $this->db->where('ts.estado_suc_tem', 1);
        $this->db->limit(1);
        $query = $this->db->get();

        //echo $this->db->queries[11];
        //die;

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getOrdencolumnsTables(){
        return $fields = $this->db->list_fields('pos_ordenes');
    }
    function getOrdenDetallecolumnsTables(){
        return $fields = $this->db->list_fields('pos_orden_detalle');
    }
    function getEmpresalumnsTables(){
        return $fields = $this->db->list_fields('pos_empresa');
    }
    function getCajaColumnsTables(){
        return $fields = $this->db->list_fields('pos_caja');
    }
    function getSucursalColumnsTables(){
        return $fields = $this->db->list_fields('pos_sucursal');
    }
    function getPagosColumnsTables(){
        return $fields = $this->db->list_fields('pos_formas_pago');
    }
    function getDocumentoColumnsTables(){
        return $fields = $this->db->list_fields('pos_tipo_documento');
    }
    function getCorrelativosColumnsTables(){
        return $fields = $this->db->list_fields('pos_correlativos');
    }
    function getClienteColumnsTables(){
        return $fields = $this->db->list_fields('pos_cliente');
    }
    function getUsuarioColumnsTables(){
        return $fields = $this->db->list_fields('sys_usuario');
    }
    
}