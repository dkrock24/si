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
        $this->db->from(self::pos_doc_temp);
        //$this->db->join(self::tipos_documentos,' on '.self::pos_doc_temp.'.factura_tipo_documento='.self::tipos_documentos.'.id_tipo_documento');
        //$this->db->join(self::pos_sucursal,' on '.self::pos_sucursal.'.id_sucursal='.self::pos_doc_temp.'.factura_sucursal');
        
        //$this->db->where(self::pos_sucursal.'.Empresa_Suc', $this->session->empresa[0]->Empresa_Suc);
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getTipoDocumento(){
        $this->db->select('*');
        $this->db->from(self::pos_tipo_documento);
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
            'factura_tipo_documento'=> $datos['factura_tipo_documento'],
            'factura_cliente'       => $datos['factura_cliente'],
            'factura_sucursal'      => $datos['factura_sucursal'],
            'factura_template'      => $datos['template_html'],
            'factura_lineas'        => $datos['factura_lineas'],
            'factura_estatus'       => $datos['factura_estatus']
        );
        
        $this->db->insert(self::pos_doc_temp, $data);  
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
}