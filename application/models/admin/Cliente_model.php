<?php
class Cliente_model extends CI_Model {

	const cliente =  'pos_cliente';
    const formas_pago =  'pos_formas_pago';
    const tipos_documentos =  'pos_tipo_documento';
    const sys_persona =  'sys_persona';
    const pos_tipo_documento= 'pos_tipo_documento';
    const pos_formas_pago = 'pos_formas_pago';
    const pos_fp_cliente = 'pos_formas_pago_cliente';

	function get_cliente(){
		$this->db->select('id_cliente,nombre_empresa_o_compania,nrc_cli,nit_cliente,nombre_empresa_o_compania,direccion_cliente,aplica_impuestos,TipoDocumento');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos,' on '.self::cliente.'.TipoDocumento='.self::tipos_documentos.'.id_tipo_documento');
        $this->db->join(self::formas_pago,' on '.self::cliente.'.TipoPago='.self::formas_pago.'.id_modo_pago');
        $this->db->where(self::cliente.'.estado_cliente = 1');
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
        $this->db->where(self::cliente.'.estado_cliente = 1');

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

    function getCliente(){
        $this->db->select('*');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos,' on '.self::cliente.'.TipoDocumento='.self::tipos_documentos.'.id_tipo_documento');
        $this->db->join(self::formas_pago,' on '.self::cliente.'.TipoPago='.self::formas_pago.'.id_modo_pago');
        $this->db->join(self::sys_persona.' as p', ' on p.id_persona = Persona');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllClientes( $limit, $id){
        $this->db->select('*');
        $this->db->from(self::cliente);
        $this->db->join(self::tipos_documentos,' on '.self::cliente.'.TipoDocumento='.self::tipos_documentos.'.id_tipo_documento');
        $this->db->join(self::formas_pago,' on '.self::cliente.'.TipoPago='.self::formas_pago.'.id_modo_pago');
        $this->db->join(self::sys_persona.' as p', ' on p.id_persona = Persona');
        $this->db->where('p.Empresa', $this->session->empresa[0]->id_empresa);
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

    function record_count(){
        $this->db->where('p.Empresa',$this->session->empresa[0]->id_empresa);
        $this->db->from(self::cliente.' as c');
        $this->db->join(self::sys_persona.' as p',' on c.Persona = p.id_persona');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear_cliente($datos){

         // Insertando Imagenes empresa
        $imagen="";
        $imagen = file_get_contents($_FILES['logo_cli']['tmp_name']);
        $imageProperties = getimageSize($_FILES['logo_cli']['tmp_name']);

        $data = array(
            'website_cli'     =>  $datos['website_cli'],
            'nrc_cli'    => $datos['nrc_cli'],
            'nit_cliente'   => $datos['nit_cliente'],
            'clase_cli'  => $datos['clase_cli'],
            'mail_cli'  => $datos['mail_cli'],
            'logo_cli'                       => $imagen,
            'logo_type' => $imageProperties['mime'],
            'TipoPago'                       => $datos['TipoPago'],
            'TipoDocumento'=> $datos['TipoDocumento'],
            'nombre_empresa_o_compania'=> $datos['nombre_empresa_o_compania'],
            'numero_cuenta'                       => $datos['numero_cuenta'],
            'aplica_impuestos'                       => $datos['aplica_impuestos'],
            'direccion_cliente'                      => $datos['direccion_cliente'],
            'porcentage_descuentos'                  => $datos['porcentage_descuentos'],
            'estado_cliente'                      => $datos['estado'],
            'creado'                    => date("Y-m-d h:i:s"),
            'Persona'               => $datos['Persona'],
            'natural_juridica'            => $datos['natural_juridica']
        );
        
        $result = $this->db->insert(self::cliente, $data);  

        $this->crearFpCliente($this->db->insert_id(),  $datos );
        return $result;
    }

    function crearFpCliente( $clienteId, $formas_pago){
        
        foreach ($formas_pago as $key => $value) {
            
            $valor = (int)$key;
            
            if($valor !=0 ){
                $data = array(
                    'Cliente_form_pago' => $clienteId,
                    'Forma_pago' =>$valor,
                    'for_pag_emp_estado' => 1
                );
                $result = $this->db->insert(self::pos_fp_cliente, $data);  
            }
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
            'estado_cliente'                      => $datos['estado'],
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
        $result = $this->db->update(self::cliente, $data ); 
        return $result;
    }
}