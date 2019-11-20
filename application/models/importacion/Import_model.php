<?php
class Import_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
    const producto_atrib = 'producto_atributo';
    const producto_valor = 'producto_valor';
    const prouducto_detalle = 'prouducto_detalle';
    const pos_producto_bodega = 'pos_producto_bodega';
    const pos_sucursal = 'pos_sucursal';
	
	function getTablesDb(){
        $tables = $this->db->list_tables();
        return $tables;
    }

    function setForeignkey($relaciones){
        if(!empty($relaciones)){
            $this->db->query( $relaciones );
        }
    }

    function runFunctions($accion , $table){
        
        if($table!= "" && $accion != ""){
            $this->db->query( $accion .' '.$table );
            //$query->result();
        }
    }
    
    function insert( $data , $table ){

        $result = 0;

        $result = $this->db->insert($table, $data);
    }

    function insertProductoEncabezado( $producto ){

        $this->db->insert(self::producto, $producto ); 
        return $this->db->insert_id();
    }

    function insertProductoAttributo( $data_pa ){

        $this->db->insert(self::producto_atrib, $data_pa ); 
        return $this->db->insert_id();
    }

    function insertAttributoValor( $data_av){

        $this->db->insert(self::producto_valor, $data_av ); 
        return $this->db->insert_id();
    }

    function Generador( $cnt ){
        $product = $this->product();
        
        unset($product[0]['current_row']);
        unset($product[0]['id_entidad']);
        $product[0]['name_entidad'] = $cnt;

        $this->db->insert(self::producto, $product[0]);
        $newProduct = $this->db->insert_id();

        $detalle = array(
            'Producto' => $newProduct,
            'factor' => 1,
            'presentacion' => 'Unidad',
            'precio' => 100,
            'unidad' => 100,
            'Utilidad' => 50,
            'cod_barra' => rand(),
            'estado_producto_detalle' => 1,
            'fecha_creacion_producto_detalle' => date('Y-m-d H:i:s')
        );
        $this->db->insert(self::prouducto_detalle, $detalle );

        $sucursal = array(
            1,2,3,53
        );

        foreach ($sucursal as $value) {

            $data = array(
                'Bodega' => $value,
                'Producto' => $newProduct,
                'Cantidad' => 100,
                'Descripcion' => 'abc',
                'pro_bod_creado' => date('Y-m-d H:i:s'),
                'pro_bod_estado' => 1
            );
            $this->db->insert(self::pos_producto_bodega, $data );
        }

        $pa = $this->pa();

        foreach ($pa as $key => $value) {
            $data = array(
                'Atributo' => $value['Atributo'],
                'Producto' => $newProduct
            );
            $this->db->insert(self::producto_atrib, $data );
            $proAtr = $this->db->insert_id();

            $pav = $this->pav($value['id_prod_atrri']);

            $data = array(
                'id_prod_atributo' => $proAtr,
                'valor' => $pav[0]['valor']
            );
            $this->db->insert(self::producto_valor, $data );

        }
    }


    function product(){
        $this->db->where('id_entidad',1);
		$this->db->from(self::producto);
		$result = $this->db->get();
        return $result->result_array();
    }

    function pa(){
        $this->db->where('Producto',1);
		$this->db->from(self::producto_atrib);
		$result = $this->db->get();
        return $result->result_array();
    }

    function pav($id){
        $this->db->where('id_prod_atributo',$id);
		$this->db->from(self::producto_valor);
		$result = $this->db->get();
        return $result->result_array();
    }
}