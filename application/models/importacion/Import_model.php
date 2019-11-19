<?php
class Import_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
    const producto_atrib = 'producto_atributo';
    const producto_valor = 'producto_valor';
	
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