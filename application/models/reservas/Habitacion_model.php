<?php
class Habitacion_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const habitacion = 'reserva_habitacion';
    const habitacion_articulo = 'reserva_habitacion_articulo';

    function get_all_articulos( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::habitacion.' as habitacion' );
        $this->db->join( self::sucursal.' as s', ' on habitacion.Sucursal = s.id_sucursal' );
        $this->db->join( self::estados.' as estados', ' on habitacion.estado_habitacion = estados.id_reserva_estados' );
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

        $cc = 0;
        $reserva_habitacion_articulo = [];
        foreach ($habitacion as $key => $habitaciones) {

            if (isset($habitacion['articulo-'.$cc])) {
                $reserva_habitacion_articulo[$cc]['articulo'] = $habitacion['articulo-'.$cc];
                $reserva_habitacion_articulo[$cc]['cantidad'] = $habitacion['cantidad-'.$cc];
                unset($habitacion['articulo-'.$cc]);
            }
            if (isset($habitacion['cantidad-'.$cc])) {
                unset($habitacion['cantidad-'.$cc]);
            }

            $cc++;
        }
        $habitacion['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $insert = $this->db->insert(self::habitacion, $habitacion);
        $habitacion_id = $this->db->insert_id();

        if(!$insert){
            $insert = $this->db->error();
        }
        
        if($habitacion_id && $reserva_habitacion_articulo){
            
            $this->crear_reserva_habitacion_articulo($habitacion_id,$reserva_habitacion_articulo);
        }

        return $insert;
    }

    private function crear_reserva_habitacion_articulo($habitacion_id, $reserva_habitacion_articulo)
    {
        foreach ($reserva_habitacion_articulo as $key => $habitacion_articulo) {
            $habitacion_articulo['habitacion'] = $habitacion_id;

            $this->db->insert(self::habitacion_articulo, $habitacion_articulo);
        }
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

    public function get_habitacion_articulos($habitacion)
    {
        $this->db->select('*');
        $this->db->from( self::habitacion.' as habitacion');
        $this->db->join( self::habitacion_articulo.' as ha', ' on habitacion.id_reserva_habitacion = ha.habitacion' );
        $this->db->join( self::sucursal.' as s', ' on habitacion.Sucursal = s.id_sucursal' );
        $this->db->where('habitacion.id_reserva_habitacion', $habitacion );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($habitacion){

        $cc = 0;
        $reserva_habitacion_articulo = [];
        foreach ($habitacion as $key => $habitaciones) {

            if (isset($habitacion['articulo-'.$cc])) {
                $reserva_habitacion_articulo[$cc]['articulo'] = $habitacion['articulo-'.$cc];
                $reserva_habitacion_articulo[$cc]['cantidad'] = $habitacion['cantidad-'.$cc];
                unset($habitacion['articulo-'.$cc]);
            }
            if (isset($habitacion['cantidad-'.$cc])) {
                unset($habitacion['cantidad-'.$cc]);
            }

            $cc++;
        }

    	$this->db->where('id_reserva_habitacion', $habitacion['id_reserva_habitacion']);  
        $result = $this->db->update(self::habitacion, $habitacion);  

        if(!$result){
            $result = $this->db->error();
        }

        if($reserva_habitacion_articulo){
            $this->db->where('habitacion', $habitacion['id_reserva_habitacion']);  
            $this->db->delete(self::habitacion_articulo);
            $this->crear_reserva_habitacion_articulo($habitacion['id_reserva_habitacion'], $reserva_habitacion_articulo);
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
