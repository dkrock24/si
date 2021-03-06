<?php
class Reporte_model extends CI_Model {

    const menu      = 'sys_menu';
    const submenu   = 'sys_menu_submenu';
    const sub_men_acceso = 'sys_submenu_acceso';
    const empresa   = 'pos_empresa';
    const usuarios  = 'sys_usuario';    
    const roles     = 'sys_role';
    const cargos    = 'sr_cargos';
    const ventas    = 'pos_ventas';
    const empleado  = 'sys_empleado';
    const persona   = 'sys_persona';
    const documento = 'pos_tipo_documento';
    const cliente   = 'pos_cliente';
    const pagos     = 'pos_venta_pagos';
    const estados   = 'pos_orden_estado';
    const turnos    = ' pos_turnos';
    const sucursal  = 'pos_sucursal';
    const corte_detalle     = 'pos_corte_detalle';
    const pos_correlativos  = 'pos_correlativos';
    const pos_ventas        = 'pos_ventas';
    const pos_caja          = 'pos_caja';
    const pos_terminal      = 'pos_terminal';
    const pos_corte_config  = 'pos_corte_config';
    const template          = 'pos_doc_temp';
    const giro_empresa      = 'giros_empresa';
    const giros             = 'pos_giros';
    const moneda            = 'sys_moneda';
    const venta_detalle     = 'pos_venta_detalle';
    
