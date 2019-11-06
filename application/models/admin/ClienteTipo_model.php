<?php
class ClienteTipo_model extends CI_Model {

	const cliente =  'pos_cliente';
    const formas_pago =  'pos_formas_pago';
    const tipos_documentos =  'pos_tipo_documento';
    const sys_persona =  'sys_persona';
    const pos_tipo_documento= 'pos_tipo_documento';
    const pos_formas_pago = 'pos_formas_pago';
    const pos_fp_cliente = 'pos_formas_pago_cliente';
    const pos_cliente_tipo = 'pos_cliente_tipo';

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

    function get_clientes_tipo_id( $cliente_id ){

        $this->db->select('*');
        $this->db->from(self::pos_cliente_tipo);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        //$this->db->where('estado = 1');
        $this->db->where('id_cliente_tipo = '.$cliente_id);
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

    function getAllClientesTipo( $limit, $id){
        $this->db->select('*');
        $this->db->from(self::pos_cliente_tipo);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
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

    function crear_clienteTipo($datos){
        
        $datos['Empresa'] = $this->session->empresa[0]->id_empresa;
        $result = $this->db->insert(self::pos_cliente_tipo, $datos);

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

        $this->db->where('id_cliente_tipo', $datos['id_cliente_tipo'] ); 
        $result = $this->db->update(self::pos_cliente_tipo, $datos ); 
        return $result;
    }
}