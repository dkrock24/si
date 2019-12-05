<?php
class Import_model extends CI_Model {

	const pos_agregar_code_barr = 'pos_agregar_code_barr';
    const producto = 'producto';
    const producto_atrib = 'producto_atributo';
    const producto_valor = 'producto_valor';
    const prouducto_detalle = 'prouducto_detalle';
    const pos_producto_bodega = 'pos_producto_bodega';
    const pos_sucursal = 'pos_sucursal';
    const pos_bodega = 'pos_bodega';
    const categoria = 'categoria';
    const categoria_producto = 'categoria_producto';
    const producto_general = 'producto_general';
    const pos_tipos_impuestos = 'pos_tipos_impuestos';
    const pos_impuesto_categoria = 'pos_impuesto_categoria';
	
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

    function insertarPresentacion($detalle){
        $this->db->insert(self::prouducto_detalle, $detalle );
    }

    function insertProductoBodega($newProduct){

        $bodegas = array(1,2,3,53); //$this->getBodegas();

        foreach ($bodegas as $b) {

            $data = array(
                'Bodega' => $b,
                'Producto' => $newProduct,
                'Cantidad' => 10000,
                'Descripcion' => '',
                'pro_bod_creado' => date('Y-m-d H:i:s'),
                'pro_bod_estado' => 1
            );
            $this->db->insert(self::pos_producto_bodega, $data );
        }
    }

    function getBodegas(){

        $this->db->where('Empresa_Suc',1);
        $this->db->from(self::pos_bodega.' as b');
        $this->db->join(self::pos_sucursal. ' as s',' on s.id_sucursal = b.Sucursal');
        $result = $this->db->get();
        return $result->result();

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

    function get_productos(){

        $this->db->select('*');
        $this->db->from(self::producto);
        $this->db->where('Empresa', $this->session->empresa[0]->id_empresa);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result();
        }
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

    function get_detalle_pivote( $codigo_producto ){
        
        $this->db->select('*');
        $this->db->from(self::producto_general);
        $this->db->where('codigo', $codigo_producto);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function insertCategoriaProducto( $id_producto , $id_subcategoria , $padre ){

       $categoria = $this->getSubCategoria( $id_subcategoria , $padre );

        if($categoria[0]['id_categoria']){
            $data = array(
            'id_categoria' => $categoria[0]['id_categoria'],
            'id_producto' => $id_producto
            );

            $this->db->insert(self::categoria_producto, $data );
        }

    }

    function getSubCategoria( $id_subcategoria , $id_padre ){

        $this->db->select('id_categoria');
        $this->db->from(self::categoria);
        $this->db->where('codigo_subcategoria', $id_subcategoria);
        $this->db->where('codigo_categoria_padre', $id_padre);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function generar_impuestos_categorias($filtro){

        $impuestos = $this->getImpuestos();

        $categorias = $this->getCategorias($filtro);

        foreach ($categorias as $key => $value) {

            $exits = $this->getImpCat($value['id_categoria'] , $filtro['impuesto']);

            if(!$exits){

                $data = array(
                    'Categoria' => $value['id_categoria'],
                    'Impuesto' => $filtro['impuesto'],
                    'estado' => $filtro['activo']
                );
        
                $this->db->insert(self::pos_impuesto_categoria, $data );
            }else{

                if($filtro['actualizar'] == 1){
                    
                    $data = array(
                        'Categoria' => $value['id_categoria'],
                        'Impuesto' => $filtro['impuesto'],
                        'estado' => $filtro['activo']
                    );
            
                    $this->db->update(self::pos_impuesto_categoria, array('id_imp_cat' => $exits[0]->id_imp_cat ) );
                }
            }
        }

    }

    function getImpCat($cat , $imp){

        $this->db->select('*');
        $this->db->from(self::pos_impuesto_categoria);
        $this->db->where('Categoria', $cat ); 
        $this->db->where('Impuesto', $imp);
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }

    }

    function getImpuestos(){

        $this->db->select('*');
        $this->db->from(self::pos_tipos_impuestos);
        $this->db->where('id_tipos_impuestos', 1);  
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }

    function getCategorias($filtro){

        $this->db->select('*');
        $this->db->from(self::categoria);
        $this->db->where('id_categoria_padre !=""'); 
        if($filtro['categoria']!=0){
            $this->db->where('id_categoria', $filtro['categoria']); 
        }   
        $query = $this->db->get(); 
        //echo $this->db->queries[1];
        
        if($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
}