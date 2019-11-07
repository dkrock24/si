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

	function get_cliente_tipo(){
        $this->db->select('*');
        $this->db->from(self::pos_cliente_tipo);
        $this->db->where(self::pos_cliente_tipo.'.estado_cliente_tipo = 1');
        $this->db->where(self::pos_cliente_tipo.'.nombre_cliente_tipo !=""');
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

    function update($datos){

        $this->db->where('id_cliente_tipo', $datos['id_cliente_tipo'] ); 
        $result = $this->db->update(self::pos_cliente_tipo, $datos ); 
        return $result;
    }
}