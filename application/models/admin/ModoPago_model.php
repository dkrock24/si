<?php
class ModoPago_model extends CI_Model {

	const formas_pago =  'pos_formas_pago';
    const pos_formas_pago_cliente =  'pos_formas_pago_cliente';
    const pos_cliente = 'pos_cliente';
    const sys_persona = 'sys_persona';
    const pos_tem_suc = 'pos_temp_sucursal';

    function getAllFormasPago(){
        $this->db->select('*');
        $this->db->from(self::formas_pago);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

	function get_formas_pago(){
		$this->db->select('*');
        $this->db->from(self::formas_pago .' as  fp');
        $this->db->join(self::pos_formas_pago_cliente.' as fpc',' on fp.id_modo_pago = fpc.Forma_pago');
        $this->db->join(self::pos_cliente.' as c', ' on c.id_cliente = fpc.Cliente_form_pago');
        $this->db->join(self::sys_persona.' as p', ' on p.id_persona = c.Persona');
        //$this->db->join(self::pos_tem_suc .' as ts', ' on ts.Pago = fp.id_modo_pago');
        $this->db->where('p.Empresa = '.$this->session->empresa[0]->id_empresa);
        $this->db->where('fp.estado_modo_pago = 1');
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}

    function get_pagos_by_cliente($id_cliente){

        $this->db->select('*');
        $this->db->from(self::formas_pago .' as  fp');
        $this->db->join(self::pos_formas_pago_cliente.' as fpc',' on fp.id_modo_pago = fpc.Forma_pago');
        $this->db->where('fpc.Cliente_form_pago = '.$id_cliente);
        $this->db->where('fp.estado_modo_pago = 1');
        $this->db->where('fpc.for_pag_emp_estado = 1');
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_pagos_by_doc( $tipo_documento ){

        $this->db->select('*');
        $this->db->from(self::formas_pago .' as  fp');
        $this->db->join(self::pos_formas_pago_cliente.' as fpc',' on fp.id_modo_pago = fpc.Forma_pago');
        $this->db->join(self::pos_tem_suc .' as ts', ' on ts.Pago = fp.id_modo_pago');

        $this->db->where('ts.id_temp_suc = '. $tipo_documento );
        $this->db->where('fp.estado_modo_pago = 1');
        $this->db->where('fpc.for_pag_emp_estado = 1');
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}