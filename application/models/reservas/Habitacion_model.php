<?php
class Habitacion_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const habitacion = 'reserva_habitacion';

    function get_all_articulos( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::habitacion.' as habitacion' );
        $this->db->join( self::sucursal.' as s', ' on habitacion.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
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
        $this->db->where('habitacion.Sucursal', $this->session->usuario[0]->Sucursal. ' '. $filter);
        $this->db->from( self::habitacion.' as habitacion');
        $result = $this->db->count_all_results();
        return $result;
    }

    function crear($habitacion){

        $zona['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $insert = $this->db->insert(self::habitacion, $habitacion);
        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_habitacion($habitacion){
    	$this->db->select('*');
        $this->db->from( self::habitacion.' as habitacion');
        $this->db->join( self::sucursal.' as s', ' on habitacion.Sucursal = s.id_sucursal' );
        $this->db->where('habitacion.id_reserva_habitacion', $habitacion );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($habitacion){

    	$this->db->where('id_reserva_habitacion', $habitacion['id_reserva_habitacion']);  
        $result = $this->db->update(self::habitacion, $habitacion);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id)
    {
        $this->db->where('id_reserva_habitacion', $id);  
        $result = $this->db->delete(self::habitacion);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