    function index($limit, $id , $filters )
    {

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

    function filtrar_venta( $filters )
    {

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

        $this->db->select('v.id , v.num_correlativo, v.fh_inicio, v.id_cliente , v.total_doc , d.nombre ,
        su.nombre_sucursal,v.documento_numero,
        (select sum(v_d.total) FROM pos_venta_detalle AS v_d WHERE v_d.id_venta = v.id AND v_d.gen = "Grava" ) AS grabado,
  
        (select sum(v_i.ordenImpTotal) FROM pos_ventas_impuestos AS v_i WHERE v_i.id_venta = v.id AND v_i.ordenSimbolo = "G" ) AS impuesto_g,

        (select sum(v_i.ordenImpTotal) FROM pos_ventas_impuestos AS v_i WHERE v_i.id_venta = v.id AND v_i.ordenImpName != "IVA" ) AS impuesto,

        (select sum(v_d.total) FROM pos_venta_detalle AS v_d WHERE v_d.id_venta = v.id AND v_d.gen = "Exent" ) AS exento,

        vd.p_inc_imp0,
        sum(vd.cantidad) AS producto_total,
        c.nombre_empresa_o_compania ,p.nombre_metodo_pago, s.orden_estado_nombre');
        $this->db->from(self::ventas.' as v');  
        $this->db->join(self::venta_detalle.' as vd',' vd ON vd.id_venta = v.id');
        $this->db->join(self::usuarios.' as u','u.id_usuario = v.id_cajero');  
        $this->db->join(self::empleado.' as e','e.id_empleado = u.Empleado');
        $this->db->join(self::documento.' as d','d.id_tipo_documento = v.id_tipod');
        $this->db->join(self::cliente.' as c','c.id_cliente = v.id_cliente');
        $this->db->join(self::pagos.' as p','p.venta_pagos = v.id');
        $this->db->join(self::estados.' as s','s.id_orden_estado = v.orden_estado');
        $this->db->join(self::sucursal.' as su','su.id_sucursal = v.id_sucursal');
        
        $this->db->where('DATE(v.fh_inicio)'  . ' >= ' , $f_inicio );
        $this->db->where('DATE(v.fh_final) <=' , $f_fin );
        $this->db->where('v.cortado IS NULL');
        $this->db->group_by('vd.id_venta');

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
        //echo $this->db->queries[7];
        //die;
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function concentrado( $filters )
    {
        $time       = "";
        $cajero     = "";
        $mask       = " 00:00:00";
        $f_inicio   = $filters['fh_inicio'].$mask;
        $f_fin      = $filters['fh_fin'].$mask;
        $sucursal   = $filters['sucursal'];
        $caja       = $filters['caja'];
        $sucursal_subquery = $sucursal;

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

        ( select COUNT(total_venta.id) FROM pos_ventas AS total_venta 
            WHERE DATE(total_venta.creado_el) >= "'.$f_inicio.'" AND DATE(total_venta.creado_el) <= "'.$f_fin.'"
            AND d.id_tipo_documento = total_venta.id_tipod 
            GROUP BY total_venta.id_tipod
             ) AS cantidad_documentos,

        (SELECT SUM(vd.total)
            FROM pos_venta_detalle AS vd join pos_ventas AS v_1 ON v_1.id = vd.id_venta
            WHERE vd.gen="Grava" and DATE(vd.creado_el) >= "'.$f_inicio.'" AND DATE(vd.creado_el) <= "'.$f_fin.'" 
            AND d.id_tipo_documento = v_1.id_tipod
            AND v_1.id_sucursal = '.$sucursal_subquery.' 
            ) AS gravado,
        
        (SELECT SUM(vi.ordenImpTotal)
            FROM pos_ventas_impuestos AS vi 
            join pos_ventas AS v_1 ON v_1.id = vi.id_venta
            WHERE  (vi.ordenImpName != "IVA" )  AND DATE(v_1.creado_el) >= "'.$f_inicio.'" AND DATE(v_1.creado_el) <= "'.$f_fin.'" 
            AND d.id_tipo_documento = v_1.id_tipod 
            AND v_1.id_sucursal = '.$sucursal_subquery.'
            ) AS gravado_impuesto,
        
        (SELECT SUM(vd.total)
            FROM pos_venta_detalle AS vd 
            join pos_ventas as ve on ve.id = vd.id_venta
            join pos_ventas AS v_1 ON v_1.id = vd.id_venta
            WHERE vd.gen="Exent" and DATE(ve.fh_inicio) >= "'.$f_inicio.'" AND DATE(ve.fh_final) <= "'.$f_fin.'" 
            AND d.id_tipo_documento = v_1.id_tipod
            AND v_1.id_sucursal = '.$sucursal_subquery.'
            ) AS exento,

        (SELECT COUNT(v2.id) 
            FROM pos_ventas AS v2 
            WHERE v2.id_tipod = d.id_tipo_documento && v2.orden_estado = 10
            AND DATE(v2.fh_inicio) >= "'.$f_inicio.'" AND DATE(v2.fh_final) <= "'.$f_fin.'"
            AND v2.id_sucursal = '.$sucursal_subquery.'
            ) AS total_devolucion,

        (SELECT SUM(vp.valor_metodo_pago)
            FROM pos_ventas AS dev
            JOIN pos_venta_pagos AS vp ON vp.venta_pagos = dev.id
            WHERE dev.id_tipod = d.id_tipo_documento && dev.orden_estado=10
            AND DATE(dev.fh_inicio) >= "'.$f_inicio.'" AND DATE(dev.fh_final) <= "'.$f_fin.'"
            AND dev.id_sucursal = '.$sucursal_subquery.'
            ) AS sum_devolucion,

        (SELECT COUNT(v7.id) 
            FROM pos_ventas AS v7
            WHERE v7.id_tipod = d.id_tipo_documento && v7.orden_estado = 7
            AND DATE(v7.fh_inicio) >= "'.$f_inicio.'" AND DATE(v7.fh_final) <= "'.$f_fin.'"
            AND v7.id_sucursal = '.$sucursal_subquery.'
            ) AS total_anulado,

        (SELECT SUM(vp.valor_metodo_pago)
            FROM pos_ventas AS anulado
            JOIN pos_venta_pagos AS vp ON vp.venta_pagos = anulado.id
            WHERE anulado.id_tipod = d.id_tipo_documento && anulado.orden_estado=7
            AND DATE(anulado.fh_inicio) >= "'.$f_inicio.'" AND DATE(anulado.fh_final) <= "'.$f_fin.'"
            AND anulado.id_sucursal = '.$sucursal_subquery.'
            ) AS sum_anulado,

        (SELECT SUM(venta.desc_val )
            FROM pos_ventas AS venta WHERE
            DATE(venta.fh_inicio) >= "'.$f_inicio.'" AND DATE(venta.fh_final) <= "'.$f_fin.'"
            AND venta.id_sucursal = '.$sucursal_subquery.'
            )AS descuento,
        
        (SELECT SUM(vp.valor_metodo_pago) 
            FROM pos_ventas AS v3 
            JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v3.id
            WHERE v3.id_tipod = d.id_tipo_documento && vp.id_forma_pago=1 
            AND DATE(v3.fh_inicio) >= "'.$f_inicio.'" AND DATE(v3.fh_final) <= "'.$f_fin.'"
            
            AND v3.id_sucursal = '.$sucursal_subquery.'
            ) AS efectivo,

        (SELECT SUM(vp.valor_metodo_pago) 
            FROM pos_ventas AS v4 
            JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v4.id
            WHERE v4.id_tipod = d.id_tipo_documento && vp.id_forma_pago=2 
            AND DATE(v4.fh_inicio) >= "'.$f_inicio.'" AND DATE(v4.fh_final) <= "'.$f_fin.'"
            AND v4.id_sucursal = '.$sucursal_subquery.'
            ) AS tcredito,
        
        (SELECT SUM(vp.valor_metodo_pago) 
            FROM pos_ventas AS v5 
            JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v5.id
            WHERE v5.id_tipod = d.id_tipo_documento && vp.id_forma_pago=3 
            AND DATE(v5.fh_inicio) >= "'.$f_inicio.'" AND DATE(v5.fh_final) <= "'.$f_fin.'"
            AND v5.id_sucursal = '.$sucursal_subquery.'
            ) AS cheque,
        
        (SELECT SUM(vp.valor_metodo_pago) 
            FROM pos_ventas AS v6 
            JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v6.id
            WHERE v6.id_tipod = d.id_tipo_documento && vp.id_forma_pago=4 
            AND DATE(v6.fh_inicio) >= "'.$f_inicio.'" AND DATE(v6.fh_final) <= "'.$f_fin.'"
            AND v6.id_sucursal = '.$sucursal_subquery.'
            ) AS credito,

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
        //$this->db->where('v.cortado' , NULL );

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
        $this->db->group_by('d.id_tipo_documento', 'ASC' );              
        $query = $this->db->get();
        //echo $this->db->queries[7];
        //die;
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    function get_turno( $turno_id )
    {
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

    /*
    * Filtrar datos a cortar
    */
    function concentrado_corte($filters,$cortar)
    {
        $time       = "";
        $cajero     = "";
        $mask       = " 00:00:00";
        $f_inicio   = $filters['fh_inicio'].$mask;
        $f_fin      = $filters['fh_fin'].$mask;
        $sucursal   = $filters['sucursal'];
        $caja       = $filters['caja'];
        $sucursal_subquery = $sucursal;

        if( $filters['turno'] != 0 )
        {
            $turnos         = $this->get_turno($filters['turno']);            
            $f_hora_inicio  = $turnos[0]->hora_inicio;
            $f_hora_fin     = $turnos[0]->hora_fin;

            $time = "DATE_FORMAT(v.fh_inicio, '%h-%i-%s') >= '".$f_hora_inicio."' AND DATE_FORMAT(v.fh_inicio, '%h-%i-%s') <= '".$f_hora_fin."'" ;

        }else{
            //$filter = " DATE(v.fh_inicio) BETWEEN ".  DATE($f_inicio) . " AND ".  DATE($f_fin);            
        }
        if( $filters['cajero'] != 0 )
        {
            $cajero = " v.id_cajero = ". $filters['cajero'];
        }
        
        if($sucursal != 0)
        {
            $sucursal = " v.id_sucursal = ". $sucursal;
        }
        
        if(isset($caja) and $caja != 0)
        {
            $caja = " v.id_caja = ". $caja;
        }

        $this->db->select('v.id , v.num_correlativo, v.fh_inicio, v.id_cliente , v.total_doc , d.nombre ,
            MIN(v.num_correlativo ) AS inicio , 
            MAX(v.num_correlativo )AS fin , 
            SUM(vd.impSuma) as impSuma,

            ( select COUNT(total_venta.id) FROM pos_ventas AS total_venta 
            WHERE DATE(total_venta.creado_el) >= "'.$f_inicio.'" AND DATE(total_venta.creado_el) <= "'.$f_fin.'"
            AND d.id_tipo_documento = total_venta.id_tipod AND total_venta.cortado IS NULL
            GROUP BY total_venta.id_tipod
             ) AS cantidad_documentos,

             (SELECT SUM(vd.total)
             FROM pos_venta_detalle AS vd join pos_ventas AS v_1 ON v_1.id = vd.id_venta
             WHERE vd.gen="Grava" and DATE(vd.creado_el) >= "'.$f_inicio.'" AND DATE(vd.creado_el) <= "'.$f_fin.'" 
             AND v_1.cortado IS NULL AND d.id_tipo_documento = v_1.id_tipod
             AND v_1.id_sucursal = '.$sucursal_subquery.' 
             ) AS gravado,
         
         (SELECT SUM(vi.ordenImpTotal)
             FROM pos_ventas_impuestos AS vi 
             join pos_ventas AS v_1 ON v_1.id = vi.id_venta
             WHERE  (vi.ordenImpName != "IVA" )  AND DATE(v_1.creado_el) >= "'.$f_inicio.'" AND DATE(v_1.creado_el) <= "'.$f_fin.'" 
             AND v_1.cortado IS NULL  AND d.id_tipo_documento = v_1.id_tipod 
             AND v_1.id_sucursal = '.$sucursal_subquery.'
             ) AS gravado_impuesto,
         
         (SELECT SUM(vd.total)
             FROM pos_venta_detalle AS vd 
             join pos_ventas as ve on ve.id = vd.id_venta
             join pos_ventas AS v_1 ON v_1.id = vd.id_venta
             WHERE vd.gen="Exent" and DATE(ve.fh_inicio) >= "'.$f_inicio.'" AND DATE(ve.fh_final) <= "'.$f_fin.'" 
             AND v_1.cortado IS NULL AND d.id_tipo_documento = v_1.id_tipod
             AND v_1.id_sucursal = '.$sucursal_subquery.'
             ) AS exento,
 

            (SELECT COUNT(v2.id) 
                FROM pos_ventas AS v2 
                WHERE v2.id_tipod = d.id_tipo_documento && v2.orden_estado=10
                AND DATE(v2.fh_inicio) >= "'.$f_inicio.'" AND DATE(v2.fh_final) <= "'.$f_fin.'"
                AND v2.cortado IS NULL
                ) AS total_devolucion,

            (SELECT SUM(vp.valor_metodo_pago) 
                FROM pos_ventas AS dev 
                JOIN pos_venta_pagos AS vp ON vp.venta_pagos = dev.id
                WHERE dev.id_tipod = d.id_tipo_documento && dev.orden_estado=10 
                AND DATE(dev.fh_inicio) >= "'.$f_inicio.'" AND DATE(dev.fh_final) <= "'.$f_fin.'"
                AND dev.cortado IS NULL
                ) AS sum_devolucion,

            (SELECT SUM(venta.desc_val ) 
                FROM pos_ventas AS venta WHERE 
                DATE(venta.fh_inicio) >= "'.$f_inicio.'" AND DATE(venta.fh_final) <= "'.$f_fin.'"
                AND venta.cortado IS NULL
                )AS descuento,
            
            (SELECT SUM(vp.valor_metodo_pago)
                FROM pos_ventas AS v3
                JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v3.id
                WHERE v3.id_tipod = d.id_tipo_documento && vp.id_forma_pago=1
                AND DATE(v3.fh_inicio) >= "'.$f_inicio.'" AND DATE(v3.fh_final) <= "'.$f_fin.'"
                AND v3.cortado IS NULL
                ) AS efectivo,

            (SELECT SUM(vp.valor_metodo_pago)
                FROM pos_ventas AS v4 
                JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v4.id
                WHERE v4.id_tipod = d.id_tipo_documento && vp.id_forma_pago=2 
                AND DATE(v4.fh_inicio) >= "'.$f_inicio.'" AND DATE(v4.fh_final) <= "'.$f_fin.'"
                AND v4.cortado IS NULL
                ) AS tcredito,
            
            (SELECT SUM(vp.valor_metodo_pago)
                FROM pos_ventas AS v5
                JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v5.id
                WHERE v5.id_tipod = d.id_tipo_documento && vp.id_forma_pago=3
                AND DATE(v5.fh_inicio) >= "'.$f_inicio.'" AND DATE(v5.fh_final) <= "'.$f_fin.'"
                AND v5.cortado IS NULL
                ) AS cheque,

            (SELECT SUM(vp.valor_metodo_pago)
                FROM pos_ventas AS v6
                JOIN pos_venta_pagos AS vp ON vp.venta_pagos = v6.id
                WHERE v6.id_tipod = d.id_tipo_documento && vp.id_forma_pago=4
                AND DATE(v6.fh_inicio) >= "'.$f_inicio.'" AND DATE(v6.fh_final) <= "'.$f_fin.'"
                AND v6.cortado IS NULL
                ) AS credito,

            c.nombre_empresa_o_compania ,p.nombre_metodo_pago, s.orden_estado_nombre');
        $this->db->from(self::ventas.' as v');  
        $this->db->join(self::venta_detalle.' as vd',' vd.id_venta = v.id');  
        $this->db->join(self::usuarios.' as u','u.id_usuario = v.id_cajero');  
        $this->db->join(self::empleado.' as e','e.id_empleado = u.Empleado');
        $this->db->join(self::documento.' as d','d.id_tipo_documento = v.id_tipod');
        $this->db->join(self::cliente.' as c','c.id_cliente = v.id_cliente');
        $this->db->join(self::pagos.' as p','p.venta_pagos = v.id');
        $this->db->join(self::estados.' as s','s.id_orden_estado = v.orden_estado');
        
        $this->db->where('DATE(v.fh_inicio)'  . ' >= ' , $f_inicio );
        $this->db->where('DATE(v.fh_final) <=' , $f_fin );
        $this->db->where('v.cortado' , NULL );

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
        $this->db->group_by('d.id_tipo_documento', 'ASC' );              
        $query = $this->db->get();
        //echo $this->db->queries[8];
        //die;

        $data = $query->result();
        $dataResult = $data;

        $corte_config = $this->get_corte_config($filters);
        $infoEmpresa  = $this->getInfoEmpresa($filters);

        // Iniciar corte con las ventas filtradas
        $corteData = array();
        $corte     = array();
        
        if($data)
        {
            $data = (object) array_merge ((array) $infoEmpresa[0], (array) $data[0]);
            $data = (object) array_merge ((array) $data,        (array) $corte_config[0] );
            if ($cortar) {
                $corteData = ['corteId' => $this->cortar_proceso($dataResult , $filters) ];
                $corte     = ['corteData' => $this->getCorteData($corteData)];
                
                $data = (object) array_merge ((array) $data, (array) $corteData );
                $data = (object) array_merge ((array) $data, (array) $corte );

                $ventaList = $this->getVentaList($filters);
                $this->updateCorte($ventaList);
            }
        }

        return $data;
    }

    private function getVentaList($filters){
        $table = self::pos_ventas;
        $this->db->select('*');
        $this->db->from(self::pos_ventas)
            ->where('DATE('.self::pos_ventas.'.creado_el)' . ' >= ', $filters['fh_inicio'])
            ->where('DATE('.self::pos_ventas.'.creado_el)' . ' <= ', $filters['fh_fin'])
            ->where(self::pos_ventas.'.cortado',NULL);
        
        $query = $this->db->get();      
        //echo $this->db->queries[14];
        $data  = $query->result();

        return  $data;            
    }

    private function updateCorte($ventaList){
        
        $ventas = [];
        foreach ($ventaList as $venta) {
            $ventas[] = array('cortado' => 1, 'id' => $venta->id);
            
        }
        $result = $this->db->update_batch('pos_ventas',$ventas,'id');
    }

    private function getInfoEmpresa($filters){

        $this->db->select('s.*,g.*,m.*,e.*,u.*,em.*,p.*,caja.*');

        $this->db->from(self::sucursal.' as s');
        $this->db->join(self::empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->join(self::pos_terminal.' as t',' on t.Sucursal = s.id_sucursal');
        $this->db->join(self::pos_caja.' as caja',' on caja.id_caja = t.Caja');
        $this->db->join(self::giro_empresa.' as ge',' on ge.Empresa = e.id_empresa');
        $this->db->join(self::giros.' as g',' on ge.Giro = g.id_giro');
        $this->db->join(self::usuarios.' as u',' on u.id_usuario = '. $this->session->usuario[0]->id_usuario);
        $this->db->join(self::empleado.' as em',' on em.id_empleado = u.Empleado');
        $this->db->join(self::persona.' as p',' on p.id_persona = em.Persona_E');
        $this->db->join(self::moneda.' as m',' on m.id_moneda = e.Moneda');
        $this->db->where('s.id_sucursal',$filters['sucursal']);
        $this->db->where('caja.id_caja',$filters['caja']);
        $this->db->where('ge.Empresa limit 1');
        $query = $this->db->get();
        //echo $this->db->queries[6];
        //die;

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /*
    * Recorrer los datos en documentos concentrados
    * Guardar el corte comó venta en la tabla de ventas
    */
    private function cortar_proceso($datos_venta , $filters)
    {
        $id_venta_corte = null;
        $corte_config   = $this->get_corte_config($filters);

        if ($corte_config)
        {
            $id_venta_corte = $this->save_venta($datos_venta , $filters, $corte_config[0]);      

            if ($id_venta_corte)
            {
                foreach ($datos_venta as $value) 
                {
                    $this->update_venta_cortada($value ,$id_venta_corte);
                }
            }
        }        
        
        return $id_venta_corte;   
    }

    /*
    * Guardar el detalle del corte concentrado en corte detalle
    */
    private function update_venta_cortada($data , $id_venta_corte)
    {
        $total_venta = $data->efectivo + $data->tcredito + $data->cheque+ $data->credito;
        $exento = number_format($data->exento,2);
        $gravado = number_format($data->gravado,2);

        $data_corte = array(
            'id_venta'          => $id_venta_corte,
            'iva_corte'         => ($total_venta * 0.13) / 1.13,
            'total_corte'       => $total_venta,
            'monto_grabado'     => $gravado,
            'monto_excento'     => $exento,
            'correlativo_fin'   => $data->fin,
            'documento_nombre'  => $data->nombre,
            'total_documentos'  => $data->cantidad_documentos,
            'correlativo_inicio'=> $data->inicio,
        );
        
        $this->db->insert(self::corte_detalle, $data_corte ); 
    }

    /*
    * Guardar el corte en venta
    */
    private function save_venta($datos_venta , $venta_data, $corte_config)
    {
        $venta_id = null;

        $correlativo = $this->get_siguiente_correlativo(
            $corte_config->sucursal_id,
            $corte_config->documento_corte
        );

        $calculos   = $this->calcular_montos($datos_venta);
        $cajaInfo   = $this->get_caja_info($venta_data);

        if($correlativo && $cajaInfo)
        {
            $data = array(
                'id_sucursal'       => $venta_data['sucursal'],
                'id_sucursal_origin'=> $venta_data['sucursal'],
                'id_caja'           => $venta_data['caja'],
                'id_vendedor'       => $this->session->db[0]->id_empleado,
                'id_cajero'         => $this->session->db[0]->id_usuario,
                'id_usuario'        => $this->session->db[0]->id_usuario,
                'id_tipod'          => $corte_config->documento_corte,
                'numero_documento'  => $correlativo[0]->siguiente_valor,
                'num_correlativo'   => $correlativo[0]->siguiente_valor,
                'num_caja'          => $cajaInfo[0]->cod_interno_caja,
                'fecha'             => date("Y-m-d h:i:s"),
                'fh_inicio'         => date("Y-m-d h:i:s"),
                'fh_final'          => date("Y-m-d h:i:s"),
                'fecha_inglab'      => date("Y-m-d h:i:s"),
                'creado_el'         => date("Y-m-d h:i:s"),
                'id_condpago'       => 0,
                'id_cliente'        => 0,
                'digi_total'        => $calculos['total_Venta'],
                'total_doc'         => $calculos['total_Venta'],
                'impSuma1'           => $datos_venta[0]->impSuma,
                'cortado'           => 2,
                'venta_vista_id'    => 90,
                'orden_estado'      => 11,
            );
            
            $this->db->insert(self::pos_ventas, $data );
            $venta_id = $this->db->insert_id();

            if($venta_id){
                $this->incremento_correlativo( 
                    $correlativo[0]->siguiente_valor,
                    $corte_config->sucursal_id,
                    $corte_config->documento_corte
                );
            }            
        }
        return $venta_id;
    }

    /*
    * 
    */
    private function calcular_montos($corte_data)
    {
        $data = array(
            'cantidad_devolucion'=> 0.00,
            'total_devolucion'   => 0.00,
            'suma_devolucion'    => 0.00,
            'suma_descuento'     => 0.00,
            'suma_efectivo'      => 0.00,
            'suma_tcredito'      => 0.00,
            'suma_cheque'        => 0.00,
            'suma_credito'       => 0.00,
            'total_venta'        => 0.00,
        );

        foreach ($corte_data as $key => $value) 
        {
            $data['cantidad_devolucion']    += $value->total_devolucion;
            $data['total_devolucion']       += $value->total_devolucion;
            $data['suma_efectivo']          += $value->efectivo;
            $data['suma_devolucion']        += number_format($value->sum_devolucion,2) * (-1);
            $data['suma_descuento']         += number_format($value->descuento,2);
            $data['suma_tcredito']          += number_format($value->tcredito,2);
            $data['suma_cheque']            += number_format($value->cheque,2);
            $data['suma_credito']           += number_format($value->cheque,2);
        }
        $data['total_Venta'] = (
            $data['suma_efectivo'] +
            $data['suma_tcredito'] +
            $data['suma_cheque']   +
            $data['suma_credito']
        );

        return $data;
    }

    /*
    * Obtener el siguiente correlativo del documento en la sucursal correspondiente
    */
    private function get_siguiente_correlativo($sucursal , $documento)
    {
        $this->db->select('siguiente_valor');
        $this->db->from(self::pos_correlativos);
        $this->db->where('Sucursal',$sucursal);
        $this->db->where('TipoDocumento',$documento);
        $query = $this->db->get(); 
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /*
    * Aunmentar la Secuencia del tipo de documento en la sucursal.
    */
    private function incremento_correlativo($numero,  $sucursal , $documento )
    {
			
        $correlativo = (int) $numero+1;

        $data = array(
            'siguiente_valor' => $correlativo
        );
                    
        $this->db->where('Sucursal', $sucursal );
        $this->db->where('TipoDocumento', $documento );
        $this->db->update(self::pos_correlativos, $data );
    }

    /*
    * Obtener informacion de caja y terminal segun la sucursal
    */
    private function get_caja_info($caja)
    {
        $this->db->select('*');
        $this->db->from(self::pos_caja.' as c');
        $this->db->join(self::pos_terminal.' as t', ' on t.Caja = c.id_caja');
        $this->db->where('c.id_caja', $caja['caja']);
        $query = $this->db->get();

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /*
    * Obtener la configuracion de corte para el documento por sucursal y terminal
    */
    private function get_corte_config($corte_config_params)
    {
        $this->db->select('*');
        $this->db->from(self::pos_corte_config.' as cc');
        $this->db->join(self::pos_terminal .' as  t', ' on t.id_terminal = cc.terminal_id');
        $this->db->where('cc.sucursal_id', $corte_config_params['sucursal']);
        $this->db->where('t.Caja', $corte_config_params['caja']);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /*
    * Retornar el corte en tabla ventas
    */
    private function getCorteData($data)
    {
        $this->db->select('v.*,c.*,s.*,g.*,p.*,t.*,caja.*,m.*,cor.*,cc.*, em.codigo_empleado,e.nombre_razon_social,e.nombre_comercial,e.nrc,e.nit');
        $this->db->from(self::pos_ventas.' as v');
        $this->db->join(self::corte_detalle.' as c',' on c.id_venta = v.id');
        $this->db->join(self::sucursal.' as s',' on s.id_sucursal = v.id_sucursal');
        $this->db->join(self::empresa.' as e',' on e.id_empresa = s.Empresa_Suc');
        $this->db->join(self::pos_caja.' as caja',' on caja.id_caja = v.id_caja');
        $this->db->join(self::pos_terminal.' as t',' on t.Caja = caja.id_caja');
        $this->db->join(self::giro_empresa.' as ge',' on ge.Empresa = e.id_empresa');
        $this->db->join(self::giros.' as g',' on ge.Giro = g.id_giro');
        $this->db->join(self::usuarios.' as u',' on u.id_usuario = v.id_usuario');
        $this->db->join(self::empleado.' as em',' on em.id_empleado = u.Empleado');
        $this->db->join(self::persona.' as p',' on p.id_persona = em.Persona_E');
        $this->db->join(self::moneda.' as m',' on m.id_moneda = e.Moneda');
        $this->db->join(self::pos_correlativos.' as cor',' on cor.Sucursal = v.id_sucursal');
        $this->db->join(self::pos_corte_config.' as cc',' on cc.sucursal_id = v.id_sucursal');
        $this->db->where('v.id',$data['corteId']);
        $this->db->where('cor.Sucursal = v.id_sucursal');
        $this->db->where('cor.TipoDocumento = v.id_tipod');
        $this->db->where('cc.sucursal_id = v.id_sucursal');
        $this->db->where('cc.documento_corte = v.id_tipod');
        $this->db->where('ge.Empresa limit 1');
        $query = $this->db->get();
        //echo $this->db->queries[11];
        //die;

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    /*
    * Retornar el detalle del corte para el template
    */
    public function corte_detalle($venta)
    {
        $this->db->select('*');
        $this->db->from(self::corte_detalle.' as c');
        //$this->db->join(self::documento.' as d',' on c.documento_corte = d.id_documento');
        $this->db->where('c.id_venta',$venta);
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }

    public function template($configCorte)
    {
        $corte = (array) $configCorte;
        //var_dump($corte['documento_corte']);die;
        $terminal = $this->get_caja_info(array('caja' => $configCorte->id_caja));

        $this->db->select('*, d.nombre as documento_nombre');
        $this->db->from(self::pos_corte_config.' as c');
        $this->db->join(self::template.' as t', ' on c.template_id = t.id_factura');
        $this->db->join(self::documento.' as d', ' on d.id_tipo_documento = c.documento_corte');
        $this->db->where('c.sucursal_id',$corte['Sucursal']);
        $this->db->where('c.terminal_id',$terminal[0]->id_terminal);
        $this->db->where('c.documento_corte',$corte['documento_corte']);
        $query = $this->db->get(); 
        //echo $this->db->queries[16];

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
}