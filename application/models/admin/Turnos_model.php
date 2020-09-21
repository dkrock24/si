<?php
class Turnos_model extends CI_Model {

    const turno      = 'pos_turnos';
    const pos_orden_estado =  'pos_orden_estado';

    public function getTurno($limit, $id, $filters ){

        $this->db->select('*');
        $this->db->from(self::turno.' as t');
        $this->db->join(self::pos_orden_estado.' as es',' on es.id_orden_estado = t.estado_turno','full');
        $this->db->where('t.Empresa', $this->session->empresa[0]->id_empresa);
        
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
    
    public function getTurnos(){

        $this->db->select('*');
        $this->db->from(self::turno);  
        $this->db->where(self::turno.'.Empresa', $this->session->empresa[0]->id_empresa);  
       
        $query = $this->db->get();
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        } 
    }

    public function record_count($filter){
        
        if($filter){
            $this->db->where($filter);
        }

        $this->db->from(self::turno);
        $result = $this->db->count_all_results();
        return $result;
    }

    public function save($turno){
        $turno['Empresa'] = $this->session->empresa[0]->id_empresa;
        $result = $this->db->insert(self::turno , $turno);
        return $result;
    }

    public function getTurnoId($turno){
        $this->db->select('*');
        $this->db->from(self::turno);  
        $this->db->where('id_turno', $turno);
        $this->db->where(self::turno.'.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function update($turnos){
        
        $this->db->where('id_turno' , $turnos['id_turno'] );
        $this->db->where(self::turno.'.Empresa', $this->session->empresa[0]->id_empresa);
        $result = $this->db->update(self::turno , $turnos);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    public function eliminar($turno){
        $data = array(
            'id_turno' => $turno,
            'Empresa'  => $this->session->empresa[0]->id_empresa
        );
        $result = $this->db->delete(self::turno, $data);

        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}