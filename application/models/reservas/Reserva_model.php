<?php
class Reserva_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const mesa = 'reserva_mesa';
    const reserva = 'reserva';
    const reserva_habitacion = 'reserva_habitacion';
    const reserva_detalle_habitacion = 'reserva_detalle_habitacion';

    function get_all_reservas( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
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
        $this->db->from( self::mesa.' as habitacion');
        $result = $this->db->count_all_results();
        return $result;
    }

    public function get_reservas_activas($estado)
    {
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::reserva_detalle_habitacion.' as reserva_habitacion', ' on reserva_habitacion.reserva = reserva.id_reserva','left');
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where('reserva.estado_reserva', $estado);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_habitacion_reserva($estado)
    {
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::reserva_detalle_habitacion.' as reserva_habitacion', ' on reserva_habitacion.reserva = reserva.id_reserva' );
        $this->db->join( self::reserva_habitacion.' as habitacion', ' on habitacion.id_reserva_habitacion = reserva_habitacion.habitacion' );
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where_in('reserva.estado_reserva', $estado);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_habitacion($estado){
        $this->db->select('*');
        $this->db->from( self::reserva_habitacion.' as habitacion');
        $this->db->join( self::sucursal.' as s', ' on habitacion.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where_in('habitacion.estado_habitacion', $estado);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_reservaciones_calendar_data()
    {
        $this->db->select('nombre_reserva as title,fecha_entrada_reserva as start,fecha_salida_reserva as end');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
       
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_reservacion_habiatacion($data)
    {
        $this->db->select('nombre_reserva, codigo_habitacion, ');
        $this->db->from(self::reserva.' as reserva');  
        $this->db->join(self::reserva_detalle_habitacion.' as rdh',' vd ON rdh.reserva = reserva.id_reserva');
        $this->db->join(self::reserva_habitacion.' as rh','rh.id_reserva_habitacion = rdh.habitacion', 'RIGHT');  
        
        $this->db->where('DATE(fecha_entrada_reserva)  >= ' , $data['start'] );
        $this->db->where('DATE(fecha_entrada_reserva) <=' , $data['start'] );
        $this->db->where('id_reserva_habitacion' , $data['habitacion'] );

        $query = $this->db->get();
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function crear($mesa){

        $mesa['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $numero_mesa = (int) $mesa['numero_mesa'];
        $incrementar = (int) $mesa['incrementar'];
        $cc = 1;
        $incremento_mesa = $mesa['codigo_mesa'];
        unset($mesa['numero_mesa']);
        unset($mesa['incrementar']);

        for($cc = 1; $cc <= $numero_mesa; $cc++) {
            if ($incrementar == 1) {
                $mesa['codigo_mesa'] = $incremento_mesa;
            }
            $insert = $this->db->insert(self::mesa, $mesa);
            $incremento_mesa++;
        }

        if(!$insert){
            $insert = $this->db->error();
        }

        return $insert;
    }

    function get_mesa($mesa){
    	$this->db->select('*');
        $this->db->from( self::mesa.' as mesa');
        $this->db->join( self::sucursal.' as s', ' on mesa.Sucursal = s.id_sucursal' );
        $this->db->where('mesa.id_reserva_mesa', $mesa );
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($habitacion){

    	$this->db->where('id_reserva_mesa', $habitacion['id_reserva_mesa']);  
        $result = $this->db->update(self::mesa, $habitacion);  
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    function eliminar($id)
    {
        $this->db->where('id_reserva_mesa', $id);  
        $result = $this->db->delete(self::mesa);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }
}
