<?php
class Integrador_model extends CI_Model {
    
    const integrador =  'sys_integrador';
    const pos_orden_estado = 'pos_orden_estado';

    function getIntegrador(  $limit, $id , $filters){
    	$this->db->select('*');
        $this->db->from(self::integrador);
        $this->db->join(self::pos_orden_estado.' as es', 'on es.id_orden_estado = sys_integrador.estado_integrador');
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllMoneda(){
        $this->db->select('*');
        $this->db->from(self::integrador);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }


    function record_count(){
        return $this->db->count_all(self::integrador);
    }

    function save($integrador){

        $result = $this->db->insert(self::integrador, $integrador ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function getIntegradorId( $integrador ){
        $this->db->select('*');
        $this->db->from(self::integrador);
        $this->db->where('id_integrador', $integrador );
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($integrador){

        
        $this->db->where('id_integrador', $integrador['id_integrador'] );
        $result =  $this->db->update(self::integrador, $integrador ); 

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar( $id ){
        
        $data = array(
            'id_integrador' => $id
        );

        $this->db->where('id_integrador', $id);
        $result =  $this->db->delete(self::integrador, $data );

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

}
