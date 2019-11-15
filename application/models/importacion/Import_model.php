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
}