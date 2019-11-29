<?php
class Documento_model extends CI_Model {

    const documento = 'pos_tipo_documento';


    function getDocumento($limit, $id , $filters){

        $this->db->select('*');
        $this->db->from(self::documento);  
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

    function getAllDocumento(){

        $this->db->select('*');
        $this->db->from(self::documento);   
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);      
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
            'nombre' => $documento['nombre'],
            'efecto_inventario' => $documento['efecto_inventario'],
            'efecto_en_iva' => $documento['efecto_en_iva'],
            'efecto_en_cuentas' => $documento['efecto_en_cuentas'],
            'efecto_en_caja' => $documento['efecto_en_caja'],
            'efecto_en_report_venta' => $documento['efecto_en_report_venta'],
            'automatico' => $documento['automatico'],
            'emitir_a' => $documento['emitir_a'],            
            'estado' => $documento['estado'],
        );
        $this->db->where('id_tipo_documento', $documento['id_tipo_documento']);
        $result = $this->db->update(self::documento, $data);  
        return $result;
    }

    function nuevo_documento( $documento ){

        $data = array(
            'nombre' => $documento['nombre'],
            'efecto_inventario' => $documento['efecto_inventario'],
            'efecto_en_iva' => $documento['efecto_en_iva'],
            'efecto_en_cuentas' => $documento['efecto_en_cuentas'],
            'efecto_en_caja' => $documento['efecto_en_caja'],
            'efecto_en_report_venta' => $documento['efecto_en_report_venta'],
            'automatico' => $documento['automatico'],
            'emitir_a' => $documento['emitir_a'],            
            'Empresa'=> $this->session->empresa[0]->id_empresa,
            'estado' => $documento['estado'],
        );

        $result = $this->db->insert(self::documento, $data );
        return $result;
    }

    function delete_documento( $role_id ){
        
        $data = array(
            'id_tipo_documento' => $role_id
        );

        $result = $this->db->delete(self::documento, $data);

        return $result;
    }
}

?>