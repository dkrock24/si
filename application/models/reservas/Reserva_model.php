<?php
class Reserva_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const mesa = 'reserva_mesa';
    const reserva = 'reserva';
    const cliente = 'pos_cliente';
    const reserva_habitacion = 'reserva_habitacion';
    const reserva_detalle_habitacion = 'reserva_detalle_habitacion';
    const reserva_detalle_mesa = 'reserva_detalle_mesa';
    const reserva_detalle_zona = 'reserva_detalle_zona';    

    function get_all_reservas( $limit, $id ,$filters){;
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::estados.' as estados', ' on reserva.estado_reserva = estados.id_reserva_estados' );
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->join( self::cliente.' as cliente', ' on reserva.cliente_reserva = cliente.id_cliente' );
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
        $this->db->select('nombre_reserva as title,fecha_entrada_reserva as start,fecha_salida_reserva as end,color');
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
        $fechaInicio = $_POST['start'];
        $fechaInicio = explode("T", $fechaInicio);

        $fechaFin = $_POST['end'];
        $fechaFin = explode("T", $fechaFin);

        $this->db->select('nombre_reserva, codigo_habitacion, ');
        $this->db->from(self::reserva.' as reserva');  
        $this->db->join(self::reserva_detalle_habitacion.' as rdh',' vd ON rdh.reserva = reserva.id_reserva');
        $this->db->join(self::reserva_habitacion.' as rh','rh.id_reserva_habitacion = rdh.habitacion', 'RIGHT');  
        
        $this->db->where('fecha_entrada_reserva  >= ' , $fechaInicio[0].' '.$fechaInicio[1] );
        $this->db->where('fecha_salida_reserva <=' , $fechaFin[0].' '.$fechaFin[1] );
        $this->db->where('id_reserva_habitacion' , $data['habitacion'] );

        $query = $this->db->get();
        //echo $this->db->queries[4];
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function crear($reserva){
        $reserva_datos = $reserva;

        $cc = 0;
        $reserva_mesa = [];
        $reserva_zona = [];
        $reserva_habitacion = array();

        foreach ($reserva as $key => $habitacion) {

            if (isset($reserva['habitacion-'.$cc])) {
                $reserva_habitacion[] = $reserva['habitacion-'.$cc];
                unset($reserva['habitacion-'.$cc]);
            }

            if (isset($reserva['mesa-'.$cc])) {
                $reserva_mesa[] = $reserva['mesa-'.$cc];
                unset($reserva['mesa-'.$cc]);
            }

            if (isset($reserva['zona-'.$cc])) {
                $reserva_zona[] = $reserva['zona-'.$cc];
                unset($reserva['zona-'.$cc]);
            }

            $cc++;
        }

        $fechaInicio = $reserva['fecha_entrada_reserva'];
        $fechaInicio = explode("T", $fechaInicio);

        $fechaFin = $reserva['fecha_salida_reserva'];
        $fechaFin = explode("T", $fechaFin);

        $today = date("Ymd");
        $rand = sprintf("%02d", rand(0,99));
        $unique = $today .'-'. $rand;

        $reserva['fecha_entrada_reserva'] = $fechaInicio[0].' '.$fechaInicio[1].':00';
        $reserva['fecha_salida_reserva'] = $fechaInicio[0].' '.$fechaInicio[1].':00';
        $reserva['fecha_creada_reserva'] = date('Y-m-d H:i:s');

        /** Insertar Reserva */        
        $reserva['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $reserva['codigo_reserva'] =$unique;

        $insert     = $this->db->insert(self::reserva, $reserva);
        $id_reserva = $this->db->insert_id();

        if(!$insert){
            $insert = $this->db->error();
        }

        /** Insertar Detalle habitacion */
        if($reserva_habitacion){
            foreach ($reserva_habitacion as $key => $habitacion) {
                
                $detalle = array('reserva'=> $id_reserva, 'habitacion'=> $habitacion);
                $this->db->insert(self::reserva_detalle_habitacion, $detalle);
            }
        }

        /** Insertar Detalle mesas */
        if($reserva_mesa){
            foreach ($reserva_mesa as $key => $mesa) {
                
                $detalle = array('reserva'=> $id_reserva, 'mesa'=> $mesa);
                $this->db->insert(self::reserva_detalle_mesa, $detalle);
            }
        }

        /** Insertar Detalle Zona */
        if($reserva_zona){
            foreach ($reserva_zona as $key => $zona) {
                
                $detalle = array('reserva'=> $id_reserva, 'zona'=> $zona);
                $this->db->insert(self::reserva_detalle_zona, $detalle);
            }
        }

        return $insert;
    }

    function get_reserva($reserva){
    	$this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::estados.' as estados', ' on reserva.estado_reserva = estados.id_reserva_estados' );
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->join( self::cliente.' as cliente', ' on reserva.cliente_reserva = cliente.id_cliente' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where('reserva.id_reserva', $reserva);
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
