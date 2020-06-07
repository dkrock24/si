<?php
class Reporte_model extends CI_Model {

    const menu      = 'sys_menu';
    const submenu   = 'sys_menu_submenu';
    const sub_men_acceso = 'sys_submenu_acceso';
    const empresa   = 'sys_empresa';
    const usuarios  = 'sys_usuario';    
    const roles     = 'sys_role';
    const cargos    = 'sr_cargos';
    const ventas    = 'pos_ventas';
    const empleado  = 'sys_empleado';
    const documento = 'pos_tipo_documento';
    const cliente   = 'pos_cliente';
    const pagos     = 'pos_venta_pagos';
    const estados   = 'pos_orden_estado';
    const turnos    = ' pos_turnos';
    
    function index($limit, $id , $filters ){

        $this->db->select('*');
        $this->db->from(self::roles);  
        $this->db->where(self::roles.'.Empresa', $this->session->empresa[0]->id_empresa);  
        if($filters!=""){
            $this->db->where($filters);
        }
        $this->db->limit($limit, $id);
        $query = $this->db->get();
        //echo $this->db->queries[2];
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function filtrar_venta( $filters ){

        $time       = "";
        $cajero     = "";
        $mask       = " 00:00:00";
        $f_inicio   = $filters['fh_inicio'].$mask;
        $f_fin      = $filters['fh_fin'].$mask;
        $sucursal   = $filters['sucursal'];
        $caja       = $filters['caja'];

        if( $filters['turno'] != 0 ){
            $turnos = $this->get_turno($filters['turno']);            
            $f_hora_inicio   = $turnos[0]->hora_inicio;
            $f_hora_fin      = $turnos[0]->hora_fin;
            $time = "DATE_FORMAT(v.fh_inicio, '%h-%i-%s') >= '".$f_hora_inicio."' AND DATE_FORMAT(v.fh_inicio, '%h-%i-%s') <= '".$f_hora_fin."'" ;

        }else{
            //$filter = " DATE(v.fh_inicio) BETWEEN ".  DATE($f_inicio) . " AND ".  DATE($f_fin);            
        }

        if( $filters['cajero'] != 0 ){            
            $cajero = " v.id_cajero = ". $filters['cajero'];
        }
        if($sucursal != 0){
            $sucursal = " v.id_sucursal = ". $sucursal;
        }
        if(isset($caja) and $caja != 0){
            $caja = " v.id_caja = ". $caja;
        }

        $this->db->select('v.id , v.num_correlativo, v.fh_inicio, v.id_cliente , v.total_doc , d.nombre , c.nombre_empresa_o_compania ,p.nombre_metodo_pago, s.orden_estado_nombre');
        $this->db->from(self::ventas.' as v');  
        $this->db->join(self::usuarios.' as u','u.id_usuario = v.id_cajero');  
        $this->db->join(self::empleado.' as e','e.id_empleado = u.Empleado');
        $this->db->join(self::documento.' as d','d.id_tipo_documento = v.id_tipod');
        $this->db->join(self::cliente.' as c','c.id_cliente = v.id_cliente');
        $this->db->join(self::pagos.' as p','p.venta_pagos = v.id');
        $this->db->join(self::estados.' as s','s.id_orden_estado = v.orden_estado');
        
        $this->db->where('DATE(v.fh_inicio)'  . ' >= ' , $f_inicio );
        $this->db->where('DATE(v.fh_final) <=' , $f_fin );

        if( $time != "" ){
            $this->db->where( $time );   
        }
        if( $sucursal){          
            $this->db->where( $sucursal );            
           // $this->db->where(DATE('v.fh_inicio') . " BETWEEN ". DATE("2020-02-04 00:00:00") ." AND ". "2020-02-05 00:00:00");
        }
        if( $cajero ){
            $this->db->where( $cajero ); 
        }
        if($caja){
            $this->db->where( $caja );
        }
        $query = $this->db->get();
        //echo $this->db->queries[4];    
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function concentrado( $filters ){

        $time       = "";
        $cajero     = "";
        $mask       = " 00:00:00";
        $f_inicio   = $filters['fh_inicio'].$mask;
        $f_fin      = $filters['fh_fin'].$mask;
        $sucursal   = $filters['sucursal'];
        $caja       = $filters['caja'];

        if( $filters['turno'] != 0 ){

            $turnos         = $this->get_turno($filters['turno']);            
            $f_hora_inicio  = $turnos[0]->hora_inicio;
            $f_hora_fin     = $turnos[0]->hora_fin;

            $time = "DATE_FORMAT(v.fh_inicio, '%h-%i-%s') >= '".$f_hora_inicio."' AND DATE_FORMAT(v.fh_inicio, '%h-%i-%s') <= '".$f_hora_fin."'" ;

        }else{
            //$filter = " DATE(v.fh_inicio) BETWEEN ".  DATE($f_inicio) . " AND ".  DATE($f_fin);            
        }
        if( $filters['cajero'] != 0 ){             
            $cajero = " v.id_cajero = ". $filters['cajero'];
        }
        if($sucursal != 0){
            $sucursal = " v.id_sucursal = ". $sucursal;
        }
        if(isset($caja) and $caja != 0){
            $caja = " v.id_caja = ". $caja;
        }

        $this->db->select('v.id , v.num_correlativo, v.fh_inicio, v.id_cliente , v.total_doc , d.nombre ,
        MIN(v.num_correlativo ) AS inicio , 
        MAX(v.num_correlativo )AS fin , 
        (SELECT count(v2.total_doc) FROM pos_ventas AS v2 WHERE  v2.id_tipod = d.id_tipo_documento && v2.orden_estado=10 ) AS total_devolucion,
        (SELECT SUM(v2.total_doc) FROM pos_ventas AS v2 WHERE  v2.id_tipod = d.id_tipo_documento && v2.orden_estado=10 ) AS sum_devolucion,
        SUM(v.desc_val) AS descuento,
        (SELECT SUM(v.total_doc) FROM pos_venta_pagos AS vp WHERE vp.venta_pagos = v.id AND vp.id_forma_pago=1) AS efectivo,
        (SELECT SUM(v.total_doc) FROM pos_venta_pagos AS vp WHERE vp.venta_pagos = v.id AND vp.id_forma_pago=3) AS cheque,
        (SELECT SUM(v.total_doc) FROM pos_venta_pagos AS vp WHERE vp.venta_pagos = v.id AND vp.id_forma_pago=2) AS tcredito,
        (SELECT SUM(v.total_doc) FROM pos_venta_pagos AS vp WHERE vp.venta_pagos = v.id AND vp.id_forma_pago=7) AS credito,
        c.nombre_empresa_o_compania ,p.nombre_metodo_pago, s.orden_estado_nombre');
        $this->db->from(self::ventas.' as v');  
        $this->db->join(self::usuarios.' as u','u.id_usuario = v.id_cajero');  
        $this->db->join(self::empleado.' as e','e.id_empleado = u.Empleado');
        $this->db->join(self::documento.' as d','d.id_tipo_documento = v.id_tipod');
        $this->db->join(self::cliente.' as c','c.id_cliente = v.id_cliente');
        $this->db->join(self::pagos.' as p','p.venta_pagos = v.id');
        $this->db->join(self::estados.' as s','s.id_orden_estado = v.orden_estado');
        
        $this->db->where('DATE(v.fh_inicio)'  . ' >= ' , $f_inicio );
        $this->db->where('DATE(v.fh_final) <=' , $f_fin );

        if( $time != "" ){
            $this->db->where( $time );   
        }
        if( $sucursal){          
            $this->db->where( $sucursal );            
           // $this->db->where(DATE('v.fh_inicio') . " BETWEEN ". DATE("2020-02-04 00:00:00") ." AND ". "2020-02-05 00:00:00");
        }
        if( $cajero ){
            $this->db->where( $cajero ); 
        }
        if($caja){
            $this->db->where( $caja );
        }
        $this->db->group_by('d.nombre', 'ASC' );              
        $query = $this->db->get();
        //echo $this->db->queries[4];                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_turno( $turno_id ){

        $this->db->select('*');
        $this->db->from(self::turnos);  
        $this->db->where('id_turno' , $turno_id );  
        $this->db->where(self::turnos.'.Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get();
                
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }

    }
}