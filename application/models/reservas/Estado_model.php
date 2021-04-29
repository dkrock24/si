<?php
class Estado_model extends CI_Model {

    const empresa = "pos_empresa";
    const estados = 'reserva_estados';

    function get_all_estados( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::estados.' as estado' );
        $this->db->join( self::empresa.' as e', ' on estado.empresa = e.id_empresa' );
        $this->db->where('estado.empresa', $this->session->empresa[0]->id_empresa);
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

    function record_count($filter){
        $this->db->where('empresa', $this->session->empresa[0]->id_empresa. ' '. $filter);
        $this->db->from( self::estados.' as estado');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear($estado){

        $estado['empresa'] = $this->session->empresa[0]->id_empresa;
        $insert = $this->db->insert(self::estados, $estado);  
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_estado($estado){
    	$this->db->select('*');
        $this->db->from( self::estados.' as estado');
        $this->db->join( self::empresa.' as e', ' on estado.empresa = e.id_empresa' );
        $this->db->where('estado.id_reserva_estados', $estado );
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_estado_lista(){
    	$this->db->select('*');
        $this->db->from( self::estados.' as estado');
        $this->db->join( self::empresa.' as e', ' on estado.empresa = e.id_empresa' );
        $this->db->where('e.id_empresa', $this->session->empresa[0]->id_empresa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($estado){

    	$this->db->where('id_reserva_estados', $estado['id_reserva_estados']);  
        $result = $this->db->update(self::estados, $estado);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id)
    {
        $this->db->where('id_reserva_estados', $id);  
        $result = $this->db->delete(self::estados);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}