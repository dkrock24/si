<?php
class Integrador_model extends CI_Model {
    
    const integrador =  'sys_integrador';
    const integrador2 =  'sys_integrador2';
    const pos_orden_estado = 'pos_orden_estado';
    const sys_integrador_config = 'sys_integrador_config';

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

    function get_all_integracion(){
        $this->db->select('*');
        $this->db->from(self::integrador);
        $this->db->where('estado_integrador',1);
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

    function integrador_config(){

        $this->db->select('*');
        $this->db->from(self::sys_integrador_config);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function config_by_name($config){

        $this->db->select('valor_config');
        $this->db->from(self::sys_integrador_config);
        $this->db->where('nombre_config',$config);
        $query = $this->db->get();
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function insert_api($integracion_data)
    {
        $this->db->truncate(self::integrador2);

        $data = [];
        foreach ($integracion_data as $key => $integrador) {
            $data[] = $integrador;
        }
        $this->db->insert_batch(self::integrador2, $data);

        if($this->db->error()){
            return $this->db->error();
        }
    }
}
