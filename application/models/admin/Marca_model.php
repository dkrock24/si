<?php
class Marca_model extends CI_Model {

    const marca = 'pos_marca';


    function getMarca($limit, $id){

        $this->db->select('*');
        $this->db->from(self::marca);  
        $this->db->where('Empresa', $this->session->empresa[0]->Empresa_Suc);
        $this->db->limit($limit, $id);          
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function getAllMarca(){

        $this->db->select('*');
        $this->db->from(self::marca);   
        $this->db->where('Empresa', $this->session->empresa[0]->Empresa_Suc);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function record_count(){
        return $this->db->count_all(self::marca);
    }

    function getMarcaById( $marca_id ){

        $this->db->select('*');
        $this->db->from(self::marca);   
        $this->db->where('id_marca', $marca_id ); 
        $this->db->where('Empresa', $this->session->empresa[0]->Empresa_Suc);      
        $query = $this->db->get();    
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    function setMarca( $marca ){

        $data = array(
            'nombre_marca' => $marca['nombre_marca'],
            'descripcion_marca' => $marca['descripcion_marca'],
            'fecha_atualizado_marca' => date("Y-m-d h:i:s"),          
            'estado_marca' => $marca['estado_marca'],
        );
        $this->db->where('id_marca', $marca['id_marca']);
        $this->db->update(self::marca, $data);  
    }

    function nuevo_marca( $marca ){

        $data = array(
            'nombre_marca' => $marca['nombre_marca'],
            'descripcion_marca' => $marca['descripcion_marca'],
            'fecha_creado_marca' => date("Y-m-d h:i:s"),          
            'Empresa'=> $this->session->empresa[0]->Empresa_Suc,
            'estado_marca' => $marca['estado'],
        );

        $this->db->insert(self::marca, $data );
    }

    function delete_marca( $role_id ){

        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete('sys_menu_acceso', $data);
        
        $data = array(
            'id_rol' => $role_id
        );
        $this->db->delete(self::marca, $data);

        return 1;
    }
}

?>