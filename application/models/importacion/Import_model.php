<?php
class Import_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
	
	function getTablesDb( ){
        $tables = $this->db->list_tables();
        return $tables;
    }
    
    function insert($data){
        //var_dump($data);
        die;
    }
}