<?php
class Documento_model extends CI_Model {

    const documento         = 'pos_tipo_documento';
    const pos_sucursal      = 'pos_sucursal';
    const pos_temp_sucursal = 'pos_temp_sucursal';
    const pos_orden_estado  = 'pos_orden_estado';

    function getDocumento($limit, $id , $filters){
        $this->db->select('*');
        $this->db->from(self::documento);  
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = pos_tipo_documento.estado');
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
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

    function getDocTemplate(){
        $this->db->select('*');
        $this->db->from(self::documento.' as d');   
        $this->db->join(self::pos_temp_sucursal.' as t',' on d.id_tipo_documento = t.Documento');   
        $this->db->join(self::pos_sucursal.' as s',' on s.id_sucursal = t.Sucursal');
        $this->db->where('d.Empresa', $this->session->empresa[0]->id_empresa);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function getAllDocumento($documentoNombre = null){
        $this->db->select('*');
        $this->db->from(self::documento);   
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa); 
        $this->db->order_by('nombre','asc');
        if($documentoNombre){
            $this->db->where('nombre', $documentoNombre); 
        }     
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count($filter){
        $this->db->where('Empresa',$this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from(self::documento);
        $result = $this->db->count_all_results();
        return $result;
    }

    function getDocumentoById( $documento_id ){
        $this->db->select('*');
        $this->db->from(self::documento);   
        $this->db->where('id_tipo_documento', $documento_id ); 
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function setDocumento( $documento ){

        $data = array(
            'estado' => $documento['estado'],
            'nombre' => $documento['nombre'],
            'emitir_a' => $documento['emitir_a'],            
            'automatico' => $documento['automatico'],
            'efecto_en_iva' => $documento['efecto_en_iva'],
            'efecto_en_caja' => $documento['efecto_en_caja'],
            'efecto_en_cuentas' => $documento['efecto_en_cuentas'],
            'efecto_inventario' => $documento['efecto_inventario'],
            'efecto_en_report_venta' => $documento['efecto_en_report_venta'],
        );
        $this->db->where('id_tipo_documento', $documento['id_tipo_documento']);
        $result = $this->db->update(self::documento, $data);

        if(!$result){
            $result = $this->db->error();
        }
        return $result;
    }

    function nuevo_documento( $documento ){

        $regitros = $this->getAllDocumento($documento['nombre']);

        if(!$regitros){

            $data = array(
                'nombre' => $documento['nombre'],
                'estado' => $documento['estado'],
                'Empresa'=> $this->session->empresa[0]->id_empresa,
                'emitir_a' => $documento['emitir_a'],            
                'automatico' => $documento['automatico'],
                'efecto_en_iva' => $documento['efecto_en_iva'],
                'efecto_en_caja' => $documento['efecto_en_caja'],
                'efecto_inventario' => $documento['efecto_inventario'],
                'efecto_en_cuentas' => $documento['efecto_en_cuentas'],
                'efecto_en_report_venta' => $documento['efecto_en_report_venta'],
            );

            $result = $this->db->insert(self::documento, $data );
            if(!$result){
                $result = $this->db->error();
            }
            return $result;
        }else{
            return $result = [
                'code' => 1,
                'message' => "El registro ya existe"
            ];
        }
    }

    function delete_documento( $documento_id ){
        
        $data = array(
            'id_tipo_documento' => $documento_id
        );

        $result = $this->db->delete(self::documento, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}