<?php
class EfectosDocumento_model extends CI_Model {

        const producto =  'producto';
		const atributo =  'atributo';
		const atributo_opcion =  'atributos_opciones';
		const categoria =  'categoria';
		const producto_valor =  'producto_valor';
		const categoria_producto =  'categoria_producto';		
		const producto_atributo =  'producto_atributo';
		const pos_giros =  'pos_giros';
		const empresa_giro =  'giros_empresa';
		const pos_empresa = 'pos_empresa';
		const giro_plantilla =  'giro_pantilla';
		const pos_linea = 'pos_linea';
		const proveedor = 'pos_proveedor';
		const producto_proveedor = 'pos_proveedor_has_producto';
		const marcas = 'pos_marca';
		const cliente = 'pos_cliente';
		const sucursal = 'pos_sucursal';
		const producto_detalle = 'prouducto_detalle';
		const impuestos = 'pos_tipos_impuestos';
		const producto_img = 'pos_producto_img';
		const pos_proveedor_has_producto = 'pos_proveedor_has_producto';
		const producto_bodega = 'pos_producto_bodega';
		const pos_ordenes = 'pos_ordenes';
		const pos_ventas = 'pos_ventas';
		const pos_venta_pagos = 'pos_venta_pagos';
		const pos_correlativos = 'pos_correlativos';
		const sys_empleado = 'sys_empleado';
		const pos_ordenes_detalle = 'pos_orden_detalle';
		const pos_venta_detalle = 'pos_venta_detalle';
		const pos_ventas_impuestos = 'pos_ventas_impuestos';
		const pos_combo = 'pos_combo';
		const sys_conf = 'sys_conf';	

    function accion( $orden , $documento){
        
        $this->inventario($orden , $documento);
        $this->iva($orden , $documento);
        $this->cuenta($orden , $documento);
        $this->caja($orden , $documento);
        $this->reporte($orden , $documento);
    }

    function inventario( $orden , $documento){

        $cantidad = 0;

        foreach ($orden['orden'] as $key => $productos) {

            $cantidad = $this->get_cantidad_bodega($productos['producto_id'], $productos['id_bodega']);
            
            if($documento[0]->efecto_inventario ==1){

                $cantidad_nueva = ($cantidad[0]->Cantidad + $productos['cantidad']);

            }else if($documento[0]->efecto_inventario ==2){
                
                $cantidad_nueva = ($cantidad[0]->Cantidad - $productos['cantidad']);
            }
            
            $data = array(
                'Cantidad'	=>  $cantidad_nueva
            );

            $this->db->where('Producto', $productos['producto_id'] );
            $this->db->where('Bodega', $productos['id_bodega'] );
            $this->db->update(self::producto_bodega, $data ); 
        }
    }

    function devolucionesNuevoDocumento( $orden , $documento){

        foreach ($orden['orden'] as $key => $productos) {

            $cantidad       = $this->get_cantidad_bodega($productos['producto_id'], $productos['id_bodega']);            
            $cantidad_nueva = ($cantidad[0]->Cantidad + $productos['cantidad']);
            
            $data = array(
                'Cantidad'	=>  $cantidad_nueva
            );

            $this->db->where('Producto', $productos['producto_id'] );
            $this->db->where('Bodega', $productos['id_bodega'] );
            $this->db->update(self::producto_bodega, $data );
        }
    }

    function iva( $orden , $documento){

    }

    function cuenta( $orden , $documento){

    }

    function caja( $orden , $documento){

    }

    function reporte( $orden , $documento){

    }

    function get_cantidad_bodega( $id_producto , $id_bodega ){

        $this->db->select('*');
        $this->db->from(self::producto_bodega);
        $this->db->where('Producto', $id_producto );
        $this->db->where('Bodega', $id_bodega );
        $query = $this->db->get(); 

        if($query->num_rows() > 0 )
        {
            return $query->result();
        }

    }


}