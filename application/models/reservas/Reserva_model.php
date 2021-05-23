<?php
class Reserva_model extends CI_Model {

    const empresa = "pos_empresa";
    const sucursal = "pos_sucursal";
    const estados = 'reserva_estados';
    const mesa = 'reserva_mesa';
    const zona = 'reserva_zona';
    const reserva = 'reserva';
    const cliente = 'pos_cliente';
    const reserva_habitacion = 'reserva_habitacion';
    const reserva_paquete = 'reserva_paquete_reserva';
    const reserva_detalle_habitacion = 'reserva_detalle_habitacion';
    const reserva_detalle_mesa = 'reserva_detalle_mesa';
    const reserva_detalle_zona = 'reserva_detalle_zona';
    const reserva_detalle_articulos = 'reserva_detalle_articulos';
    const pagos = 'pos_formas_pago';
    const paquetes = 'reserva_paquete';

    function get_all_reservas( $limit, $id ,$filters){;
        $this->db->select('*,(SELECT GROUP_CONCAT(zona.nombre_zona SEPARATOR ",")
            FROM reserva_zona  AS zona
            LEFT JOIN reserva_detalle_zona AS rdz ON zona.id_reserva_zona = rdz.zona
            WHERE rdz.reserva = reserva.id_reserva) AS eventos');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::estados.' as estados', ' on reserva.estado_reserva = estados.id_reserva_estados' );
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->join( self::cliente.' as cliente', ' on reserva.cliente_reserva = cliente.id_cliente' );
        $this->db->join( self::pagos.' as pagos', ' on reserva.tipo_pago_reserva = pagos.id_modo_pago' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->order_by('reserva.estado_reserva','desc');
        $this->db->order_by('reserva.fecha_creada_reserva','desc');
        $this->db->order_by('reserva.fecha_entrada_reserva','desc');
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get(); 
        //echo $this->db->queries[6];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function record_count($filter){
        $this->db->where('reserva.Sucursal', $this->session->usuario[0]->Sucursal. ' '. $filter);
        $this->db->from( self::reserva.' as reserva');
        $result = $this->db->count_all_results();
        return $result;
    }

    public function get_reservas_activas($estado)
    {
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        //$this->db->join( self::reserva_detalle_habitacion.' as reserva_habitacion', ' on reserva_habitacion.reserva = reserva.id_reserva','left');
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
        $reserva_paquete = [];

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

            if (isset($reserva['paquete-'.$cc])) {
                $reserva_paquete[$cc]['paquete'] = $reserva['paquete-'.$cc];
                $reserva_paquete[$cc]['cantidad'] = $reserva['cantidad-'.$cc];
                unset($reserva['paquete-'.$cc]);
            }
            unset($reserva['cantidad-'.$cc]);

            $cc++;
        }

        $fechaInicio = $reserva['fecha_entrada_reserva'];
        $horaInicio = $reserva['hora_entrada_reserva'];
        $fechaFin = $reserva['fecha_salida_reserva'];
        $horaFin  = $reserva['hora_salida_reserva'];

        unset($reserva['hora_entrada_reserva']);
        unset($reserva['hora_salida_reserva']);

        $today  = date("Ymd");
        $rand   = sprintf("%02d", rand(0,99));
        $unique = $today .'-'. $rand;

        $reserva['total_personas_reserva'] = $reserva['total_adultos_reserva'] + $reserva['total_ninos_reserva'];
        $reserva['fecha_entrada_reserva']  = $fechaInicio.' '.$horaInicio.':00';
        $reserva['fecha_salida_reserva']   = $fechaFin.' '.$horaFin.':00';
        $reserva['fecha_creada_reserva']   = date('Y-m-d H:i:s');

        /** Insertar Reserva */        
        $reserva['Sucursal'] = $this->session->usuario[0]->Sucursal;
        $reserva['codigo_reserva'] =$unique;

        $insertx     = $this->db->insert(self::reserva, $reserva);
        $id_reserva = $this->db->insert_id();

        if(!$insertx){
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
        
        /** Insertar Paquete */
        if($reserva_paquete){
            foreach ($reserva_paquete as $key => $paquete) {
                $detalle = array('reserva' => $id_reserva, 'paquete'=> $paquete['paquete'], 'cantidad'=> $paquete['cantidad']);
                $this->db->insert(self::reserva_paquete, $detalle);
            }
        }

        return $insertx;
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

    public function get_habitacion_($reserva){
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join(self::reserva_detalle_habitacion.' as rdh',' on rdh.reserva = reserva.id_reserva');
        $this->db->join( self::reserva_habitacion.' as habitacion',' on habitacion.id_reserva_habitacion = rdh.habitacion');
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where('reserva.id_reserva', $reserva);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_mesa_($reserva){
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join(self::reserva_detalle_mesa.' as rdm',' ON rdm.reserva = reserva.id_reserva');
        $this->db->join( self::mesa.' as mesa',' on mesa.id_reserva_mesa = rdm.mesa');
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where('reserva.id_reserva', $reserva);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_zona_($reserva){
        $this->db->select('*');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join(self::reserva_detalle_zona.' as rdz',' on rdz.reserva = reserva.id_reserva');
        $this->db->join( self::zona.' as zona',' on zona.id_reserva_zona = rdz.zona');
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where('reserva.id_reserva', $reserva);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_paquete_($reserva){
        $this->db->select('reserva.*, rp.*, p.id_reserva_paquete, p.nombre_paquete');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join(self::reserva_paquete.' as rp',' on rp.reserva = reserva.id_reserva');
        $this->db->join(self::paquetes.' as p',' on p.id_reserva_paquete = rp.paquete');
        $this->db->join( self::sucursal.' as s', ' on reserva.Sucursal = s.id_sucursal' );
        $this->db->where('s.id_sucursal', $this->session->usuario[0]->Sucursal);
        $this->db->where('reserva.id_reserva', $reserva);
        
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function update($reserva){

    	$cc = 0;
        $reserva_mesa = [];
        $reserva_zona = [];
        $reserva_habitacion = array();
        $reserva_paquete = [];

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

            if (isset($reserva['paquete-'.$cc])) {
                $reserva_paquete[$cc]['paquete'] = $reserva['paquete-'.$cc];
                $reserva_paquete[$cc]['cantidad'] = $reserva['cantidad-'.$cc];
                unset($reserva['paquete-'.$cc]);
            }
            unset($reserva['cantidad-'.$cc]);

            $cc++;
        }

        $fechaInicio = $reserva['fecha_entrada_reserva'];
        $horaInicio = $reserva['hora_entrada_reserva'];
        $fechaFin = $reserva['fecha_salida_reserva'];
        $horaFin  = $reserva['hora_salida_reserva'];

        unset($reserva['hora_entrada_reserva']);
        unset($reserva['hora_salida_reserva']);

        $reserva['fecha_entrada_reserva']  = $fechaInicio.' '.$horaInicio.':00';
        $reserva['fecha_salida_reserva']   = $fechaFin.' '.$horaFin.':00';

        /** Insertar Reserva */        
        $id_reserva = $reserva['id_reserva'];
        unset($reserva['id_reserva']);

        $reserva['total_personas_reserva'] = $reserva['total_adultos_reserva'] + $reserva['total_ninos_reserva'];

        $this->db->where('id_reserva', $id_reserva);
        $result = $this->db->update(self::reserva, $reserva);

        if(!$result){
            $result = $this->db->error();
        }

        /** Insertar Detalle habitacion */
        
        $this->db->where('reserva', $id_reserva);
        $this->db->delete(self::reserva_detalle_habitacion);
        
        if($reserva_habitacion){

            foreach ($reserva_habitacion as $key => $habitacion) {
                
                $detalle = array('reserva'=> $id_reserva, 'habitacion'=> $habitacion);
                $this->db->insert(self::reserva_detalle_habitacion, $detalle);
            }
        }

        /** Insertar Detalle mesas */
        
        $this->db->where('reserva', $id_reserva);
        $this->db->delete(self::reserva_detalle_mesa);
        
        if($reserva_mesa){

            foreach ($reserva_mesa as $key => $mesa) {
                
                $detalle = array('reserva'=> $id_reserva, 'mesa'=> $mesa);
                $this->db->insert(self::reserva_detalle_mesa, $detalle);
            }
        }

        /** Insertar Detalle Zona */
        $this->db->where('reserva', $id_reserva);
        $this->db->delete(self::reserva_detalle_zona);

        if($reserva_zona){

            foreach ($reserva_zona as $key => $zona) {
                
                $detalle = array('reserva'=> $id_reserva, 'zona'=> $zona);
                $this->db->insert(self::reserva_detalle_zona, $detalle);
            }
        }

        /** Insertar Paquete */
        $this->db->where('reserva', $id_reserva);
        $this->db->delete(self::reserva_paquete);
        if($reserva_paquete){
            foreach ($reserva_paquete as $key => $paquete) {
                $detalle = array('reserva' => $id_reserva, 'paquete'=> $paquete['paquete'], 'cantidad'=> $paquete['cantidad']);
                $this->db->insert(self::reserva_paquete, $detalle);
            }
        }

        return $result;
    }

    public function eliminar($id)
    {
        $this->db->where('reserva', $id);  
        $result = $this->db->delete(self::reserva_detalle_articulos);

        $this->db->where('reserva', $id);  
        $result = $this->db->delete(self::reserva_detalle_habitacion);

        $this->db->where('reserva', $id);  
        $result = $this->db->delete(self::reserva_detalle_mesa);

        $this->db->where('reserva', $id);  
        $result = $this->db->delete(self::reserva_paquete);

        $this->db->where('reserva', $id);  
        $result = $this->db->delete(self::reserva_detalle_zona);

        $this->db->where('id_reserva', $id);  
        $result = $this->db->delete(self::reserva);
        if(!$result){
            $result = $this->db->error();
        }

        return $result;
    }

    public function get_reservar_from_landing($reserva)
    {       

        $imagen="";
        $imageProperties="";
        if (!empty($_FILES['imagen_pago_reserva']['tmp_name'])) {
            $imagen = @file_get_contents($_FILES['imagen_pago_reserva']['tmp_name']);
            $imageProperties = @getimageSize($_FILES['imagen_pago_reserva']['tmp_name']);
        }

        $fechaInicio = $reserva['fecha_entrada_reserva'];
        $horaInicio  = $reserva['hora_entrada_reserva'];
        $fechaFin    = $reserva['fecha_salida_reserva'];
        $horaFin     = $reserva['hora_salida_reserva'];

        $reserva['fecha_entrada_reserva'] = $fechaInicio.' '.$horaInicio.':00';
        $reserva['fecha_salida_reserva']  = $fechaFin.' '.$horaFin.':00';

        unset($reserva['hora_entrada_reserva']);
        unset($reserva['hora_salida_reserva']);
        
        $reserva['color'] = "#e4f21c";

        $today = date("Ymd");
        $rand = sprintf("%02d", rand(0,99));
        $unique = $today .'-'. $rand;

        $reserva['fecha_creada_reserva'] = date('Y-m-d H:i:s');
        $reserva['imagen_pago_reserva'] = @$imagen;
        $reserva['imagen_tipo_reserva'] = @$imageProperties['mime'];
        $reserva['estado_reserva'] = 10;

        /** Insertar Reserva */        
        $reserva['Sucursal']        = 2;
        $reserva['codigo_reserva']  = $unique;
        $reserva['cliente_reserva'] = 1;

        $reserva['habitacion_aplica']   = isset($reserva['habitacion_aplica']) ? 1 : 0;
        $reserva['estadia_aplica']      = isset($reserva['estadia_aplica']) ? 1 : 0;
        $reserva['comida_aplica']       = isset($reserva['comida_aplica']) ? 1 : 0;

        $reserva['total_personas_reserva'] = $reserva['total_adultos_reserva'] + $reserva['total_ninos_reserva'];

        $cc = 0;
        $reserva_paquete_reserva = [];
        $reserva_eventos = [];
        foreach ($reserva as $key => $paquete) {

            if (isset($reserva['paquete_'.$cc])) {
                $reserva_paquete_reserva[$cc]['paquete'] = $reserva['paquete_'.$cc];
                $reserva_paquete_reserva[$cc]['cantidad'] = $reserva['cantidad_'.$cc];
                unset($reserva['paquete_'.$cc]);
            }
            unset($reserva['cantidad_'.$cc]);

            if (isset($reserva['evento'.$cc])) {
                $reserva_eventos[$cc] = $reserva['evento'.$cc];
            }
            unset($reserva['evento'.$cc]);

            $cc++;
        }

        $insert     = $this->db->insert(self::reserva, $reserva);
        $id_reserva = $this->db->insert_id();
        $this->insert_reserva_paquete($id_reserva, $reserva_paquete_reserva);
        $this->insert_reserva_evento($id_reserva, $reserva_eventos);

        if(!$insert){
            $insert = $this->db->error();
            return $insert;            
        }

        return $unique;
    }

    private function insert_reserva_paquete($reserva, $paquetes)
    {
        if ($paquetes) {
            foreach ($paquetes as $paquete) {
                $this->db->insert(self::reserva_paquete, array(
                    'reserva' => $reserva,
                    'paquete' => $paquete['paquete'],
                    'cantidad' => $paquete['cantidad']
                ));
            }
        }
    }

    private function insert_reserva_evento($reserva, $eventos)
    {
        if ($eventos) {
            foreach ($eventos as $evento) {
                $this->db->insert(self::reserva_detalle_zona, array(
                    'reserva' => $reserva,
                    'zona' => $evento
                ));
            }
        }
    }

    public function get_capacidad($dates)
    {
        $this->db->select('sum(total_personas_reserva) as capacidad');
        $this->db->from(self::reserva);
        $this->db->where('DATE(fecha_entrada_reserva) >=', date('Y-m-d',strtotime($dates['inicio'])));
        $this->db->where('DATE(fecha_salida_reserva) <=', date('Y-m-d',strtotime($dates['fin'])));
        $query = $this->db->get();
        //echo $this->db->queries[0];die;

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_eventos_reserva($codigo){
        $this->db->select('(SELECT GROUP_CONCAT(zona.nombre_zona SEPARATOR ",")
            FROM reserva_zona  AS zona
            LEFT JOIN reserva_detalle_zona AS rdz ON zona.id_reserva_zona = rdz.zona
            WHERE rdz.reserva = reserva.id_reserva) AS eventos');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->join( self::estados.' as estados', ' on reserva.estado_reserva = estados.id_reserva_estados' );
        $this->db->where('reserva.codigo_reserva', $codigo);

        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function get_paquetes_reserva($codigo){
        $this->db->select('(SELECT GROUP_CONCAT(paquete.nombre_paquete SEPARATOR ",")
            FROM reserva_paquete  AS paquete
            LEFT JOIN reserva_paquete_reserva AS rp ON paquete.id_reserva_paquete = rp.reserva
            WHERE rp.reserva = reserva.id_reserva) AS paquetes');
        $this->db->from( self::reserva.' as reserva' );
        $this->db->where('reserva.codigo_reserva', $codigo);

        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}
