<?php
class EfectosDocumento_model extends CI_Model {

	const producto_bodega = 'pos_producto_bodega';	

    function accion( $orden , $documento){
        
        $this->inventario($orden , $documento);
        $this->iva($orden , $documento);
        $this->cuenta($orden , $documento);
        $this->caja($orden , $documento);
        $this->reporte($orden , $documento);
    }

    function inventario( $orden , $documento){

        $cantidad = 0;
        $result   = 0;

        foreach ($orden['orden'] as $key => $productos) {

            if(!is_object($productos)){
                $prod_id        =  $productos['producto_id'];
                $prod_bodega    =  $productos['id_bodega'];
                $prod_cantidad  =  $productos['cantidad'];
            }else{
                $prod_id        =  $productos->producto_id;
                $prod_bodega    =  $productos->id_bodega;
                $prod_cantidad  =  $productos->cantidad;
            }            

            $cantidad = $this->get_cantidad_bodega($prod_id, $prod_bodega);
            
            if($documento[0]->efecto_inventario ==1){

                $cantidad_nueva = ($cantidad[0]->Cantidad + $prod_cantidad);

            }else if($documento[0]->efecto_inventario ==2){
                
                $cantidad_nueva = ($cantidad[0]->Cantidad - $prod_cantidad);
            }

            if(isset($cantidad_nueva)){

                $data = array(
                    'Cantidad'	=>  $cantidad_nueva
                );

                $this->db->where('Producto', $prod_id);
                $this->db->where('Bodega', $prod_bodega);
                $result = $this->db->update(self::producto_bodega, $data );
                if(!$result){
                    $result = $this->db->error();
                }
            }
        }
        return $result;
    }

    function devolucionNuevoDocumento( $orden , $documento){

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

    function anulacionCompra( $producto, $bodega , $cantidad_resta){

        $cantidad       = $this->get_cantidad_bodega($producto, $bodega);
        $cantidad_nueva = ($cantidad[0]->Cantidad - $cantidad_resta);
        
        $data = array(
            'Cantidad'	=>  $cantidad_nueva
        );

        $this->db->where('Producto', $producto );
        $this->db->where('Bodega', $bodega );
        $this->db->update(self::producto_bodega, $data );

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