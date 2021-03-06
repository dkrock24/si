<?php
class Caja_model extends CI_Model {

	const pos_terminal = 'pos_terminal';
    const sucursal = "pos_sucursal";
    const caja = "pos_caja";
    const caja2 = "pos_caja2";
    const empresa = "pos_empresa";
    const pos_terminal_cajero = 'pos_terminal_cajero';
    const documento = 'pos_tipo_documento';
    const doc_sucursal = 'pos_temp_sucursal';
    const doc_template = 'pos_doc_temp';
    const pos_orden_estado = 'pos_orden_estado';

    function get_all_caja( $limit, $id ,$filters){;
        $this->db->select('c.*,s.*,d.*,es.*,dt.factura_nombre');
        $this->db->from( self::caja.' as c' );
        $this->db->join( self::empresa.' as e', ' on c.Empresa=e.id_empresa' );
        $this->db->join( self::sucursal .' as s', ' on s.id_sucursal = c.pred_cod_sucu' );
        $this->db->join( self::doc_sucursal .' as ds', ' on ds.id_temp_suc = c.pred_id_tpdoc' );
        $this->db->join( self::documento .' as d', ' on d.id_tipo_documento = ds.Documento' );
        $this->db->join( self::doc_template .' as dt', ' on dt.id_factura = ds.Template ' );
        $this->db->join( self::pos_orden_estado .' as es', ' on es.id_orden_estado = c.estado_caja ' );
        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa);
        $this->db->order_by('s.nombre_sucursal',' asc');
        $this->db->order_by('c.id_caja',' asc');
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function crear_caja($caja){

        $insert = $this->db->insert(self::caja, $caja);  
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_caja($caja_id){
    	$this->db->select('*');
        $this->db->from( self::caja.' as c');
        $this->db->join( self::empresa.' as e',
                                    ' on c.Empresa=e.id_empresa' );
        $this->db->where('c.id_caja', $caja_id );
        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_caja_empresa(){
        $this->db->select('*');
        $this->db->from( self::caja.' as c');
        $this->db->join( self::empresa.' as e',' on c.Empresa=e.id_empresa' );
        $this->db->where('c.Empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_caja_sucursal($sucursal_id){
        $this->db->select('*');
        $this->db->from( self::caja);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa );
        $this->db->where('Sucursal', $sucursal_id );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getCajaSucursal($sucursal){
        $this->db->select('*');
        $this->db->from( self::caja.' as c');
        $this->db->join( self::pos_terminal.' as t',' on t.Caja = c.id_caja' );
        $this->db->where('t.Sucursal', $sucursal );
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update_caja($caja){

    	$this->db->where('id_caja', $caja['id_caja']);  
        $result = $this->db->update(self::caja, $caja);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id)
    {
        $this->db->where('id_caja', $id);  
        $result = $this->db->delete(self::caja);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }


	function record_count($filter){
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from( self::caja.' as terminal');
        $result = $this->db->count_all_results();
        return $result;
    }

    function insert_api($cajas)
    {
        $this->db->truncate(self::caja2);

        $data = [];
        foreach ($cajas as $key => $cajas) {
            $data[] = $cajas;
        }
        $this->db->insert_batch(self::caja2, $data);
    }

}